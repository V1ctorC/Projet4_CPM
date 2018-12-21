<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Information;
use App\Form\BookingType;
use App\Form\InformationType;
use App\Service\CalculationDate;
use App\Service\Mailer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketingController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function homepage(Request $request, Session $session, CalculationDate $calculationDate)
    {
        $booking = new Booking();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        $listBooking = $em->getRepository(Booking::class)->findBy(array('bookingday' => $booking->getBookingday()));
        if ($calculationDate->ticketsSold($listBooking) == false)
        {
            return $this->redirectToRoute('errorDay');
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $calculationDate->generateBookingNumber($booking);
            $session->set('booking', $form->getData());

            return $this->redirectToRoute('contactInfo');
        }

        return $this->render('Ticketing/homepage.html.twig', array('form'=>$form->createView()));
    }


    /**
     * @Route ("/contact_information", name="contactInfo")
     */
    public function contactInformation(Request $request, Session $session, CalculationDate $calculationDate)
    {
        $booking = $session->get('booking');
        $quantity = $booking->getQuantity();

        for ($i = 0; $i < $quantity; $i++)
        {
            $user[$i] = new Information();
        }

        $form = $this->createForm(CollectionType::class, $user, ['entry_type' => InformationType::class]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $calculationDate->addAgePrice($user, $booking);
            $session->set('user', $user);

            return $this->redirectToRoute('summary');
        }

        return $this->render('Ticketing/contactInformation.html.twig', array(
            'form' => $form->createView()));
    }


    /**
     * @Route ("/summary", name="summary")
     */
    public function summary(Session $session, CalculationDate $calculationDate)
    {
        $user = $session->get('user');
        $sum = $calculationDate->calculationSum($user);

        if ($sum< 4)
        {
            return $this->redirectToRoute('errorPrice');
        }

        $session->set('sum', $sum);

        return $this->render('Ticketing/summary.html.twig', array('user'=>$user, 'sum'=>$sum));
    }


    /**
     * @Route ("/payment", name="payment")
     */
    public function paymentAction(Request $request, Session $session, Mailer $mailer, CalculationDate $calculationDate)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $session->get('booking');
        $user = $session->get('user');
        $sum = $session->get('sum');

        \Stripe\Stripe::setApiKey("sk_test_rAGQCR0jx66px1wmcyb3me6U");
        $token = $request->request->get('stripeToken');
        $to = $request->request->get('stripeEmail');

        $stripePayment = $calculationDate->tryStripe($token, $sum, $to, $booking);

        if ($stripePayment != true)
        {
            return $this->redirectToRoute('summary');
        }

        for ($i=0; $i<$booking->getQuantity();$i++)
        {
            $customer = $user[$i];
            $em->persist($customer);
        }
        $em->persist($booking);
        $em->flush();

        $mailer->sendTicket($to, $user, $sum, $booking);

        return $this->redirectToRoute('erase');
    }


    /**
     * @Route ("/ajax")
     */
    public function ajaxDay(Request $request)
    {
        $post = $request->request->get('field');
        $timestamp = strtotime($post);
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $ticketSoldDay = $repository->findBy(
            ['bookingday' => $date ]
        );
        $nbVisitors = 0;
        foreach ($ticketSoldDay as $booking)
        {
            $visitor = $booking->getQuantity();
            $nbVisitors = $nbVisitors + $visitor;
        }

        if ($nbVisitors < 1000)
        {
            return new Response('Ok');
        }
        else
        {
            throw new \Exception('Something went wrong!');
        }

    }

    /**
     * @Route ("/erase", name="erase")
     */
    public function cancelAction(Session $session)
    {
        $session->invalidate();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route ("/errorDay", name="errorDay")
     */
    public function errorDay()
    {
        return $this->render('Error/errorDay.html.twig');
    }

    /**
     * @Route ("/errorPrice", name="errorPrice")
     */
    public function errorPrice()
    {
        return $this->render('Error/errorPrice.html.twig');
    }

    /**
     * @Route ("/errorDate", name="errorDate")
     */
    public function errorDate()
    {
        return $this->render('Error/errorDate.html.twig');
    }

}