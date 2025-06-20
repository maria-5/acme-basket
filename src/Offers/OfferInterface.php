<?php

namespace Acme\Offers;

interface OfferInterface {
    /**
     * @param array<string, float> $catalogue
     * @param array<string, int>   $itemCounts
     */
    public function apply(array $itemCounts, array $catalogue): float;
}
