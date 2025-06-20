<?php

use PHPUnit\Framework\TestCase;
use Acme\Basket;
use Acme\Offers\BuyOneGetSecondHalfPrice;

class BasketTest extends TestCase {
    public function createBasket(): Basket {
        $catalogue = [
            'R01' => 32.95,
            'G01' => 24.95,
            'B01' => 7.95
        ];

        $deliveryRules = [
            50 => 4.95,
            90 => 2.95,
            PHP_INT_MAX => 0.00
        ];

        $offers = [new BuyOneGetSecondHalfPrice('R01')];
        return new Basket($catalogue, $deliveryRules, $offers);
    }

    public function testBasketWithB01G01() {
        $basket = $this->createBasket();
        $basket->add('B01');
        $basket->add('G01');
        $this->assertEqualsWithDelta(37.85, $basket->total(), 0.01);
    }

    public function testBasketWithTwoR01() {
        $basket = $this->createBasket();
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEqualsWithDelta(54.38, $basket->total(), 0.01);
    }

    public function testBasketWithR01G01() {
        $basket = $this->createBasket();
        $basket->add('R01');
        $basket->add('G01');
        $this->assertEqualsWithDelta(60.85, $basket->total(), 0.01);
    }

    public function testBasketWithMultipleItems() {
        $basket = $this->createBasket();
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEqualsWithDelta(98.28, $basket->total(), 0.01);
    }
}
