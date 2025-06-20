<?php

require __DIR__ . '/vendor/autoload.php';

use Acme\Basket;
use Acme\Offers\BuyOneGetSecondHalfPrice;

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

$offers = [
    new BuyOneGetSecondHalfPrice('R01')
];

$basket = new Basket($catalogue, $deliveryRules, $offers);
$basket->add('R01');
$basket->add('R01');

echo "Total: $" . $basket->total();