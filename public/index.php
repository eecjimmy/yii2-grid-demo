<?php

use yii\web\Application;

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../src/configs/bootstrap.php';


$config = require __DIR__ . '/../src/configs/http.php';


/** @noinspection PhpUnhandledExceptionInspection */
(new Application($config))->run();
