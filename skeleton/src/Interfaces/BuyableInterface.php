<?php

namespace App\Interfaces;

/**
 * Interface BuyableInterface
 * @package App\Interfaces
 */
interface BuyableInterface //abstract dependency for the orderlog entity, which can contain an album or event (our 2 products)
{
    function getPrice();

    function getBuyableName();
}