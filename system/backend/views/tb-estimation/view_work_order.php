<?php

use backend\models\TbInvoice;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\TbInvoice */

$this->title = 'Work Order Milik : ' .  $workOrder->customer->name;
$this->params['breadcrumbs'][] = ['label' => 'Work Order Dari Estimasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="work-order-view">
                <p>
                    <?= Html::a('<i class="fa fa-print"></i> Cetak Work Order', [
                        'tb-work-order/print-working-order', 
                        'id' => $workOrder->id], 
                        ['class' => 'btn btn-warning'])
                    ?>
                    <?= Html::a(
                        ($model->is_invoice == TbInvoice::IS_INVOICE && $model->workOrder->invoice->is_out == TbInvoice::IS_OUT)
                            ? '<button class="btn btn btn-success disabled"><i class="fa fa-arrow-right"></i> Invoice Has Been Paid </button>'
                            : '<button class="btn btn btn-info"><i class="fa fa-arrow-right"></i> Buat Invoice </button>',
                        ($model->is_invoice == TbInvoice::IS_INVOICE && $model->workOrder->invoice->is_out == TbInvoice::IS_OUT)
                            ? 'javascript:void(0);'
                            : ['tb-work-order/generate-invoice', 'id' => $model->workOrder->id],
                        [
                            'title' => ($model->is_invoice == TbInvoice::IS_INVOICE && $model->workOrder->invoice->is_out == TbInvoice::IS_OUT)
                                ? 'Invoice Has Been Paid'
                                : 'Generate Invoice',
                            'data' => [
                                'confirm' => ($model->is_invoice == TbInvoice::IS_INVOICE && $model->workOrder->invoice->is_out == TbInvoice::IS_OUT)
                                    ? ''
                                    : 'Apakah Anda ingin membuat Invoice dari Work Order ini?',
                                'method' => 'post',
                                'pjax' => 1,
                            ],
                        ]
                    );
                    ?>
                </p>

                <?= DetailView::widget([
                    'model' => $workOrder,
                    'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
                    'attributes' => [
                        [
                            'label' => 'Name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->name;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Address',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->address;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Phone',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->phone;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Chasis',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->chasis;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Plate',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->plate;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Engine',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->engine;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Model',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->model;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Merk',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->merk;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        [
                            'label' => 'Regdate',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->customer->regdate;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                        'broughtin',
                        'received',
                        'datein',
                        'dateout',
                    ],
                ]) ?>

                <?= GridView::widget([
                    'dataProvider'=>new yii\data\ActiveDataProvider([
                        'query'=> $workOrder->getServiceItems(),
                        'pagination'=>false,
                    ]),
                    'columns'=>[
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'No',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' => 'text-align:center']
                        ],
                        [
                            'attribute' => 'name',
                            'label' => 'Service And Supplies',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (empty($model->qty)) {
                                    return nl2br($model->name);
                                } else {
                                    return $model->name;
                                }
                            },
                            'contentOptions' => ['class' => 'text-left'],
                        ],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>
