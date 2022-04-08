<?php

use app\models\SupplierGrid;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var SupplierGrid $grid */

?>

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
<?= Html::submitButton("确定", ['class' => ['btn', 'btn-success']]) ?>
<?= Html::endForm() ?>
