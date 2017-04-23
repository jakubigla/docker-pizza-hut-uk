<?php

namespace PizzaHut\Order;

use Behat\Mink\Mink;
use PizzaHut\OrderInterface;
use PizzaHut\PizzaHutOrder;

/**
 * Class Side
 *
 * @package PizzaHut\Side
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class Side implements OrderInterface
{
    public function make(Mink $mink, array $options): void
    {
        $mink->getSession()->visit(PizzaHutOrder::URL . '/order/sides/');
        sleep(5);
        $page = $mink->getSession()->getPage();
        $synthValue = 'link--' . $options['type'] . '-single';
        $page->find('css', 'div[data-synth="' . $synthValue . '"]')->click();
        sleep(1);

        if (\strpos($page->getText(), 'Choose your free dip') !== false) {
            $synthValue = 'add--' . $options['dip'] . '-single';
            $page->find('css', 'div[data-synth="' . $synthValue . '"]')->click();
        }

        $page->find('css', 'button[data-synth="button--add-to-basket"]')->click();
    }
}
