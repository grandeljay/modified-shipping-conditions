## Description

Allows you to use define additional conditions and surcharges to your existing shipping methods.

## Note

**Shipping modules must be compatible for this module to work.** If you would like to add compatibility, all you need to do is add the following snippet to your shipping method's `quote` method:

```php
use Grandeljay\ShippingConditions\Surcharges;

[...]

public function quote(string $method_id = ''): ?array
{
    [...]

    if (\class_exists('Grandeljay\ShippingConditions\Surcharges')) {
        $surcharges = new \Grandeljay\ShippingConditions\Surcharges(
            \grandeljayups::class,            /** Class name of the shipping module */
            $methods                          /** The shipping module's methods */
        );
        $surcharges->setSurcharges();         /** This won't do anything if the module is disabled */

        $methods = $surcharges->getMethods(); /** Return the methods, with added surcharges */
    }

    [...]

    return $quote;
}
```

## Features

### Update safe

Does not require any manual editing of files and remains after an update.

### Clean uninstall

If you deinstall this module in modified, all database information created by this module will be removed, without leaving any orphaned tables or columns. Removing this module via the MMLC will completely remove all files from this module.

### Multilingual

As of writing this, this module is available in **five** different languages:

|     | Language |
| --- | -------- |
| 🏴󠁧󠁢󠁥󠁮󠁧󠁿  | English  |
| 🇫🇷  | French   |
| 🇩🇪  | German   |
| 🇮🇹  | Italian  |
| 🇪🇸  | Spanish  |

## Support

Notice a bug or something isn't working as expected? You can create an issue for it here: [github.com/grandeljay/modified-shipping-conditions/issues](https://github.com/grandeljay/modified-shipping-conditions/issues/new/choose).
