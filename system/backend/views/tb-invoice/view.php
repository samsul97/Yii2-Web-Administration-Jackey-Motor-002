<?php

use backend\models\TbInvoice;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\TbInvoice */

$this->title = 'Invoice Milik : ' . $model->customer->name . ' Dengan Nomor Invoice ' . $model->no_invoice;
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
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
            <div class="tb-invoice-view">
                <p>
                    <?php if ($model->is_out == TbInvoice::IS_NOT_OUT) : { ?>
                        <?= Html::a('Edit Invoice', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete Invoice', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Menghapus data ini menyebabkan service, work order, dan estimation yang terhubung juga ikut terhapus. Apakah Anda yakin ingin menghapus data ini?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php } endif  ?>

                    <?= Html::a('<i class="fa fa-print"></i> Cetak Invoice', ['print-invoice', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('<i class="fa fa-wrench"></i> Cetak Working Order', ['tb-work-order/print-working-order', 'id' => $model->workOrder->id], ['class' => 'btn btn-danger']) ?>
                    
                    <?php if ($model->generate_status == TbInvoice::FROM_WORK_ORDER_AND_ESTIMATION && $model->workOrder->estimation) : { ?>
                        <?= Html::a('<i class="fa fa-money-check"></i> Cetak Estimasi', ['tb-estimation/print-estimation', 'id' => $model->workOrder->estimation->id], ['class' => 'btn btn-info']) ?>
                    <?php } endif ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
                    'attributes' => [
                        [
                            'format' => 'raw',
                            'attribute' => 'is_out',
                            'value' => function ($model) {
                                if ($model->is_out == TbInvoice::IS_NOT_OUT) {
                                    return Html::a('<button class ="btn btn-'. ($model->is_out == 0 ? 'danger' : 'secondary') .'"> '. ($model->is_out == 0 ? '' : 'Sudah di ') .'Unpaid </button>', ['tb-invoice/edit-status', 'id' => $model->id, 'is_out' => ($model->is_out == 0 ? 1 : 1)], ['data' => ['confirm' => ($model->is_out == 0 ? 'Apa Anda yakin Invoice ini sudah terbayar?' : false)],]);
                                } else {
                                    return '<button class="btn btn-success disable">'. "Paid" .'</button>';
                                }
                            },
                            'filter'=>[
                                0 => 'Unpaid',
                                1 => 'Paid',
                            ],
                        ],
                        [
                            'format' => 'raw',
                            'attribute' => 'generate_status',
                            'value' => function ($model) {
                                if ($model->generate_status == TbInvoice::FROM_WORK_ORDER) {
                                    return '<button class="btn btn-danger disable">'. 'Work Order' .'</button>';
                                } else {
                                    return '<button class="btn btn-warning disable">'. 'WO & Estimation' .'</button>';
                                }
                            },
                                'filter'=>[
                                    0 => 'Work Order',
                                    1 => 'Wo & Estimation',
                                ],
                        ],
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
                        'query'=> $model->getServiceItems(),
                        'pagination'=>false,
                    ]),
                    'showFooter' => true,
                    'columns'=>[
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
                        'qty',
                        [
                            'attribute' => 'price',
                            'label' => 'Harga',
                            'value' => function($model) {
                                return number_format($model->price, 2);
                            }
                        ],
                        [
                            'attribute' => 'amount',
                            'value' => function($model) {
                                return number_format($model->amount, 2);
                            },
                            'footer' => '<b> Rp.' . number_format($serviceAmount, 2) . '</b>',       
                        ],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>
