<?php

namespace Grandeljay\ShippingConditions;

class ConfigurationField
{
    public static function beltSize(string $value, string $option): string
    {
        $module_shipping_installed = Configuration::getInstalledShippingModules();
        $belt_sizes                = Configuration::getBeltSizes();

        ob_start();
        ?>
        <details>
            <summary>Maximales Gurtmaß</summary>

            <div class="module_entries">
                <label class="header">Versandart</label>
                <label class="header">Maximales Gurtmaß</label>

                <?php foreach ($module_shipping_installed as $module_base_name) {?>
                    <?php
                    $module_filename          = \pathinfo($module_base_name, \PATHINFO_FILENAME);
                    $module_language_filepath = \sprintf(
                        '%s/modules/shipping/%s',
                        \DIR_FS_LANGUAGES . $_SESSION['language'],
                        $module_base_name
                    );

                    require_once $module_language_filepath;

                    $module_pretty_name = \constant('MODULE_SHIPPING_' . \strtoupper($module_filename) . '_TEXT_TITLE');

                    $is_checked = isset($belt_sizes[$module_filename]['enabled']) && true === $belt_sizes[$module_filename]['enabled'];
                    $checked    = $is_checked ? 'checked' : '';
                    $value      = $belt_sizes[$module_filename]['value'] ?? '';
                    ?>
                    <label>
                        <input type="checkbox" name="<?= $module_filename ?>[belt_size][enabled]" <?= $checked ?>>
                        <?= $module_pretty_name ?>
                    </label>

                    <input type="text" name="<?= $module_filename ?>[belt_size][value]" value="<?= $value ?>" pattern="\d+">
                <?php } ?>
            </div>
        </details>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function maxLength(string $value, string $option): string
    {
        $module_shipping_installed = Configuration::getInstalledShippingModules();
        $max_lengths               = Configuration::getMaxLengths();

        ob_start();
        ?>
        <details>
            <summary>Maximal Länge</summary>

            <div class="module_entries">
                <label class="header">Versandart</label>
                <label class="header">Maximal Länge</label>

                <?php foreach ($module_shipping_installed as $module_base_name) {?>
                    <?php
                    $module_filename          = \pathinfo($module_base_name, \PATHINFO_FILENAME);
                    $module_language_filepath = \sprintf(
                        '%s/modules/shipping/%s',
                        \DIR_FS_LANGUAGES . $_SESSION['language'],
                        $module_base_name
                    );

                    require_once $module_language_filepath;

                    $module_pretty_name = \constant('MODULE_SHIPPING_' . \strtoupper($module_filename) . '_TEXT_TITLE');

                    $is_checked = isset($max_lengths[$module_filename]['enabled']) && true === $max_lengths[$module_filename]['enabled'];
                    $checked    = $is_checked ? 'checked' : '';
                    $value      = $max_lengths[$module_filename]['value'] ?? '';
                    ?>
                    <label>
                        <input type="checkbox" name="<?= $module_filename ?>[max_length][enabled]" <?= $checked ?>>
                        <?= $module_pretty_name ?>
                    </label>

                    <input type="text" name="<?= $module_filename ?>[max_length][value]" value="<?= $value ?>" pattern="\d+">
                <?php } ?>
            </div>
        </details>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function oversize(string $value, string $option): string
    {
        $module_shipping_installed = Configuration::getInstalledShippingModules();
        $oversizes                 = Configuration::getOversizes();

        ob_start();
        ?>
        <details>
            <summary>Überlängen</summary>

            <div class="module_entries oversize">
                <label class="header">Versandart</label>
                <label class="header">Maximalgewicht</label>
                <label class="header">Maximallänge</label>
                <label class="header">Aufschlag</label>

                <?php foreach ($module_shipping_installed as $module_base_name) {?>
                    <?php
                    $module_filename          = \pathinfo($module_base_name, \PATHINFO_FILENAME);
                    $module_language_filepath = \sprintf(
                        '%s/modules/shipping/%s',
                        \DIR_FS_LANGUAGES . $_SESSION['language'],
                        $module_base_name
                    );

                    require_once $module_language_filepath;

                    $module_pretty_name = \constant('MODULE_SHIPPING_' . \strtoupper($module_filename) . '_TEXT_TITLE');

                    $is_checked = isset($oversizes[$module_filename]['enabled']) && true === $oversizes[$module_filename]['enabled'];
                    $checked    = $is_checked ? 'checked' : '';
                    $kilogram   = $oversizes[$module_filename]['kilogram']  ?? '';
                    $length     = $oversizes[$module_filename]['length']    ?? '';
                    $surcharge  = $oversizes[$module_filename]['surcharge'] ?? '';
                    ?>
                    <label>
                        <input type="checkbox" name="<?= $module_filename ?>[oversize][enabled]" <?= $checked ?>>
                        <?= $module_pretty_name ?>
                    </label>

                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[oversize][kilogram]"  value="<?= $kilogram ?>">
                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[oversize][length]"    value="<?= $length ?>">
                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[oversize][surcharge]" value="<?= $surcharge ?>">
                <?php } ?>
            </div>
        </details>
        <?php
        $html = ob_get_clean();

        return $html;
    }

    public static function bulkCharge(string $value, string $option): string
    {
        $module_shipping_installed = Configuration::getInstalledShippingModules();
        $bulk_charges              = Configuration::getBulkCharge();

        ob_start();
        ?>
        <details>
            <summary>Sperrzuschlag</summary>

            <div class="module_entries bulk_charge">
                <label class="header">Versandart</label>
                <label class="header">Länge</label>
                <label class="header">Breite</label>
                <label class="header">Höhe</label>
                <label class="header">Aufschlag</label>

                <?php foreach ($module_shipping_installed as $module_base_name) {?>
                    <?php
                    $module_filename          = \pathinfo($module_base_name, \PATHINFO_FILENAME);
                    $module_language_filepath = \sprintf(
                        '%s/modules/shipping/%s',
                        \DIR_FS_LANGUAGES . $_SESSION['language'],
                        $module_base_name
                    );

                    require_once $module_language_filepath;

                    $module_pretty_name = \constant('MODULE_SHIPPING_' . \strtoupper($module_filename) . '_TEXT_TITLE');

                    $is_checked = isset($bulk_charges[$module_filename]['enabled']) && true === $bulk_charges[$module_filename]['enabled'];
                    $checked    = $is_checked ? 'checked' : '';
                    $length     = $bulk_charges[$module_filename]['length']    ?? '';
                    $width      = $bulk_charges[$module_filename]['width']     ?? '';
                    $height     = $bulk_charges[$module_filename]['height']    ?? '';
                    $surcharge  = $bulk_charges[$module_filename]['surcharge'] ?? '';
                    ?>
                    <label>
                        <input type="checkbox" name="<?= $module_filename ?>[bulk_charge][enabled]" <?= $checked ?>>
                        <?= $module_pretty_name ?>
                    </label>

                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[bulk_charge][length]"    value="<?= $length ?>">
                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[bulk_charge][width]"     value="<?= $width ?>">
                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[bulk_charge][height]"    value="<?= $height ?>">
                    <input type="text" pattern="\d+" name="<?= $module_filename ?>[bulk_charge][surcharge]" value="<?= $surcharge ?>">
                <?php } ?>
            </div>
        </details>
        <?php
        $html = ob_get_clean();

        return $html;
    }
}
