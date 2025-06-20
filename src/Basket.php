<?php

namespace Acme;

use Acme\Offers\OfferInterface;

class Basket {
    /** @var string[] */
    private array $products = [];

    /**
    * @var array<string, float>
    * Catalogue mapping product code to price.
    */
    private array $catalogue;

    /**
     * @var array<int, float>
     * Delivery rules, keyed by minimum cart total.
     */
    private array $deliveryRules;

    /** @var OfferInterface[] */
    private array $offers;

    /**
     * @param array<string, float> $catalogue
     * @param array<int, float>    $deliveryRules
     * @param OfferInterface[]     $offers
     */
    public function __construct(array $catalogue, array $deliveryRules, array $offers = []) {
        $this->catalogue = $catalogue;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add(string $productCode): void {
        if (!isset($this->catalogue[$productCode])) {
            throw new \InvalidArgumentException("Invalid product: $productCode");
        }
        $this->products[] = $productCode;
    }

    public function total(): float {
        $itemCounts = array_count_values($this->products);
        $subtotal = 0;

        foreach ($itemCounts as $code => $count) {
            $subtotal += $this->catalogue[$code] * $count;
        }

        foreach ($this->offers as $offer) {
            $subtotal -= $offer->apply($itemCounts, $this->catalogue);
        }

        ksort($this->deliveryRules);
        foreach ($this->deliveryRules as $threshold => $cost) {
            if ($subtotal < $threshold) {
                $subtotal += $cost;
                break;
            }
        }

        return round($subtotal, 2);
    }
}
