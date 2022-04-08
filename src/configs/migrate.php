<?php

use yii\base\Event;
use yii\console\Application;
use yii\console\controllers\MigrateController;
use yii\helpers\FileHelper;


// 自动加载migration path
Event::on(Application::class, Application::EVENT_BEFORE_REQUEST, function () {
    $path = FileHelper::findDirectories(Yii::getAlias('@app/migrations'));
    Yii::$container->set(MigrateController::class, [
        'migrationPath' => $path,
    ]);
});

return MigrateController::class;