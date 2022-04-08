<?php

namespace app\controllers\http;

use app\models\Supplier;
use app\models\SupplierExporter;
use app\models\SupplierGrid;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * IndexController
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        $grid = new SupplierGrid();
        $grid->setAttributes($this->request->get());
        $params['grid'] = $grid;
        if ($this->request->get('is_export')) {
            return $this->render('export', $params);
        }
        return $this->render('index', $params);
    }

    public function actionExport()
    {
        $exporter = new SupplierExporter();
        $exporter->setAttributes($this->request->post());
        $resp = $exporter->export();
        if ($resp === false) {
            $errors = $exporter->getFirstErrors();
            return reset($errors);
        } else {
            return $resp;
        }
    }
}