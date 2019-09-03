<?php

namespace App\EventSubscriber;

use App\Event\OrderEvent;
use App\Event\RegisterEvent;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RegisterUserSubscriber
 * @package App\EventSubscriber
 */
class RegisterUserSubscriber implements EventSubscriberInterface
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
     * @param $mailer
     */
    public function __construct(Swift_Mailer $mailer, $adminMail)
    {
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
    }

    /**
     * @param RegisterEvent $event
     */
    public function sendMailToNewlyRegisteredUser(RegisterEvent $event)
    {
        $user = $event->getUser();

        $a = (new Swift_Message('Hello '.$user->getFirstName()))
            ->setFrom($this->adminMail)
            ->setTo($user->getEmail())
            ->setBody('Welcome to theMusicLabel Corp, We are pleased to have you joining us, I hope you will enjoy & listen to every tracks available. Greetings.');

        $this->mailer->send($a);
    }

    /**
     * @param OrderEvent $event
     */
    public function sendMailOnNewOrder(OrderEvent $event)
    {
        $user = $event->getUser();

        $a = (new Swift_Message('Hello '.$user->getFirstName()))
            ->setFrom($this->adminMail)
            ->setTo($user->getEmail())
            ->setBody('Welcome to theMusicLabel Corp, We are pleased to have you joining us, I hope you will enjoy & listen to every tracks available. Greetings.');

        $this->mailer->send($a);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            RegisterEvent::NAME => [
                'sendMailToNewlyRegisteredUser', -10
            ],
            OrderEvent::NAME => [
                'sendMailOnNewOrder', -10
            ]
        ];
    }
}