<?php

namespace App\EventSubscriber;

use App\Event\OrderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderUserSubscriber implements EventSubscriberInterface
{
    private $mailer;

    /**
     * OrderUserSubscriber constructor.
     * @param $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailOnNewOrder()
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            OrderEvent::NAME => [
                'sendMailOnNewOrder', -10
            ]
        ];
    }


}