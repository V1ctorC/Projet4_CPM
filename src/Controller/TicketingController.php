<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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