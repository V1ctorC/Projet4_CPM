<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketingController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function homepage(Request $request)
    {
        $ticket = new Ticket();
        $em = $this->getDoctrine()->getManager();

        $ticket->setType('1 journée');
        $nombreTicket = 0;

        return $this->render('Ticketing/homepage.html.twig');
    }

    /**
     * @Route ("/contact_information")
     */

    public function contactInformation(Request $request, Session $session)
    {
        $number = $request->request->get('number');
        $dateVisit = $request->request->get('dateVisit');
        $ticketType = $request->request->get('ticketType');
        $user = new User();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($user);
            $em->flush();
            $userID = $user->getId();

            $session->set('userID', $userID);


            return $this->redirectToRoute('app_ticketing_summary');
        }

        return $this->render('Ticketing/contactInformation.html.twig', array(
            'form' => $form->createView(), 'number' => $number, 'dateVisit' => $dateVisit, 'ticketType' => $ticketType
        ));
    }

    /**
     * @Route ("/summary")
     */
    public function summary(Session $session)
    {
        $userID = $session->get('userID');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->find($userID);




        return $this->render('Ticketing/summary.html.twig', array('user'=>$user));
    }
}