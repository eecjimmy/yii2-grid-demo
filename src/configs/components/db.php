<?php
$env = env();
return [
    'class' => 'yii\db\Connection',
    'dsn' => sprintf('mysql:host=%s;dbname=%s', $env->get('MYSQL_HOST'), $env->get('MYSQL_NAME')),
    'username' => $env->get('MYSQL_USER'),
    'password' => $env->get('MYSQL_PASS'),
    'charset' => 'utf8mb4',
    'tablePrefix' => 'v_',
    'enableLogging' => false,
    'enableProfiling' => false,
    'enableSchemaCache' => false,
];