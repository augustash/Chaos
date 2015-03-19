# Ash Chaos Instructions

**Important**: This module is **not** intended for production use or for beginning Magento developers.  Proceed at your own risk.

Chaos allows a programmer the ability to assign random configuration values at runtime. Introducing this "chaos" into the system exposes incorrect assumptions about the core Magento APIs in custom code.

This is done via the `applyConfigNodeCallbacks` method of the `Entropy` model. This method accepts an array of key/value pairs.

```php
    return array(
        'catalog/frontend/flat_catalog_product' => function(){
            return $themes[rand(0, 1)];
        }
    );

    Mage::getModel('ash_chaos/entropy')->applyConfigNodeCallbacks($fields);
```

Each key of the PHP array is the configuration node whose value you wish to change.  Each value is <a href="http://php.net/manual/en/language.types.callable.php">a valid PHP callback</a>.  This callback is responsible for returning a random value.  In the above example the configuration nodes will be set to either `0` or `1`.

In addition to providing a valid PHP callback, the developer may also provide the name of a method on the `ash_chaos/values` model.  For example, the class for this model ships with the `getRandomBoolean` method for randomly assigning booleans.

```php
    class Ash_Chaos_Model_Values
    {
        public function getRandomBoolean()
        {
            return (string) rand(0,1);
        }
    }
```

This method may be used with the following:

```php
    return array(
        'catalog/frontend/flat_catalog_category' => 'getRandomBoolean',
    );

    Mage::getModel('ash_chaos/entropy')->applyConfigNodeCallbacks($fields);
```

Default Observer
--------------------------------------------------
In addition to the above mechanisms, the `Ash_Chaos` module ships with an observer method for the `controller_action_predispatch` event. This observer:

1. Applies the callbacks in `etc/fields.php`
2. Fires two events of its own, `ash_chaos_start_before` and `ash_chaos_start_after`

This observer will **not** run when serving admin requests.

Configuration Changes
--------------------------------------------------
The configuration values this module sets are at runtime only, and for the current store only. They're applied with code that looks something like this:

```php
    $config = Mage::getConfig();
    $config->setNode("stores/$storeCode/" . $path, call_user_func($callback));
```

**IMPORTANT**: If the configuration object is persisted to cache **after** the callbacks have been applied, the chaotic values may be persisted to cache along with the object.
