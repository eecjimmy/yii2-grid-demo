<?php

use yii\bootstrap5\LinkPager;
use yii\grid\CheckboxColumn;
use app\models\Supplier;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var \app\models\SupplierGrid $grid */
/** @var View $this */
$this->registerJs(<<<JAVASCRIPT

JAVASCRIPT
    , View::POS_READY)
?>
<style>
    table > thead a.asc:after {content: "↑"}
    table > thead a.desc:after {content: "↓"}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?= Html::beginForm(Url::canonical(), 'get') ?>
                <div class="row">
                    <div class="col">
                        <?= Html::textInput('id', $grid->id, ['placeholder' => $grid->getAttributeLabel('id'), 'class' => ['form-control']]) ?>
                    </div>
                    <div class="col">
                        <?= Html::textInput('name', $grid->name, ['placeholder' => $grid->getAttributeLabel('name'), 'class' => ['form-control']]) ?>
                    </div>
                    <div class="col">
                        <?= Html::textInput('code', $grid->code, ['placeholder' => $grid->getAttributeLabel('code'), 'class' => ['form-control']]) ?>
                    </div>
                    <div class="col">
                        <?= Html::dropDownList('t_status', $grid->t_status, Supplier::tStatuses(), ['prompt' => sprintf('请选择%s', $grid->getAttributeLabel('t_status')), 'class' => ['form-select']]) ?>
                    </div>
                    <div class="col">
                        <div class="btn-group">
                            <?= Html::submitButton('筛选', ['class' => ['btn', 'btn-primary']]) ?>
                            <?= Html::submitButton('导出全部', ['class' => ['btn', 'btn-secondary'], 'name' => 'is_export', 'value' => 1]) ?>
                        </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $grid->getProvider(),
                    'columns' => [
                        ['class' => CheckboxColumn::class],
                        ['attribute' => 'id'],
                        ['attribute' => 'name'],
                        ['attribute' => 'code'],
                        ['attribute' => 't_status', 'value' => 'tStatusName'],
                    ],
                    'pager' => [
                        'class' => LinkPager::class,
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>