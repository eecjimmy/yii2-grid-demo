<?php


namespace app\services\migrate;


use yii\base\Component;
use yii\helpers\StringHelper;

/**
 * Class Property
 * @package console\models\migrate
 * @property bool $string
 */
class Property extends Component
{
    public $name;
    public $type;
    public $comment;

    public function buildColumn()
    {
        if ($column = $this->getByName()) {
            return sprintf("'%s' => %s", $this->name, $column);
        }

        if ($column = $this->getByType()) {
            return sprintf("'%s' => %s", $this->name, $column);
        }

        $column = sprintf('$this->string()->comment(\'%s\')', $this->comment);
        return sprintf("'%s' => %s", $this->name, $column);
    }

    protected function getByName()
    {
        $map = [
            'id' => '$this->primaryKey()',
            'content' => '$this->text()',
            '*_at' => sprintf('$this->integer()->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            'is_*' => sprintf('$this->tinyInteger(1)->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            '*_state' => sprintf('$this->tinyInteger()->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            '?id' => sprintf('$this->integer()->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
        ];
        foreach ($map as $name => $column) {
            if (StringHelper::matchWildcard($name, $this->name)) {
                return $column;
            }
        }
        return null;
    }

    protected function getByType()
    {
        $map = [
            'string' => sprintf('$this->string()->notNull()->defaultValue(\'\')->comment(\'%s\')', $this->comment),
            'int' => sprintf('$this->integer()->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            'integer' => sprintf('$this->integer()->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            'boolean' => sprintf('$this->tinyint(1)->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            'bool' => sprintf('$this->tinyint(1)->notNull()->unsigned()->defaultValue(0)->comment(\'%s\')', $this->comment),
            'number' => sprintf('$this->decimal(19, 2)->unsigned()->notNull()->defaultValue(0)->comment(\'%s\')', $this->comment),
        ];
        $type = $this->type;
        if (isset($map[$type])) return $map[$type];

        return null;
    }
}