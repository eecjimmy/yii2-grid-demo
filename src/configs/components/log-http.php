<?php
return [
    'traceLevel' => 0,
    'targets' => [
        [
            'logFile' => '@runtime/logs/' . date('Ym/Ymd') . '-http.log',
            'class' => 'yii\log\FileTarget',
            'microtime' => true,
            'logVars' => [],
            'exportInterval' => 1,
            'levels' => ['info', 'error', 'warning'],
            'maxLogFiles' => 100, // 保存100个日志文件
        ],
    ],
];
