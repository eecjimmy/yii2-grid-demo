<?php


namespace app\controllers\cli;


use app\controllers\CliController;
use app\services\migrate\Import;

/**
 * 开发工具箱
 * @package console\controllers
 */
class DevController extends CliController
{
    /**
     * 为AR类(ActiveRecord)生成可迁移文件(migration file)
     * @param $class
     * @return int
     */
    public function actionMigration($class)
    {
        $model = new Import();
        $model->class = $class;
        if ($filename = $model->generate()) {
            $this->stdout("generate ok: `{$filename}`.\n");
            return 0;
        } else {
            $this->stderr("generate failed: " . $model->getFirstError('import') . "\n");
            return 1;
        }
    }
}