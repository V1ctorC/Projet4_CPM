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

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMessage($to, $subject, $body)
    {
        $mail = (new \Swift_Message())
            ->setFrom('test.vetudes@gmail.com')
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body, 'text/html');

        $this->mailer->send($mail);
    }

    public function sendTicket()
    {
        $subject = "Test envoie d'un mail";
        $body = "Test du body";

        $this->sendMessage('victor.du.77@hotmail.fr', $subject, $body);
    }
}