<?php

namespace Grandeljay\ShippingConditions;

use grandeljay_shipping_conditions_checkout;

require 'includes/application_top.php';

/**
 * Update module status
 */
$module_status_key   = Constants::MODULE_CHECKOUT_NAME . '_STATUS';
$module_status_value = $_POST['configuration'][$module_status_key];

\xtc_db_query(
    \sprintf(
        'UPDATE `%s`
            SET `configuration_value` = "%s"
          WHERE `configuration_key`   = "%s"',
        \TABLE_CONFIGURATION,
        $module_status_value,
        $module_status_key
    )
);
/** */

/**
 * Update belt sizes
 */
$belt_sizes = [];

foreach ($_POST as $key => $value) {
    if (isset($value['belt_size'])) {
        $belt_sizes[$key] = [
            'enabled' => isset($value['belt_size']['enabled']),
            'value'   => $value['belt_size']['value'],
        ];
    }
}

\xtc_db_query(
    \sprintf(
        'UPDATE `%s`
            SET `configuration_value` = "%s"
          WHERE `configuration_key`   = "%s"',
        \TABLE_CONFIGURATION,
        \htmlspecialchars(\json_encode($belt_sizes), \ENT_QUOTES),
        Constants::MODULE_CHECKOUT_NAME . '_BELT_SIZE'
    )
);
/** */

/**
 * Update max length
 */
$max_length = [];

foreach ($_POST as $key => $value) {
    if (isset($value['max_length'])) {
        $max_length[$key] = [
            'enabled' => isset($value['max_length']['enabled']),
            'value'   => $value['max_length']['value'],
        ];
    }
}

\xtc_db_query(
    \sprintf(
        'UPDATE `%s`
            SET `configuration_value` = "%s"
          WHERE `configuration_key`   = "%s"',
        \TABLE_CONFIGURATION,
        \htmlspecialchars(\json_encode($max_length), \ENT_QUOTES),
        Constants::MODULE_CHECKOUT_NAME . '_MAX_LENGTH'
    )
);
/** */

/**
 * Oversize
 */
$oversize = [];

foreach ($_POST as $key => $value) {
    if (isset($value['oversize'])) {
        $oversize[$key] = [
            'enabled'   => isset($value['oversize']['enabled']),
            'kilogram'  => $value['oversize']['kilogram'],
            'length'    => $value['oversize']['length'],
            'surcharge' => $value['oversize']['surcharge'],
        ];
    }
}

\xtc_db_query(
    \sprintf(
        'UPDATE `%s`
            SET `configuration_value` = "%s"
          WHERE `configuration_key`   = "%s"',
        \TABLE_CONFIGURATION,
        \htmlspecialchars(\json_encode($oversize), \ENT_QUOTES),
        Constants::MODULE_CHECKOUT_NAME . '_OVERSIZE'
    )
);
/** */

/**
 * Bulk Charge
 */
$bulk_charge = [];

foreach ($_POST as $key => $value) {
    if (isset($value['bulk_charge'])) {
        $bulk_charge[$key] = [
            'enabled'   => isset($value['bulk_charge']['enabled']),
            'length'    => $value['bulk_charge']['length'],
            'width'     => $value['bulk_charge']['width'],
            'height'    => $value['bulk_charge']['height'],
            'surcharge' => $value['bulk_charge']['surcharge'],
        ];
    }
}

\xtc_db_query(
    \sprintf(
        'UPDATE `%s`
            SET `configuration_value` = "%s"
          WHERE `configuration_key`   = "%s"',
        \TABLE_CONFIGURATION,
        \htmlspecialchars(\json_encode($bulk_charge), \ENT_QUOTES),
        Constants::MODULE_CHECKOUT_NAME . '_BULK_CHARGE'
    )
);
/** */

/**
 * Redirect back to settings page
 */
\xtc_redirect(
    \xtc_href_link(
        \FILENAME_MODULES,
        \http_build_query(
            [
                'set'    => 'checkout',
                'module' => grandeljay_shipping_conditions_checkout::class,
            ]
        )
    )
);
