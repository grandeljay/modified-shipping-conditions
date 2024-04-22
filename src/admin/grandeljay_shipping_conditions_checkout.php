<?php

namespace Grandeljay\ShippingConditions;

use grandeljay_shipping_conditions_checkout;

require 'includes/application_top.php';

/**
 * Update module status
 */
$module_status_key   = Constants::MODULE_NAME . '_STATUS';
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
        Constants::MODULE_NAME . '_BELT_SIZE'
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
