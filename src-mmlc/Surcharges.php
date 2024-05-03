<?php

namespace Grandeljay\ShippingConditions;

class Surcharges
{
    private array $products_with_surcharge;

    public function __construct(private string $shipping_method, private array $methods)
    {
    }

    public function setSurcharges(): void
    {
        if (\rth_is_module_disabled(Constants::MODULE_CHECKOUT_NAME)) {
            return;
        }

        $this->products_with_surcharge = [];

        $this->setSurchargeOversize();
        $this->setSurchargeBulkCharge();
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

        foreach ($products as &$product) {
            if (\in_array($product, $this->products_with_surcharge)) {
                continue;
            }

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

                    $this->products_with_surcharge[] = $product;
                }
            }
        }
    }

    private function setSurchargeBulkCharge(): void
    {
        global $order;

        $products = $order->products;

        $bulk_charges    = Configuration::getBulkCharge();
        $shipping_method = $this->shipping_method;
        $enabled_config  = $bulk_charges[$shipping_method]['enabled'] ?? false;

        if (true !== $enabled_config) {
            return;
        }

        $measurements = [
            'length' => \filter_var($bulk_charges[$shipping_method]['length'] ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0,
            'width'  => \filter_var($bulk_charges[$shipping_method]['width']  ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0,
            'height' => \filter_var($bulk_charges[$shipping_method]['height'] ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0,
        ];
        $surcharge    = \filter_var($bulk_charges[$shipping_method]['surcharge'] ?? 0, \FILTER_SANITIZE_NUMBER_FLOAT) ?: 0;

        \arsort($measurements, \SORT_NUMERIC);

        $measurement_second_longest_key   = \array_keys($measurements)[1];
        $measurement_second_longest_value = \array_values($measurements)[1];

        if (0 === $measurement_second_longest_value) {
            return;
        }

        foreach ($products as &$product) {
            if (\in_array($product, $this->products_with_surcharge)) {
                continue;
            }

            foreach ($this->methods as &$method) {
                if ($product[$measurement_second_longest_key] > $measurement_second_longest_value) {
                    $method['cost']          += $surcharge;
                    $method['calculations'][] = [
                        'name'  => 'bulk_charge',
                        'item'  => sprintf(
                            'Bulk charge (%s)',
                            $product['model'] ?? 'Unknown'
                        ),
                        'costs' => $surcharge,
                    ];

                    $this->products_with_surcharge[] = $product;
                } else {
                    break;
                }
            }
        }
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}
