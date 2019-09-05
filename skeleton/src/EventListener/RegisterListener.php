<?php

namespace App\EventListener;

use Swift_Mailer;
use Swift_Message;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class RegisterListener
 * @package App\EventListener
 */
class RegisterListener
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var
     */
    private $adminMail;

    /**
     * RegisterListener constructor.
     * @param Swift_Mailer $mailer
     * @param $adminMail
     */
    public function __construct(Swift_Mailer $mailer, $adminMail)
    {
        $this->mailer = $mailer;$this->adminMail;
        $this->adminMail = $adminMail;
    }

    /**
     * @param Event $event
     */
    public function sendMailToUser(Event $event)
    {
        $user = $event->getUser();

        $message = (new Swift_Message('Hello '.$user->getFirstName()))
            ->setFrom($this->adminMail)
            ->setTo($user->getEmail())
            ->setBody('Welcome to theMusicLabel Corp, 
            We are pleased to have you joining us, I hope you will enjoy & listen to every tracks available. 
            Greetings.');

        $this->mailer->send($message);
    }

}