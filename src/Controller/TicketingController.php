<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class TicketingController
{

    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Page accueil du site');
    }

}