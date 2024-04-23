<?php

namespace Grandeljay\ShippingConditions;

class Configuration
{
    public static function getInstalledShippingModules(): array
    {
        $module_shipping_installed = defined('MODULE_SHIPPING_INSTALLED')
                                   ? explode(';', MODULE_SHIPPING_INSTALLED)
                                   : [];

        return $module_shipping_installed;
    }

    public static function getBeltSizes(): array
    {
        $belt_sizes_value   = constant(Constants::MODULE_NAME . '_BELT_SIZE');
        $belt_sizes_decoded = html_entity_decode($belt_sizes_value);
        $belt_sizes         = json_decode($belt_sizes_decoded, true);

        if (null === $belt_sizes) {
            return [];
        }

        return $belt_sizes;
    }

    public static function getMaxLengths(): array
    {
        $max_lengths_value   = constant(Constants::MODULE_NAME . '_MAX_LENGTH');
        $max_lengths_decoded = html_entity_decode($max_lengths_value);
        $max_lengths         = json_decode($max_lengths_decoded, true);

        if (null === $max_lengths) {
            return [];
        }

        return $max_lengths;
    }
}
