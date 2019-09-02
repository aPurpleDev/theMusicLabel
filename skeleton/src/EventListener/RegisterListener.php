<?php

namespace App\EventListener;

class RegisterListener
{
    private $mailer;

    /**
     * RegisterListener constructor.
     * @param $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailToUser(array $body)
    {
        $message = (new \Swift_Message($body['subject']))
            ->setFrom('ok@test.fr')
            ->setTo('14a0577f61-54f64c@inbox.mailtrap.io')
            ->setBody($body['content']);

        $this->mailer->send($message);
    }

}