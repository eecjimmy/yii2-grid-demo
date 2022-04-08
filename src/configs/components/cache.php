<?php
$key = md5(__FILE__);
return [
    'keyPrefix' => $key,
    'class' => 'yii\caching\FileCache',
    'dirMode' => 0775,
];
