<?php

namespace PizzaHut\Order;

use Behat\Mink\Mink;
use PizzaHut\OrderInterface;
use PizzaHut\PizzaHutOrder;

/**
 * Class Pizza
 *
 * @package PizzaHut\Order
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class Pizza implements OrderInterface
{
    public function make(Mink $mink, array $options): void
    {
        $mink->getSession()->visit(PizzaHutOrder::URL . '/order/pizzas/');
        sleep(1);
        $page = $mink->getSession()->getPage();
        $synthValue = 'link--' . $options['type'] . '-italian-small';
        $page->find('css', 'div[data-synth="' . $synthValue . '"]')->click();
        //sleep(3);
        $page->find('css', 'div[data-synth="add--' . strtolower($options['size']) . '"]')->click();
        $page->find('css', 'div[data-synth="add--' . strtolower($options['crust']) . '"]')->click();
        //sleep(1);
        $page->find('css', 'button[data-synth="button--add-to-basket"]')->click();
    }
}
