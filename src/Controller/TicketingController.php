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
    public function homepage(Request $request, Session $session)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $bookingNumber = substr(str_shuffle(str_repeat($characters, 10)), 0, 10);
            $booking->setBookingnumber($bookingNumber);

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
        $ticketType = $booking->getType();
        $counterForm = 0;

        for ($i = 0; $i < $quantity; $i++)
        {
            $user[$i] = new Information();
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(CollectionType::class, $user, ['entry_type' => InformationType::class]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($booking);

            for ($i=0;$i<$quantity;$i++)
            {
                $customer = $user[$i];
                $customer->setAge($calculationDate->getAge($customer->getBirthdate()));
                $priceDay = ($calculationDate->priceAge($customer->getAge(), $customer->getReducedprice()));
                $customer->setPrice($calculationDate->priceTicketType($priceDay, $ticketType));
                $customer->setIdbooking($booking);
                $em->persist($customer);
            }
            $em->flush();
            $session->set('user', $user);

            return $this->redirectToRoute('summary');
        }

        return $this->render('Ticketing/contactInformation.html.twig', array(
            'form' => $form->createView(), 'counterForm' => $counterForm));
    }



    /**
     * @Route ("/summary", name="summary")
     */
    public function summary(Session $session, CalculationDate $calculationDate, Request $request)
    {
        $counter = 0;
        $sum = 0;
        $user = $session->get('user');


        $firstUser = $user[0];
        $bookingId = $firstUser->getIdbooking()->getId();
        $session->set('bookingId', $bookingId);

        foreach ($user as $customer)
        {
            $price = $customer->getPrice();
            $sum = $sum + $price;
        }

        $session->set('sum', $sum);


        return $this->render('Ticketing/summary.html.twig', array('user'=>$user, 'sum'=>$sum, 'counter'=>$counter));
    }

    /**
     * @Route ("/payment", name="payment")
     */
    public function paymentAction(Request $request, Session $session, Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();

        $bookingId = $session->get('bookingId');
        $booking = $em->getRepository(Booking::class)->find($bookingId);
        $sum = $session->get('sum');
        $sumStripe = $sum * 100;


        \Stripe\Stripe::setApiKey("sk_test_rAGQCR0jx66px1wmcyb3me6U");

        $token = $request->request->get('stripeToken');
        $to = $request->request->get('stripeEmail');

        try
        {
            $charge = \Stripe\Charge::create([
                'amount' => $sumStripe,
                'currency' => 'eur',
                'description' => 'Musée du Louvre',
                'source' => $token,
            ]);
            $booking->setMail($to);
            $booking->setPaid(true);
            $em->persist($booking);
            $em->flush();

        } catch (\Stripe\Error\Card $e) {

            return $this->redirectToRoute('summary');

        }
        $user = $session->get('user');
        $mailer->sendTicket($to, $user, $sum, $booking);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route ("/ajax")
     */
    public function ajaxDay(Request $request)
    {
        $post = $request->request->get('field');
        $repository = $this->getDoctrine()->getRepository(Booking::class);
        $ticketSoldDay = $repository->findBy(
            ['bookingday' => $post]
        );
        $nbVisitors = 0;
        foreach ($ticketSoldDay as $booking)
        {
            $isPaid = $booking->getPaid();
            if ($isPaid == 1)
            {
                $visitor = $booking->getQuantity();
                $nbVisitors = $nbVisitors + $visitor;
            }
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
     * @Route ("/cancel", name="cancel")
     */
    public function cancelAction(Session $session)
    {
        $session->invalidate();

        return $this->redirectToRoute('homepage');
    }
}