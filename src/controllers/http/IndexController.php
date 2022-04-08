<?php

namespace app\controllers\http;

use app\models\Supplier;
use app\models\SupplierExporter;
use app\models\SupplierGrid;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;

/**
 * IndexController
 */
class IndexController extends Controller
{
    /**
     * 列表
     * @return string
     */
    public function actionIndex(): string
    {
        $grid = new SupplierGrid();
        $grid->setAttributes($this->request->get());
        $params['grid'] = $grid;
        if ($this->request->get('is_export')) {
            return $this->render('export', $params);
        }
        return $this->render('index', $params);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionExport(): Response|string
    {
        $exporter = new SupplierExporter();
        $exporter->setAttributes($this->request->post());
        $resp = $exporter->export();
        if ($resp === false) {
            /** @var []string $errors */
            $errors = $exporter->getFirstErrors();
            return reset($errors);
        } else {
            return $resp;
        }
    }
}