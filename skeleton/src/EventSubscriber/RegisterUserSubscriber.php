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

    public function sendMailToNewlyRegisteredUser()
    {
        $a = (new \Swift_Message('Hello'))
            ->setFrom('ok@test.fr')
            ->setTo('14a0577f61-54f64c@inbox.mailtrap.io')
            ->setBody('Here is the message itself');

        $this->mailer->send($a);
    }

    public function sendMailOnNewOrder()
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            RegisterEvent::NAME => [
                'sendMailToUser', -10
            ],
            OrderEvent::NAME => [
                'sendMailOnNewOrder', -10
            ]
        ];
    }
}