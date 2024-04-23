<?php

/**
 * Shipping Conditions
 *
 * @author Jay Trees <modified-shipping-conditions@grandels.email>
 * @link   https://github.com/grandeljay/modified-shipping-conditions
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 * @phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
 */

use Grandeljay\ShippingConditions\Configuration;
use Grandeljay\ShippingConditions\ConfigurationField;
use Grandeljay\ShippingConditions\Constants;
use Grandeljay\ShippingConditions\Installer;
use RobinTheHood\ModifiedStdModule\Classes\StdModule;

class grandeljay_shipping_conditions_checkout extends StdModule
{
    public const VERSION     = '0.2.0';
    public array $properties = [];

    public static function beltSize(string $value, string $option): string
    {
        return ConfigurationField::beltSize($value, $option);
    }

    public static function maxLength(string $value, string $option): string
    {
        return ConfigurationField::maxLength($value, $option);
    }

    public function __construct()
    {
        parent::__construct(Constants::MODULE_NAME);

        $this->checkForUpdate(true);
        $this->properties['form_edit'] = \xtc_draw_form(self::class, Constants::MODULE_FILENAME);

        foreach (Installer::getConfigurationKeys() as $field) {
            $this->addKey($field['key']);
        }
    }

    protected function updateSteps(): int
    {
        if (version_compare($this->getVersion(), self::VERSION, '<')) {
            $this->setVersion(self::VERSION);

            return self::UPDATE_SUCCESS;
        }

        return self::UPDATE_NOTHING;
    }

    public function install(): void
    {
        parent::install();

        foreach (Installer::getConfigurationKeys() as $field) {
            $this->addConfiguration(
                $field['key'],
                $field['value'],
                $field['groupId'],
                $field['sortOrder'],
                $field['setFunction'],
                $field['useFunction']
            );
        }

        Installer::installAdminAccess();
    }

    public function remove(): void
    {
        parent::remove();

        foreach (Installer::getConfigurationKeys() as $field) {
            $this->removeConfiguration($field['key']);
        }

        Installer::removeAdminAccess();
    }

    public function unallowed_shipping_modules(array $unallowed_modules): array
    {
        $products    = $_SESSION['cart']->get_products();
        $belt_sizes  = array_filter(
            Configuration::getBeltSizes(),
            function (array $belt_size) {
                return $belt_size['enabled'];
            }
        );
        $max_lengths = array_filter(
            Configuration::getMaxLengths(),
            function (array $max_length) {
                return $max_length['enabled'];
            }
        );

        foreach ($products as $product) {
            /** Belt size */
            $measurement_longest = max($product['length'], $product['width'], $product['height']);
            $measurement_set     = $measurement_longest > 0;

            if (true !== $measurement_set) {
                continue;
            }

            $belt_size_calculated = 2 * $product['height'] + 2 * $product['width'] + $measurement_longest;

            foreach ($belt_sizes as $shipping_method => $belt_size) {
                if ($belt_size_calculated >= $belt_size['value']) {
                    if (in_array($shipping_method, $unallowed_modules, true)) {
                        continue;
                    }

                    $unallowed_modules[] = $shipping_method;
                }
            }

            /** Max length */
            $measurement_longest = max($product['length'], $product['width'], $product['height']);

            foreach ($max_lengths as $shipping_method => $max_length) {
                if ($measurement_longest >= $max_length['value']) {
                    if (in_array($shipping_method, $unallowed_modules, true)) {
                        continue;
                    }

                    $unallowed_modules[] = $shipping_method;
                }
            }
        }

        return $unallowed_modules;
    }
}
