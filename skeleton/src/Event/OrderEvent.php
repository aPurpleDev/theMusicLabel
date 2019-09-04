<?php

namespace App\Event;

use App\Entity\Orders;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    const NAME = 'user.order';

    private $order;
    /**
     * @var User
     */
    private $user;

    /**
     * OrderEvent constructor.
     * @param $order
     */
    public function __construct(Orders $orders, User $user)
    {
        $this->order = $orders;
        $this->user = $user;
    }

    /**
     * @return Orders
     */
    public function getOrder(): Orders
    {
        return $this->order;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


}