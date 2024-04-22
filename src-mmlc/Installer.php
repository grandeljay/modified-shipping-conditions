<?php

namespace Grandeljay\ShippingConditions;

use grandeljay_shipping_conditions_checkout;

class Installer
{
    private static array $configuration_fields = [
        [
            'key'         => 'BELT_SIZE',
            'value'       => '',
            'groupId'     => 6,
            'sortOrder'   => 1,
            'setFunction' => grandeljay_shipping_conditions_checkout::class . '::beltSize(',
            'useFunction' => '',
        ],
    ];

    public static function getConfigurationKeys(): array
    {
        return self::$configuration_fields;
    }

    public static function installAdminAccess(): void
    {
        /** Add new column to table */
        \xtc_db_query(
            \sprintf(
                'ALTER TABLE `%s`
                  ADD COLUMN `%s` INT(10) NOT NULL;',
                \TABLE_ADMIN_ACCESS,
                grandeljay_shipping_conditions_checkout::class
            )
        );

        /** Get all admins */
        $admins_query = \xtc_db_query(
            \sprintf(
                'SELECT `customers_id`
                   FROM `%s`
                  WHERE `customers_status` = 0',
                \TABLE_CUSTOMERS
            )
        );

        /** Set admin access for each admin */
        while ($admin_data = \xtc_db_fetch_array($admins_query)) {
            \xtc_db_query(
                \sprintf(
                    'UPDATE `%s`
                        SET `%s` = 1
                      WHERE `customers_id` = %d;',
                    \TABLE_ADMIN_ACCESS,
                    grandeljay_shipping_conditions_checkout::class,
                    $admin_data['customers_id']
                )
            );
        }
    }

    public static function removeAdminAccess(): void
    {
        \xtc_db_query(
            \sprintf(
                'ALTER TABLE `%s`
                 DROP COLUMN `%s`',
                \TABLE_ADMIN_ACCESS,
                grandeljay_shipping_conditions_checkout::class
            )
        );
    }
}
