> # ⚠️ This package is no longer maintained

Laravel Block Referral Spam
==============================
[![Latest Stable Version](https://poser.pugx.org/dougsisk/laravel-block-referral-spam/version)](https://packagist.org/packages/dougsisk/laravel-block-referral-spam)
[![Total Downloads](https://poser.pugx.org/dougsisk/laravel-block-referral-spam/downloads)](https://packagist.org/packages/dougsisk/laravel-block-referral-spam)
[![License](https://poser.pugx.org/dougsisk/laravel-block-referral-spam/license)](https://packagist.org/packages/dougsisk/laravel-block-referral-spam)

Middleware for **Laravel 5.5+** that blocks referrer spam using a list from [Matomo](https://github.com/matomo-org/referrer-spam-list).

Installation
------------

Require this package with composer:

```
composer require dougsisk/laravel-block-referral-spam
```

After updating composer, add the `DougSisk\BlockReferralSpam\Middleware\BlockReferralSpam` to your `web` middleware group in `app/Http/Kernel.php` or any others you wish to use:
```
protected $middlewareGroups = [
    'web' => [
        \DougSisk\BlockReferralSpam\Middleware\BlockReferralSpam::class,
    ],
];
```

Configuration
-------------

By default, the list of domains to block will be loaded from `vendor/matomo/referrer-spam-list/spammers.txt`. This is under the assumption your vendor folder is installed in the base path of your app. If your vendor folder is not in your base path or you wish to use a custom list file, add the following line to your `config/app.php`:

```
'referral_spam_list_location' => base_path('my-folder/my-list.txt'),
```

Please remember to follow the formatting in [the original list file](https://github.com/matomo-org/referrer-spam-list/blob/master/spammers.txt) should you make your own custom list.

License
-------

This library is available under the [MIT license](LICENSE).
