<?php

namespace PizzaHut\Order;

use Behat\Mink\Mink;
use PizzaHut\OrderInterface;
use PizzaHut\PizzaHutOrder;

/**
 * Class PizzaOfTheDay
 *
 * @package PizzaHut\Order
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class PizzaOfTheDay implements OrderInterface
{
    public function make(Mink $mink, array $options): void
    {
        $mink->getSession()->visit(PizzaHutOrder::URL . '/order/deals/');
        sleep(1);
        $page = $mink->getSession()->getPage();
        $synthValue = 'link--pizza-of-the-day-' . strtolower(date('l'));
        $page->find('css', 'a[data-synth="' . $synthValue . '"]')->click();
        $page->find('css', 'div[data-synth="add--' . strtolower($options['size']) . '"]')->click();
        $page->find('css', 'div[data-synth="add--' . strtolower($options['crust']) . '"]')->click();
        //sleep(1);
        $page->find('css', 'button[data-synth="button--add-to-basket"]')->click();
    }
}
