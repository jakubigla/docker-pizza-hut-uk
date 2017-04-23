<?php

namespace PizzaHut;

use Behat\Mink\Mink;

/**
 * Interface OrderInterface
 *
 * @package PizzaHut
 */
interface OrderInterface
{
    /**
     * @param Mink  $mink
     * @param array $options
     *
     * @return void
     */
    public function make(Mink $mink, array $options): void;
}
