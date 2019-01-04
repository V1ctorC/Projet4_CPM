<?php
/**
 * Created by PhpStorm.
 * User: VictorChevalier
 * Date: 2018-12-14
 * Time: 14:36
 */

namespace App\Service;


use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    protected $templating;

    public function __construct(\Twig_Environment $templating)
    {
        $this->templating = $templating;
    }

    public function sendMessage($to, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        //ONLY LOCAL

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test.vetudes@gmail.com';
        $mail->Password = 'test2018';
        $mail->Port= 465;
        $mail->SMTPSecure = 'ssl';
        
        $mail->setFrom('test.vetudes@gmail.com', 'Musée du Louvre');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();

    }

    public function sendTicket($to, $user, $sum, $booking)
    {

        $subject = "Votre billet pour le musée du Louvre";
        $body = $this->templating->render('Mail/ticket.html.twig', array(
            'user' => $user,
            'sum' => $sum,
            'booking' => $booking
            ));

        $this->sendMessage($to, $subject, $body);
    }



}