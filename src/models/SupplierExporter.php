<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * SupplierExporter
 */
class SupplierExporter extends SupplierGrid
{
    /**
     * 导出的字段
     * @var array
     */
    public array $exportAttributes = [];

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            ['exportAttributes', 'required'],

            /** @see includeAttributes */
            ['exportAttributes', 'includeAttributes', 'params' => ['id']],
        ]);
    }

    /**
     * 校验是否包含了指定字段
     * @param $attr
     * @param array $params
     */
    public function includeAttributes($attr, array $params = [])
    {
        if ($this->hasErrors()) return;
        foreach ($params as $key) {
            if (!in_array($key, $this->exportAttributes)) {
                $this->addError($attr, "必须导出 $key 字段");
            }
        }
    }

    /**
     * 导出操作
     * @return false|string|\yii\web\Response
     */
    public function export(): Response|bool|string
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

        // web导出处理
        $resp = Yii::$app->response;
        if ($resp instanceof Response) {
            $resp->format = Response::FORMAT_RAW;
            $resp->content = implode("\n", $data);
            $resp->setDownloadHeaders("supplier.csv", 'text/csv');
            return $resp;
        }

        // 非web导出, 直接返回`csv`文件字符串
        return implode("\n", $data);
    }
}