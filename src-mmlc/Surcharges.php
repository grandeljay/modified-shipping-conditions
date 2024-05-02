<?php

namespace Grandeljay\ShippingConditions;

class Surcharges
{
    public function __construct(private string $shipping_method, private array $methods)
    {
    }

    public function setSurcharges(): void
    {
        if (\rth_is_module_disabled(Constants::MODULE_CHECKOUT_NAME)) {
            return;
        }

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
                /**
                 * Weight
                 */
                $product_weight         = $product['weight'];
                $product_weight_maximum = \filter_var($oversizes[$shipping_method]['kilogram'] ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0;

                if (0 === $product_weight || 0 === $product_weight_maximum) {
                    break;
                }

                /**
                 * Length
                 */
                $product_longest_side         = max($product['length'], $product['width'], $product['height']);
                $product_longest_side_maximum = \filter_var($oversizes[$shipping_method]['length'] ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0;

                if (0 === $product_longest_side || 0 === $product_longest_side_maximum) {
                    break;
                }

                /**
                 * Surcharge
                 */
                $surcharge = \filter_var($oversizes[$shipping_method]['surcharge'] ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0;

                if (0 === $surcharge) {
                    break;
                }

                /**
                 * Calculate
                 */
                if ($product_longest_side >= $product_longest_side_maximum || $product_weight >= $product_weight_maximum) {
                    $method['cost']          += $surcharge;
                    $method['calculations'][] = [
                        'name'  => 'oversized',
                        'item'  => sprintf(
                            'Oversized product (%s)',
                            $product['model'] ?? 'Unknown'
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
