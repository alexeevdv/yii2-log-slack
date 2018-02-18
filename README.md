SlackTarget for Yii2 logger
===========================

[![Build Status](https://travis-ci.org/alexeevdv/yii2-log-slack.svg?branch=master)](https://travis-ci.org/alexeevdv/yii2-log-slack) ![PHP 5.6](https://img.shields.io/badge/PHP-5.6-green.svg) ![PHP 7.0](https://img.shields.io/badge/PHP-7.0-green.svg) ![PHP 7.1](https://img.shields.io/badge/PHP-7.1-green.svg) ![PHP 7.2](https://img.shields.io/badge/PHP-7.2-green.svg)

Sends log messages to Slack webhook.

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```bash
$ php composer.phar require alexeevdv/yii2-log-slack "~1.0"
```

or add

```
"alexeevdv/yii2-log-slack": "~1.0"
```

to the ```require``` section of your `composer.json` file.

## Configuration

### Through application component
```php
use alexeevdv\log\SlackTarget;

//...
'components' => [
    //...
    'log' => [
        //...
        'targets' => [
            //...
            [
                'class' => SlackTarget::class,
                'webhook' => 'https://your_webhook_link',
                // other optional params goes here
            ],
            //...
        ],
        //..
    ],
    //...
],
//...
```

### Supported params:

For the list of supported params please refer to [https://github.com/maknz/slack](https://github.com/maknz/slack#settings)
