<?php

namespace Grandeljay\ShippingConditions;

class Surcharges
{
    public function __construct(private string $shipping_method, private array $methods)
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
        $shipping_method = $this->shipping_method;
        $enabled_config  = $oversizes[$shipping_method]['enabled'] ?? false;

        if (true !== $enabled_config) {
            return;
        }

        foreach ($products as $product) {
            foreach ($this->methods as &$method) {
                $product_longest_side         = max($product['length'], $product['width'], $product['height']);
                $product_longest_side_maximum = $oversizes[$shipping_method]['length'];
                $product_weight               = $product['weight'];
                $product_weight_maximum       = $oversizes[$shipping_method]['kilogram'];

                $surcharge = \filter_var($oversizes[$shipping_method]['surcharge'], \FILTER_SANITIZE_NUMBER_FLOAT);

                if ($surcharge && ($product_longest_side >= $product_longest_side_maximum || $product_weight >= $product_weight_maximum)) {
                    $method['cost']          += $surcharge;
                    $method['calculations'][] = [
                        'name'  => 'oversized',
                        'item'  => sprintf(
                            'Oversized product',
                        ),
                        'costs' => $surcharge,
                    ];
                }
            }
        }
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}
