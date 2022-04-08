<?php

use app\models\Supplier;
use yii\db\Migration;

/**
 * Class m220407_093015_supplier
 */
class m220407_093015_supplier extends Migration
{
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = Supplier::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->defaultValue('')->comment(''),
            'code' => $this->char(3)->notNull()->defaultValue('')->comment(''),
            't_status' => 'ENUM("ok", "hold")',
        ]);

        $this->createIndex('uk_code', $this->tableName, 'code', true);
        $this->createIndex('idx_t_status', $this->tableName, 't_status');
        Supplier::mockData(500); // 生成虚拟数据

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220407_093015_supplier cannot be reverted.\n";

        return false;
    }
    */
}