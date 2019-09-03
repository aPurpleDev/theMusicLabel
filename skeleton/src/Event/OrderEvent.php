<?php

namespace App\Event;

use App\Entity\Orders;
use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    const NAME = 'user.orders';

    private $order;

    /**
     * OrderEvent constructor.
     * @param $order
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    /**
     * @return Orders
     */
    public function getOrder(): Orders
    {
        return $this->order;
    }


}