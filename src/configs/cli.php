<?php

return [
    'id' => 'xj-meal-cli',
    'aliases' => [],
    'language' => 'zh-CN',
    'basePath' => Yii::getAlias('@app'),
    'runtimePath' => '@runtime',
    'timeZone' => env()->get('TZ'),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\controllers\cli',
    'enableCoreCommands' => false,
    'controllerMap' => [
        'migrate' => require __DIR__ . '/migrate.php',
    ],
    'components' => [
        'cache' => require __DIR__ . '/components/cache.php',
        'log' => require __DIR__ . '/components/log-cli.php',
        'db' => require __DIR__ . '/components/db.php',
    ],
    'params' => [],
];
