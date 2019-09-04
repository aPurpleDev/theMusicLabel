<?php

namespace App\EventSubscriber;

use App\Event\NewsEvent;
use App\Event\SubEvent;
use App\Repository\UserRepository;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NewsUserSubscriber implements EventSubscriberInterface
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
     * @var UserRepository
     */
    private $userRepository;

    /**
     * RegisterListener constructor.
     * @param $mailer
     */
    public function __construct(Swift_Mailer $mailer, $adminMail, UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
        $this->userRepository = $userRepository;
    }

    public function attach(SubEvent $subEvent)
    {
        $artist = $subEvent->getArtist();
        $user = $subEvent->getUser();

        $artist->attach($user);
        $user->addArtist($artist);
    }

    public function sendMailNews(NewsEvent $newsEvent)
    {
//        $user = $newsEvent->getUser();
//        $news = $newsEvent->getNews();
        $artist = $newsEvent->getArtist();
        $artist->notify();
//        $users = $this->userRepository->findUserByArtist($news->getArtist());
//        foreach ($users as $user) {
//            $user->
//            $a = (new Swift_Message('Hello '.$user->getFirstName()))
//                ->setFrom($this->adminMail)
//                ->setTo($user->getEmail())
//                ->setBody($news->getContent());
//
//            $this->mailer->send($a);
//        }

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
                'attach', -10
            ],
            NewsEvent::NAME => [
                'sendMailNews', -10
            ],
        ];
    }

}