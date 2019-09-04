<?php

namespace App\Event;

use App\Entity\Artist;
use App\Entity\News;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class NewsEvent extends Event
{
    const NAME = 'news.add';

    /**
     * @var Artist
     */
    private $artist;
//
//    private $user;

    private $news;

    /**
     * RegisterEvent constructor.
     * @param Artist $artist
     */
    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
//        $this->user = $user;
//        $this->news = $news;
    }

    /**
     * @return News
     */
    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->artist;
    }
//
//    /**
//     * @return User
//     */
//    public function getUser(): User
//    {
//        return $this->user;
//    }
    
}