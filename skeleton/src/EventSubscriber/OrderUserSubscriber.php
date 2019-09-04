<?php

namespace App\EventSubscriber;

use App\Event\OrderEvent;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RegisterUserSubscriber
 * @package App\EventSubscriber
 */
class OrderUserSubscriber implements EventSubscriberInterface
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
     * @param OrderEvent $event
     */
    public function sendMailOnNewOrder(OrderEvent $event)
    {
        $user = $event->getUser();
        $order = $event->getOrder();

        $a = (new Swift_Message('Hello '.$user->getFirstName()))
            ->setFrom($this->adminMail)
            ->setTo($user->getEmail())
            ->setBody('Thank your for your Order n°.'.$order->getOrderNumber().' d"un montant de : '.$order->getTotalPrice().'. Merci.');

        $this->mailer->send($a);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            OrderEvent::NAME => [
                'sendMailOnNewOrder', -1
            ]
        ];
    }
}