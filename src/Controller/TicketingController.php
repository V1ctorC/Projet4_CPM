<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TicketingController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function homepage()
    {
        return $this->render('Ticketing/homepage.html.twig');
    }

    /**
     * @Route ("/contact_information")
     */
    public function contactInformation()
    {
        return $this->render('Ticketing/contactInformation.html.twig');
    }

    /**
     * @Route ("/summary")
     */
    public function summary()
    {
        return $this->render('Ticketing/summary.html.twig');
    }
}