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

    private static function getJson(string $key): array
    {
        $constant = Constants::MODULE_CHECKOUT_NAME . '_' . $key;

        if (!\defined($constant)) {
            return [];
        }

        $json_value   = constant($constant);
        $json_decoded = html_entity_decode($json_value);
        $json         = json_decode($json_decoded, true);

        if (null === $json) {
            return [];
        }

        return $json;
    }

    public static function getBeltSizes(): array
    {
        return self::getJson('BELT_SIZE');
    }

    public static function getMaxLengths(): array
    {
        return self::getJson('MAX_LENGTH');
    }

    public static function getOversizes(): array
    {
        return self::getJson('OVERSIZE');
    }
}
