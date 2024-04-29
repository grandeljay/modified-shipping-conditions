<?php

namespace Grandeljay\ShippingConditions;

class Surcharges
{
    public function __construct(private array $quote)
    {
    }

    public function setSurcharges(): void
    {
        $this->setSurchargeOversize();
    }

    /**
     * Set Surcharges for oversized prodcuts
     *
     * @link https://app.asana.com/0/1199686704146295/1206692423384653/f
     *
     * @return void
     */
    private function setSurchargeOversize(): void
    {
        global $order;

        $products = $order->products;

        $oversizes       = Configuration::getOversizes();
        $shipping_method = $this->quote['id'];
        $enabled_config  = $oversizes[$shipping_method]['enabled'] ?? false;

        if (true !== $enabled_config) {
            return;
        }

        foreach ($products as $product) {
            foreach ($this->quote['methods'] as &$method) {
                $longest_side_product = max($product['length'], $product['width'], $product['height']);
                $longest_side_config  = $oversizes[$shipping_method]['length'];
                $weight_product       = $product['weight'];
                $weight_config        = $oversizes[$shipping_method]['kilogram'];
                $surcharge            = $oversizes[$shipping_method]['surcharge'];

                if ($longest_side_product >= $longest_side_config || $weight_product >= $weight_config) {
                    $method['cost'] += $surcharge;
                }
            }
        }
    }

    public function getQuote(): array
    {
        return $this->quote;
    }
}
