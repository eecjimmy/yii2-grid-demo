<?php

namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * SupplierGrid
 */
class SupplierGrid extends Supplier
{
    /**
     * 允许搜索的检索的字段
     * 字段名 => 检索方式
     * @var string[]
     */
    public array $searchAttributes = [
        'id' => '=',
        'name' => 'like',
        'code' => 'like',
        't_status' => '=',
    ];

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

    public function getProvider(): ActiveDataProvider
    {
        $query = static::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);
        foreach ($this->safeAttributes() as $attribute) {
            if (empty($this->searchAttributes[$attribute])) continue;
            if (!$this->validate($attribute)) continue; // 搜索字段校验未通过

            $op = $this->searchAttributes[$attribute];
            $query->andFilterWhere([$op, $attribute, $this->$attribute]);
        }

        return $provider;
    }
}