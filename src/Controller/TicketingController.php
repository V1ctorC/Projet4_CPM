<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
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

    public function contactInformation(Request $request)
    {
        $number = $request->request->get('number');
        $azerty = $request->request->get('azerty');
        $ticketType = $request->request->get('ticketType');
        $user = new User();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
        }

        return $this->render('Ticketing/contactInformation.html.twig', array(
            'form' => $form->createView(), 'number' => $number, 'azerty' => $azerty, 'ticketType' => $ticketType
        ));
    }

    /**
     * @Route ("/summary")
     */
    public function summary()
    {
        return $this->render('Ticketing/summary.html.twig');
    }
}