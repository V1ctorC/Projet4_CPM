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


            $session->set('booking', $form->getData());

            return $this->redirectToRoute('app_ticketing_contactinformation');
        }

        return $this->render('Ticketing/homepage.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route ("/contact_information")
     */

    public function contactInformation(Request $request, Session $session)
    {

        $booking = $session->get('booking');
        $quantity = $booking->getBookingNumber();

        for ($i = 0; $i < 3; $i++)
        {
            $user[$i] = new Information();
        }

        //$user = new Information();
        $em = $this->getDoctrine()->getManager();

        //$form = $this->createForm(InformationType::class, $user);
        $form = $this->createForm(CollectionType::class, $user, ['entry_type' => InformationType::class]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('app_ticketing_summary');
        }

        dump($form);

        return $this->render('Ticketing/contactInformation.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route ("/summary")
     */
    public function summary(Session $session, CalculationDate $calculationDate)
    {
        $userID = $session->get('userID');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(Information::class)->find($userID);
        $datenaissance = $user->getBirthdate();

        $age = $calculationDate->getAge($datenaissance);
        $price = $calculationDate->priceAge($age);



        return $this->render('Ticketing/summary.html.twig', array('user'=>$user, 'age' => $age, 'price' => $price));
    }
}