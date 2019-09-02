<?php

namespace App\EventSubscriber;

use App\Event\OrderEvent;
use App\Event\RegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegisterUserSubscriber implements EventSubscriberInterface
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

    public function sendMailToNewlyRegisteredUser($user)
    {
        $a = (new \Swift_Message('Hello '.$user['name']))
            ->setFrom('themusic@label.com')
//            ->setTo('$user['email']')
            ->setTo('14a0577f61-54f64c@inbox.mailtrap.io')
            ->setBody('Welcome to theMusicLabel Corp, We are pleased to have you joining us, I hope you will enjoy & listen to every tracks available. Greetings.');

        $this->mailer->send($a);
    }

    public function sendMailOnNewOrder()
    {
        $a = (new \Swift_Message('Hello '.$user['name']))
            ->setFrom('themusic@label.com')
//            ->setTo('$user['email']')
            ->setTo('14a0577f61-54f64c@inbox.mailtrap.io')
            ->setBody('Welcome to theMusicLabel Corp, We are pleased to have you joining us, I hope you will enjoy & listen to every tracks available. Greetings.');

        $this->mailer->send($a);
    }

    public static function getSubscribedEvents()
    {
        return [
//            RegisterEvent::NAME => [
//                'sendMailToNewlyRegisteredUser', -10
//            ],
            OrderEvent::NAME => [
                'sendMailOnNewOrder', -10
            ]
        ];
    }
}