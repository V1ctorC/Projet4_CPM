<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-14
 * Time: 14:36
 */

namespace App\Service;


class Mailer
{
    protected $mailer;
    protected $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendMessage($to, $subject, $body)
    {
        $mail = (new \Swift_Message())
            ->setFrom(['test.vetudes@gmail.com' => 'Musée du Louvre'])
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body, 'text/html');

        $this->mailer->send($mail);
    }

    public function sendTicket($to, $user, $sum, $booking, $logo)
    {
        $subject = "Votre billet pour le musée du Louvre";
        $body = $this->templating->render('Mail/ticket.html.twig', array(
            'user' => $user,
            'sum' => $sum,
            'booking' => $booking,
            'logo' => $logo
            ));

        $this->sendMessage($to, $subject, $body);
    }
}