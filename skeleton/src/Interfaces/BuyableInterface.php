<?php

namespace App\Interfaces;

/**
 * Interface BuyableInterface
 * @package App\Interfaces
 */
interface BuyableInterface
{
    function getPrice();
    function getBuyableName();
}