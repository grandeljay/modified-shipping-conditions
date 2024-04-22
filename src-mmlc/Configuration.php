<?php

namespace Grandeljay\ShippingConditions;

class Configuration
{
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
}
