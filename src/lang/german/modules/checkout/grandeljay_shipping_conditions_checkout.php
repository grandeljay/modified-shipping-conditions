<?php

namespace Grandeljay\ShippingConditions;

use Grandeljay\Translator\Translations;

$translations = new Translations(__FILE__, Constants::MODULE_NAME);
$translations->add('TITLE', 'grandeljay - Shipping Conditions');
$translations->add('TEXT_TITLE', 'Shipping Conditions');

/**
 * Configuration Fields
 */
$translations->add('BELT_SIZE_TITLE', 'Maximales Gurtmaß');
$translations->add('BELT_SIZE_DESC', 'Je nach Versandart gelten bestimmte Maximal-Gurtmaße. Formel für Gurtmaß ist: 2x Höhe + 2x Breite + 1x Länge (Länge = längste Seite).');
/** */

$translations->define();
