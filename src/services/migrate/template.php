use {{NAMESPACE}};
use yii\db\Migration;

/**
 * Class {{MIGRATION_CLASS_NAME}}
 */
class {{MIGRATION_CLASS_NAME}} extends Migration
{
    public $tableName;

    public function init()
    {
        parent::init();
        $this->tableName = {{CLASS_NAME}}::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
{{COLUMNS}}
        ]);

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
        echo "{{MIGRATION_CLASS_NAME}} cannot be reverted.\n";

        return false;
    }
    */
}
