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
        <details open>
            <summary>Maximales Gurtmaß</summary>

            <div class="module_entries">
                <label>Versandart</label>
                <label>Maximales Gurtmaß</label>

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

                    <input type="text" name="<?= $module_filename ?>[belt_size][value]" value="<?= $value ?>">
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
        <details open>
            <summary>Maximal Länge</summary>

            <div class="module_entries">
                <label>Versandart</label>
                <label>Maximal Länge</label>

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

                    <input type="text" name="<?= $module_filename ?>[max_length][value]" value="<?= $value ?>">
                <?php } ?>
            </div>
        </details>
        <?php
        $html = ob_get_clean();

        return $html;
    }
}
