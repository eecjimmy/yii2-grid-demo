<?php


namespace app\services\migrate;


use yii\base\Model;
use ReflectionClass;
use ReflectionException;
use Yii;
use yii\console\Application;
use yii\db\ActiveRecord;
use yii\helpers\Console;
use yii\helpers\Inflector;

/**
 * Class Import
 * @package console\models\migrate
 */
class Import extends Model
{
    public $class;

    public $dir = '@app/migrations/databases';

    public function rules()
    {
        return [
            ['class', 'validateClass'],
        ];
    }

    public function validateClass($attr)
    {
        if ($this->hasErrors()) return;

        $class = $this->$attr;
        if (!class_exists($class)) {
            $this->addError($attr, "类`{$class}`未找到");
            return;
        }
        if (!is_subclass_of($class, ActiveRecord::class)) {
            $this->addError($attr, "类`{$class}`必须继承`" . ActiveRecord::class . "`");
            return;
        }

        $properties = $this->getClassProperties();
        if (empty($properties)) {
            $this->addError($attr, "类`{$class}`注释为空或者格式错误");
            return;
        }
    }

    public function generate()
    {
        if (!$this->validate()) return false;
        $content = $this->buildContent();
        $filename = Yii::getAlias($this->getFilename());
        $dir = dirname($filename);
        if (!is_dir($dir)) @mkdir($dir, 0755, true);

        if (Yii::$app instanceof Application) {
            if (Console::confirm("确认生成文件`{$filename}`?")) {
                file_put_contents($filename, $content);
            } else {
                $this->addError('generate', '已取消!');
                return false;
            }
        } else {
            file_put_contents($filename, $content);
        }

        return $filename;
    }

    public function getFilename()
    {
        $name = str_replace('common\\orm\\', '', $this->getFullClassName());
        $arr = preg_split('/\\\\/', $name);
        array_pop($arr);
        $name = implode('/', array_map(function ($a) {
            return Inflector::camel2id($a, '_');
        }, $arr));
        $name .= "/" . $this->getMigrationClassName() . '.php';
        return $this->dir . "/" . $name;
    }

    public function buildContent()
    {
        $template = file_get_contents(__DIR__ . '/template.php');
        return "<?php\n" . preg_replace_callback('/{{([^}]+)}}/i', function ($matched) {
                $columns = [];
                foreach ($this->getClassProperties() as $property) {
                    $column = $property->buildColumn();
                    $columns[] = "            {$column},";
                }
                $map = [
                    'NAMESPACE' => $this->getFullClassName(),
                    'MIGRATION_CLASS_NAME' => $this->getMigrationClassName(),
                    'CLASS_NAME' => $this->getShortClassName(),
                    'COLUMNS' => implode(PHP_EOL, $columns),
                ];
                $find = $matched[1];
                return isset($map[$find]) ? $map[$find] : $matched[0];
            }, $template);
    }

    public function getMigrationClassName()
    {
        return 'm' . gmdate('ymd_His') . '_' . Inflector::camel2id($this->getShortClassName(), '_');
    }

    /**
     * 获取属性
     * @return Property[]
     */
    public function getClassProperties()
    {
        try {
            $ref = new ReflectionClass($this->class);
        } catch (ReflectionException $e) {
            return [];
        }
        $comment = $ref->getDocComment();
        $regexp = ' /@property\s*(.*)$/im';
        $attributes = [];
        if (!preg_match_all($regexp, $comment, $matched)) {
            return $attributes;
        }

        $properties = [];
        foreach ($matched[1] as $line) {
            $arr = preg_split("/\s+/", $line);
            $arr = array_filter($arr);
            $num = count($arr);
            $property = new Property();
            if ($num === 1) {
                $property->name = trim($arr[0], '$');
            } elseif ($num === 2) {
                if (substr($arr[0], 0, 1) === '$') {
                    $property->name = substr($arr[0], 1);
                    $property->comment = $arr[1];
                } else {
                    $property->type = $arr[0];
                    $property->name = substr($arr[1], 1);
                }
            } else {
                $property->type = $arr[0];
                $property->name = substr($arr[1], 1);
                $property->comment = implode(' ', array_slice($arr, 2));
            }

            $properties[] = $property;
        }
        return $properties;
    }

    public function getShortClassName()
    {
        try {
            $ref = new ReflectionClass($this->class);
        } catch (ReflectionException $e) {
            return null;
        }
        return $ref->getShortName();
    }

    public function getColumns()
    {
        $columns = [];
        foreach ($this->getClassProperties() as $property) {
            $columns[] = $property->buildColumn();
        }

        return implode(",", $columns);
    }

    public function getFullClassName()
    {
        try {
            $ref = new ReflectionClass($this->class);
        } catch (ReflectionException $e) {
            return null;
        }
        return $ref->getName();
    }

    public function getTableName()
    {
        return call_user_func([$this->class, 'tableName']);
    }
}