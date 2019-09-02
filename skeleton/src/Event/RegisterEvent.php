<?php

namespace App\Event;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class RegisterEvent
 * @package App\Event
 */
class RegisterEvent extends Event
{
    /**
     *
     */
    const NAME = 'user.register';

    /**
     * @var User
     */
    private $user;

    /**
     * RegisterEvent constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}