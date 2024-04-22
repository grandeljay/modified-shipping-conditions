<?php

namespace Grandeljay\ShippingConditions;

use Grandeljay\Translator\Translations;

$translations = new Translations(__FILE__, Constants::MODULE_NAME);
$translations->add('TITLE', 'grandeljay - Shipping Conditions');
$translations->add('TEXT_TITLE', 'Shipping Conditions');

/**
 * Configuration Fields
 */
$translations->add('BELT_SIZE_TITLE', 'Maximum belt size');
$translations->add('BELT_SIZE_DESC', 'Depending on the shipping method, certain maximum strap dimensions apply. The formula for belt dimensions is: 2x height + 2x width + 1x length (length = longest side).');
/** */

$translations->define();
