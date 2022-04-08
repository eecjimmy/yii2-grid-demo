<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\web\Controller;

/**
 * HttpController
 */
abstract class HttpController extends Controller
{
    public function behaviors()
    {
        return [
            Cors::class,
        ];
    }
}