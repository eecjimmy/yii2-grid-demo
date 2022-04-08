<?php

use yii\grid\CheckboxColumn;
use app\models\Supplier;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\SupplierGrid $grid */
?>
<div style="margin: 40px;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?= Html::beginForm(Url::canonical(), 'get') ?>
                <?= Html::textInput('id', $grid->id, ['placeholder' => $grid->getAttributeLabel('id'), 'class' => ['form-control']]) ?>
                <?= Html::textInput('name', $grid->name, ['placeholder' => $grid->getAttributeLabel('name'), 'class' => ['form-control']]) ?>
                <?= Html::textInput('code', $grid->code, ['placeholder' => $grid->getAttributeLabel('code'), 'class' => ['form-control']]) ?>
                <?= Html::dropDownList('t_status', $grid->t_status, Supplier::tStatuses(), ['prompt' => sprintf('请选择%s', $grid->getAttributeLabel('t_status')), 'class' => ['form-control']]) ?>
                <?= Html::submitButton('筛选', ['class' => ['btn', 'btn-info']]) ?>
                <?= Html::submitButton('导出全部', ['class' => ['btn', 'btn-info'], 'name' => 'is_export', 'value' => 1]) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $grid->getProvider(),
                    'columns' => [
                        ['class' => CheckboxColumn::class],
                        ['attribute' => 'id'],
                        ['attribute' => 'name'],
                        ['attribute' => 'code'],
                        ['attribute' => 't_status', 'value' => 'tStatusName'],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>