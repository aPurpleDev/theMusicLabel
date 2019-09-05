<?php

namespace App\Event;

use App\Entity\Orders;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class OrderEvent
 * @package App\Event
 */
class OrderEvent extends Event
{
    /**
     *
     */
    const NAME = 'user.order';

    /**
     * @var Orders
     */
    private $order;
    /**
     * @var User
     */
    private $user;

    /**
     * OrderEvent constructor.
     * @param Orders $orders
     * @param User $user
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