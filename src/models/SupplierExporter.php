<?php

namespace app\models;

use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * SupplierExporter
 */
class SupplierExporter extends SupplierGrid
{
    public $exportAttributes = [];

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            ['exportAttributes', 'required'],
            ['exportAttributes', 'includeAttributes', 'params' => ['id']],
        ]);
    }

    public function includeAttributes($attr, $params = [])
    {
        if ($this->hasErrors()) return;
        foreach ($params as $key) {
            if (!in_array($key, $this->exportAttributes)) {
                $this->addError($attr, "必须导出 $key 字段");
            }
        }
    }

    public function export()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var \yii\db\ActiveQuery $query */
        $query = parent::getProvider()->query;
        $data = [];
        // 添加表头
        $data[] = implode(",", array_map(function ($attr) {
            return $this->getAttributeLabel($attr);
        }, $this->exportAttributes));

        $keys = array_flip($this->exportAttributes);
        // 处理数据
        foreach ($query->each() as $item) {
            /** @var \app\models\Supplier $item */
            $row = array_intersect_key($item->toArray(), $keys);
            $data[] = implode(",", $row);
        }

        $resp = \Yii::$app->response;
        if ($resp instanceof Response) {
            $resp->format = Response::FORMAT_RAW;
            $resp->content = implode("\n", $data);
            $resp->setDownloadHeaders("supplier.csv", 'text/csv');
            return $resp;
        }

        return implode("\n", $data);
    }
}