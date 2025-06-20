<?php

namespace Acme\Offers;

class BuyOneGetSecondHalfPrice implements OfferInterface {
    
    private string $productCode;

    public function __construct(string $productCode) {
        $this->productCode = $productCode;
    }

    /**
     * @param array<string, float> $catalogue
     * @param array<string, int>   $itemCounts
     */
    public function apply(array $itemCounts, array $catalogue): float {
        if (!isset($itemCounts[$this->productCode])) {
            return 0.0;
        }

        $count = $itemCounts[$this->productCode];
        $discountPairs = floor($count / 2);

        return $discountPairs * ($catalogue[$this->productCode] / 2);
    }
}
