<?php

namespace App\Event;

use App\Entity\Artist;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class NewsEvent
 * @package App\Event
 */
class NewsEvent extends Event
{
    /**
     *
     */
    const NAME = 'news.add';

    /**
     * @var Artist
     */
    private $artist;


    /**
     * RegisterEvent constructor.
     * @param Artist $artist
     */
    public function __construct(Artist $artist)
    {
        $this->artist = $artist;

    }


    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->artist;
    }

    
}