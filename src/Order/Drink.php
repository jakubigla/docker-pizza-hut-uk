<?php

namespace PizzaHut\Order;

use Behat\Mink\Mink;
use PizzaHut\OrderInterface;
use PizzaHut\PizzaHutOrder;

/**
 * Class Drink
 *
 * @package PizzaHut\Order
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class Drink implements OrderInterface
{
    public function make(Mink $mink, array $options): void
    {
        $mink->getSession()->visit(PizzaHutOrder::URL . '/order/drinks/');
        sleep(5);
        $page = $mink->getSession()->getPage();
        $synthValue = 'link--' . $options['type'];
        $page->find('css', 'div[data-synth="' . $synthValue . '"]')->click();
        sleep(1);
        $page->find('css', 'button[data-synth="button--add-to-basket"]')->click();
    }
}
