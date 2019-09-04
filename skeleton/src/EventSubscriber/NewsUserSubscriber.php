<?php

namespace App\EventSubscriber;

use App\Event\NewsEvent;
use App\Event\SubEvent;
use App\Event\UnsubEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewsUserSubscriber implements EventSubscriberInterface
{

    public function sub(SubEvent $subEvent)
    {
        $artist = $subEvent->getArtist();
        $user = $subEvent->getUser();

        $artist->attach($user);
        $user->addArtist($artist);
    }

    public function sendMailNews(NewsEvent $newsEvent)
    {
        $artist = $newsEvent->getArtist();
        $artist->notify();
    }

    public function unsub(UnsubEvent $unsubEvent)
    {
        $artist = $unsubEvent->getArtist();
        $user = $unsubEvent->getUser();

        $artist->detach($user);
        $user->removeArtist($artist);
    }


    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            SubEvent::NAME => [
                'sub', -10
            ],
            NewsEvent::NAME => [
                'sendMailNews', -10
            ],
            UnsubEvent::NAME => [
                'unsub', -10
            ]
        ];
    }

}