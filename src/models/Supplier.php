<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Supplier
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $t_status
 *
 * @property-read string $tStatusName
 */
class Supplier extends ActiveRecord
{
    const T_STATUS_OK = 'ok';
    const T_STATUS_HOLD = 'hold';

    /**
     * all t_statuses
     * @return string[]
     */
    public static function tStatuses(): array
    {
        return [
            self::T_STATUS_OK => 'OK',
            self::T_STATUS_HOLD => 'HOLD',
        ];
    }

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return '{{%suppliers}}';
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'code' => '编码',
            't_status' => '状态',
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 50],

            ['code', 'required'],
            ['code', 'string', 'max' => 3],

            ['t_status', 'string'],
            ['t_status', 'default', 'value' => self::T_STATUS_OK],
            ['t_status', 'in', 'range' => array_keys(self::tStatuses())],
        ];
    }

    // generate mock data
    public static function mockData($num = 100)
    {
        do {
            try {
                $s = new static();
                $statuses = array_keys(self::tStatuses());
                $tStatus = $statuses[array_rand($statuses)];
                $s->setAttributes([
                    'name' => uniqid("Name"),
                    'code' => (string)mt_rand(100, 999),
                    't_status' => $tStatus,
                ]);
                if (!$s->save()) {
                    Yii::warning($s->getErrors());
                    break;
                }
                $num--;
            } catch (\yii\base\Exception $e) {
            }
        } while ($num > 0);
    }

    /**
     * @throws \Exception
     */
    public function getTStatusName()
    {
        return ArrayHelper::getValue(self::tStatuses(), $this->t_status);
    }
}