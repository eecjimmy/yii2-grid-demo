<?php

namespace app\models;

use yii\bootstrap5\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * SupplierGrid
 */
class SupplierGrid extends Supplier
{
    const DEFAULT_OPERATOR = '=';

    public $searchAttributes = [
        'id' => '=',
        'name' => 'like',
        'code' => 'like',
        't_status' => '=',
    ];

    public $isExport = false;

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['id', 'integer'],

            [['name', 'code'], 'string'],

            ['t_status', 'string'],
            ['t_status', 'in', 'range' => array_keys(parent::tStatuses())],
        ];
    }

    private $searchForm;

    public function getSearchForm()
    {
        if ($this->searchForm === null) {
            $this->searchForm = ActiveForm::begin();
        }
        return $this->searchForm;
    }

    public function searchField($attribute, $options = [])
    {
        $form = $this->getSearchForm();

        $options = ArrayHelper::merge([
            'inline' => true,
        ], $options);

        return $form->field($this, $attribute, $options);
    }

    public function getProvider(): ActiveDataProvider
    {
        $query = static::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        foreach ($this->safeAttributes() as $attribute) {
            if (!array_key_exists($attribute, $this->searchAttributes)) continue; // 禁止搜素字段
            if (!$this->validate($attribute)) continue; // 搜索字段校验未通过

            $op = $this->searchAttributes[$attribute];
            $query->andFilterWhere([$op, $attribute, $this->$attribute]);
        }

        return $provider;
    }
}