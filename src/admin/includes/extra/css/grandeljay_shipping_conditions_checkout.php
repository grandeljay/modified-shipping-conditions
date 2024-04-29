<?php

namespace Grandeljay\ShippingConditions;

if (\rth_is_module_disabled(Constants::MODULE_CHECKOUT_NAME)) {
    return;
}

if ('/' . \DIR_ADMIN . \FILENAME_MODULES !== $_SERVER['SCRIPT_NAME'] ?? '') {
    return;
}

if (!isset($_GET['set'], $_GET['module'], $_GET['action'])) {
    return;
}

if (
       'checkout' !== $_GET['set']
    || \grandeljay_shipping_conditions_checkout::class !== $_GET['module']
    || 'edit' !== $_GET['action']
) {
    return;
}

$uri_to_file = 'includes/css/grandeljay_shipping_conditions.css';
$filepath    = \DIR_FS_CATALOG . \DIR_ADMIN . $uri_to_file;
$version     = \hash_file('crc32c', $filepath);
$href        = \sprintf($uri_to_file . '?v=%s', $version);
?>

<link rel="stylesheet" href="<?= $href ?>">
