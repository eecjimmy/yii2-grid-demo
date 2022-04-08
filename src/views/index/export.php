<?php

use app\models\SupplierGrid;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var SupplierGrid $grid */
/** @var View $this */
$this->registerJs(<<<JS
$("#btnBack").on('click',function(){
    window.history.back()
    return false;
})

JS
    , View::POS_READY);

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                导出数据
            </div>
            <div class="panel-body">
                <?= Html::beginForm(Url::toRoute(['export']), 'POST') ?>
                <?= Html::checkboxList('exportAttributes', null, $grid->attributeLabels(), [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $fixed = $value == 'id';
                        return Html::checkbox($name, $fixed, ['value' => $value, 'label' => Html::encode($label), 'id' => 'id']);
                    },
                ]) ?>
                <?php foreach (Yii::$app->request->get() as $k => $v): ?>
                    <?= Html::hiddenInput($k, $v) ?>
                <?php endforeach ?>
                <div class="btn-group">
                    <?= Html::submitButton("确定", ['class' => ['btn', 'btn-primary']]) ?>
                    <?= Html::button("返回", ['class' => ['btn', 'btn-secondary'], 'id' => 'btnBack']) ?>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>