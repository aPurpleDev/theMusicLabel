<?php

namespace App\Event;

use App\Entity\Artist;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UnsubEvent extends Event
{
    const NAME = 'unsub.add';

    /**
     * @var Artist
     */
    private $artist;

    private $user;

    /**
     * RegisterEvent constructor.
     * @param Artist $artist
     * @param User $user
     */
    public function __construct(Artist $artist, User $user)
    {
        $this->artist = $artist;
        $this->user = $user;
    }

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->artist;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}