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

$translations->add('MAX_LENGTH_TITLE', 'Maximum length');
$translations->add('MAX_LENGTH_DESC', 'Regardless of belt dimensions, weights (including volume weights) and surcharges for excess lengths, each service provider also has an absolute maximum length that must never be exceeded.');
/** */

$translations->define();
