<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Information;
use App\Form\BookingType;
use App\Form\InformationType;
use App\Service\CalculationDate;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketingController extends AbstractController
{

    /**
     * @Route("/")
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

            return $this->redirectToRoute('app_ticketing_contactinformation');
        }

        return $this->render('Ticketing/homepage.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route ("/contact_information")
     */

    public function contactInformation(Request $request, Session $session, CalculationDate $calculationDate)
    {
        $booking = $session->get('booking');
        $quantity = $booking->getQuantity();

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
                $customer->setPrice($calculationDate->priceAge($customer->getAge(), $customer->getReducedprice()));
                $customer->setIdbooking($booking);
                $em->persist($customer);
            }
            $em->flush();
            $session->set('user', $user);

            return $this->redirectToRoute('app_ticketing_summary');
        }

        return $this->render('Ticketing/contactInformation.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route ("/summary")
     */
    public function summary(Session $session, CalculationDate $calculationDate)
    {
        $counter = 0;
        $user = $session->get('user');
        $sum = 0;

        foreach ($user as $customer)
        {
            $price = $customer->getPrice();
            $sum = $sum + $price;

        }



        /*$user = $session->get('user');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(Information::class)->find($userID);
        dump($userID);
        /*$datenaissance = $user->getBirthdate();

        $age = $calculationDate->getAge($datenaissance);
        $price = $calculationDate->priceAge($age);*/



        return $this->render('Ticketing/summary.html.twig', array('user'=>$user, 'sum'=>$sum, 'counter'=>$counter));
    }
}