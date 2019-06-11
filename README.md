# Easily show values in localizated version

*__!! This repository is in an early stage, don't use it in production - subject to change !!__*

### Can be used for
* dates
* numbers
* currencies
### Features
* reliable: the heavy lifting of formating numbers and currency is done by the php extentions `intl`

## Installation *(through github for now)*
Put this repository in your `composer.json`:
```php
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/sbreiler/laravel-localization"
        }
    ],
```

Save and execute:
``` bash
composer require "sbreiler/laravel-localization:dev-master"
```

## Configuration


## Usage
After successfull installation a Facade named `L` is available to you.  

#### Currency example
In your view you could do something like this:
```php
<div>
    Expenses: {{ L::currency($total) }}
</div>
```

For a `float $total = 65432.10` the result would be (using `PHP 7.1.26`):

| Locale | Result |
| --- | --- |
| en_US | `$65,432.10` |
| th_TH | `US$65,432.10` |
| de_DE | `65.432,10 $` |
| ru_RU | `65 432,10 $` |

To get a different curreny unit:
```php
<div>
    Expenses: {{ L::currency($total)->setCurrencyCode('EUR') }}
</div>
```

Which outputs:

| Locale | Result |
| --- | --- |
| en_US | `€65,432.10` |
| th_TH | `€65,432.10` |
| de_DE | `65.432,10 €` |
| ru_RU | `65 432,10 €` |
