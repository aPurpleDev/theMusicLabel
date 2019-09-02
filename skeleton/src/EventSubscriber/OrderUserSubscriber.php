<?php

namespace App\EventSubscriber;

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


}