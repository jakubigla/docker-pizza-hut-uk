<?php

namespace PizzaHut;

use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\Selenium2Driver;

/**
 * Class PizzaHutOrder
 *
 * @package PizzaHut
 * @author Jakub Igla <jakub.igla@gmail.com>
 */
class PizzaHutOrder
{
    const URL = 'http://www.pizzahut.co.uk';

    /** @var Mink */
    private $mink;

    /** @var array */
    private $config;

    /** @var string */
    private $orderId;

    public function __construct()
    {
        $this->config = \yaml_parse(file_get_contents('config.yml'));
        $this->orderId = \date('Y_m_d_H_i');

        if (! $this->config['payment']['securityCode']) {
            $this->config['payment']['securityCode'] = \readline('Please provide CVC code: ');
        }

        $this->mink = new Mink([
            'selenium' => new Session(new Selenium2Driver(
                'chrome',
                null,
                'http://chrome:4444/wd/hub'
            ))
        ]);

        $this->mink->setDefaultSessionName('selenium');
        $this->mink->getSession()->visit(self::URL);

        $page = $this->mink->getSession()->getPage();

        $page->find('css', 'form .search')->setValue($this->config['delivery']['postcode']);
        $page->find('css', 'button[data-synth="button--delivery"]')->click();
        \sleep(5);

        if (\strpos($page->getText(), 'You can order for later.') !== false) {
            $this->throwMsg('Your local restaurant is not opened yet');
        }

        $this->screenShot('Start');
    }

    public function make(): void
    {
        try {
            foreach ($this->config['orders'] as $orderId => $order) {
                $orderName    = \key($order);
                $orderOptions = $order[$orderName];
                $orderClass   = '\PizzaHut\Order\\' . $orderName;

                /** @var OrderInterface $order */
                $order = new $orderClass;

                $order->make($this->mink, $orderOptions);
                $this->screenShot(($orderId + 1). '. ' . $orderName);
            }

            $this->checkout();

            \sleep(5);
            $this->screenShot('Final');
        } catch (\Throwable $e) {
            $this->screenShot('Error');
            throw $e;
        }
    }

    private function checkout()
    {
        $this->mink->getSession()->visit(self::URL . '/order/checkout/');
        $page = $this->mink->getSession()->getPage();

        //fill delivery info
        foreach ($this->config['delivery'] as $fieldName => $fieldValue) {
            $page->findField($fieldName)->setValue($fieldValue);
        }

        //pay by card
        $page->find('css', 'div[data-synth="tab--card"]')->click();
        //no marketing
        $page->findField('marketing')->setValue("false");

        $this->screenShot('Delivery');

        $page->find('css', '#submit-checkout')->click();
        \sleep(5);
        $this->mink->getSession()->getDriver()->switchToIFrame('wp-cl-custom-html-iframe');
        $page = $this->mink->getSession()->getPage();
        //fill payment info
        foreach ($this->config['payment'] as $fieldName => $fieldValue) {
            $page->findField($fieldName)->setValue($fieldValue);
        }
        $this->screenShot('Payment');
        $page->find('css', '#submitButton')->click();
        \sleep(15);
        echo $page->getHtml();
        $this->mink->getSession()->getDriver()->switchToIFrame();
    }

    private function screenShot($name): void
    {
        $path = \realpath(\getcwd() . '/screenshots') . DIRECTORY_SEPARATOR . $this->orderId;
        @\mkdir($path, 0755, true);
        $screenShot = $this->mink->getSession()->getDriver()->getScreenshot();
        \file_put_contents($path . DIRECTORY_SEPARATOR . $name . '.png', $screenShot);
        echo "ScreenShot done: " . $name . PHP_EOL;
    }

    /**
     * @param string $msg
     *
     * @return void
     */
    private function throwMsg(string $msg): void
    {
        $this->screenShot('last');
        echo \str_pad('', \strlen($msg) + 4, '-') . PHP_EOL;
        echo \printf("| %s |", $msg) . PHP_EOL;
        echo \str_pad('', \strlen($msg) + 4, '-') . PHP_EOL;
        exit(1);
    }
}
