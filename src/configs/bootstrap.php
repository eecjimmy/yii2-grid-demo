<?php

use Env\Env;

Yii::setAlias('@root', dirname(__DIR__, 2));
Yii::setAlias('@runtime', '@root/runtime');
Yii::setAlias('@app', '@root/src');
Yii::setAlias('@public', '@root/public');

function env()
{
    return Env::getInstance(Yii::getAlias('@root/.env'));
}
