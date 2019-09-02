<?php

namespace App\EventListener;

class RegisterListener
{
    private $mailer;

    private $user;

    /**
     * RegisterListener constructor.
     * @param $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailToUser()
    {
        $message = (new \Swift_Message('Hello'))
            ->setFrom('themusic@label.com')
            ->setTo('14a0577f61-54f64c@inbox.mailtrap.io')
            ->setBody('Welcome to theMusicLabel Corp, 
            We are pleased to have you joining us, I hope you will enjoy & listen to every tracks available. 
            Greetings.');

        $this->mailer->send($message);
    }

}