<?php

namespace App\EventSubscriber;

//use App\Entity\Artist;
use App\Event\NewsEvent;
//use SplObserver;
//use SplSubject;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NewsUserSubscriber extends AbstractExtension implements EventSubscriberInterface
{

    public function getFunctions()
    {
        return array(
            new TwigFunction('attach', array($this, 'attach')),
        );
    }


    public function attach(NewsEvent $newsEvent)
    {
        $artist = $newsEvent->getArtist();
        $user = $newsEvent->getUser();

        $artist->attach($user);
        $user->addArtist($artist);
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
            NewsEvent::NAME => [
                'attach', -10
            ],
        ];
    }


}