<?php

use backend\models\TbInvoice;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TbInvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Invoice';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="tb-invoice-index">
            <p>
                <?= Html::a('Tambah Invoice', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="table-responsive table-nowrap">
                    <?php
                        $gridColumns = [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'No',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'contentOptions' => ['style' => 'text-align:center']
                            ],
                            'received',
                            'broughtin',
                            'datein',
                            'dateout',
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
                                'format' => 'raw',
                                'attribute' => 'is_out',
                                'value' => function ($model) {
                                    if ($model->is_out == TbInvoice::IS_NOT_OUT) {
                                        $icon = ($model->is_out == 0) ? '<i class="fa fa-times"></i> ' : '<i class="fa fa-check"></i> ';
                                        return Html::a(
                                            '<button class="btn btn-' . ($model->is_out == 0 ? 'danger' : 'secondary') . '">' . $icon . ($model->is_out == 0 ? '' : 'Sudah di ') . 'Belum dibayar </button>',
                                            ['tb-invoice/edit-status', 'id' => $model->id, 'is_out' => ($model->is_out == 0 ? 1 : 1)],
                                            ['data' => ['confirm' => ($model->is_out == 0 ? 'Apa Anda yakin Invoice ini sudah terbayar?' : false)]]
                                        );
                                    } else {
                                        return '<button class="btn btn-success disable"><i class="fa fa-check"></i> Dibayar</button>';
                                    }
                                },
                                'filter'=>[
                                    0 => 'Unpaid',
                                    1 => 'Paid',
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{detail} {view} {update} {delete} {print-invoice} {print-working-order} {print-estimation}',
                                'buttons' => [
                                    'detail' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                            ['detail', 'id' => $model['id']], 
                                            ['title' => 'Quick View', 'class' => 'popupInvoice', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'view' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></button>', 
                                            ['view', 'id' => $model['id']], 
                                            [
                                                'title' => 'View', 'data' => ['pjax' => 1]
                                            ]
                                        );
                                    },
                                    'update' => function($url, $model) {
                                        if ($model->is_out == TbInvoice::IS_NOT_OUT) {
                                            return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                                ['update', 'id' => $model['id']], 
                                                ['title' => 'Update', 'data' => 
                                                ['pjax' => 1]
                                            ]);
                                        }
                                    },
                                    'delete' => function($url, $model) {
                                        if ($model->is_out == TbInvoice::IS_NOT_OUT) {
                                            return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                                ['delete', 'id' => $model['id']], 
                                                ['title' => 'Delete', 'class' => '', 'data' => 
                                                ['confirm' => 'Menghapus data ini menyebabkan service, work order, dan estimation yang terhubung juga ikut terhapus. Apakah Anda yakin ingin menghapus data ini?', 'method' => 'post', 'pjax' => 1],
                                            ]);
                                        }
                                    },
                                    'print-invoice' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-warning"><i class="fa fa-print"></i></button>', 
                                            ['print-invoice', 'id' => $model['id']], 
                                            ['title' => 'Cetak Invoice', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'print-working-order' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-wrench"></i></button>', 
                                            ['tb-work-order/print-working-order', 'id' => $model->workOrder->id], 
                                            ['title' => 'Cetak Working Order'
                                        ]);
                                    },
                                    'print-estimation' => function($url, $model) {
                                        if ($model->generate_status == TbInvoice::FROM_WORK_ORDER_AND_ESTIMATION &&
                                            $model->workOrder->estimation) {
                                            return Html::a('<button class="btn btn-sm btn-info"><i class="fa fa-money-check"></i></button>', 
                                                ['tb-estimation/print-estimation', 'id' => $model->workOrder->estimation->id], 
                                                ['title' => 'Cetak Estimasi'
                                            ]);
                                        }
                                    },
                                ]
                            ],
                        ];

                        echo ExportMenu::widget([
                            'filterModel' => $searchModel,
                            'columns' => $gridColumns,
                            'dataProvider' => $dataProvider,
                            'filename' => 'Data Invoice',
                        ]);
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumns,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
// id dari button dilempar ke jquery dengan cara attr('href)
$js = <<< JS
$(".popupInvoice").on("click", function(e) {
    e.preventDefault();
    url = $(this).attr('href');
    $('#popupInvoice')
        .modal('show')
        .find('.modal-body')
        .html('Loading ...')
        .load(url);
        return false;
});
JS;

$css = <<< CSS
CSS;

$this->registerJs($js);
$this->registerCss($css);

Modal::begin([
    'id' => 'popupInvoice',
    'size' => Modal::SIZE_LARGE,
    'title' => 'Data Customer',
    'closeButton' => [
        'id'=>'close-button',
        'class'=>'close',
        'data-dismiss' =>'modal',
    ],
    // keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => [
        'backdrop' => false, 'keyboard' => true
    ]
]);

Modal::end();