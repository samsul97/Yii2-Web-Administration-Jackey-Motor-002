<?php

use backend\models\TbEstimation;
use backend\models\TbInvoice;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TbWorkOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Work Order';
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
            <div class="tb-work-order-index">
            <p>
                <?= Html::a('Tambah Work Order', ['create'], ['class' => 'btn btn-success']) ?>
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
                            [
                                'attribute' => 'id_customer',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->customer->name . '-' . $model->customer->plate;
                                },
                            ],
                            'received',
                            'broughtin',
                            'datein',
                            'dateout',
                            [
                                'format' => 'raw',
                                'attribute' => 'generate_status',
                                'value' => function ($model) {
                                    if ($model->generate_status == TbEstimation::FROM_ESTIMATION) {
                                        return '<button class="btn btn-info disable">'. 'Estimation' .'</button>';
                                    } else {
                                        return '<button class="btn btn-warning disable">'. 'Work Order' .'</button>';
                                    }
                                },
                                    'filter'=>[
                                        1 => 'Estimation',
                                        0 => 'Work Order',
                                    ],
                                ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view} {update} {delete} {print-working-order} {generate-invoice}',
                                'buttons' => [
                                    'view' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                            ['detail', 'id' => $model['id']], 
                                            ['title' => 'View', 'class' => 'popupWorkOrder', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'update' => function($url, $model) {
                                        if ($model->is_invoice == TbInvoice::IS_NOT_INVOICE) {
                                            return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                                ['update', 'id' => $model['id']], 
                                                ['title' => 'Update', 'data' => 
                                                ['pjax' => 1]
                                            ]);
                                        }
                                    },
                                    'delete' => function($url, $model) {
                                        if ($model->is_invoice == TbInvoice::IS_NOT_INVOICE) {
                                            return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                                ['delete', 'id' => $model['id']], 
                                                ['title' => 'Delete', 'data' => 
                                                ['confirm' => 'Apakah anda ingin menghapus data ?', 'method' => 'post', 'pjax' => 1],
                                            ]);
                                        }
                                    },
                                    'print-working-order' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-wrench"></i></button>', 
                                            ['print-working-order', 'id' => $model['id']], 
                                            ['title' => 'Cetak Working Order', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'generate-invoice' => function($url, $model) {
                                        if ($model->is_invoice == TbInvoice::IS_INVOICE) {
                                            if ($model->invoice !== null && 
                                                $model->invoice->is_out == TbInvoice::IS_OUT) {
                                                return Html::a('<button class="btn btn-sm btn-success disabled"> Invoice sudah dibayar </button>');
                                            } else {
                                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Invoice sudah dibuat</button>', 
                                                    ['tb-invoice/view', 'id' => $model->invoice->id], 
                                                    ['title' => 'Check Invoice', 'data' => ['method' => 'post']]
                                                );
                                            }
                                        } else {
                                            return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Buat Invoice</button>', 
                                                ['generate-invoice', 'id' => $model['id']],
                                                ['title' => 'Generate Invoice', 'data' => 
                                                    ['confirm' => 'Apakah Anda ingin membuat Invoice dari Work Order ini?', 'method' => 'post', 'pjax' => 1],
                                                ]
                                            );
                                        }
                                    },
                                ]
                            ],
                        ];
                        echo ExportMenu::widget([
                            'filterModel' => $searchModel,
                            'columns' => $gridColumns,
                            'dataProvider' => $dataProvider,
                            'filename' => 'Data Work Order',
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
$js = <<< JS
$(".popupWorkOrder").on("click", function(e) {
    e.preventDefault();
    url = $(this).attr('href');
    $('#popupWorkOrder')
        .modal('show')
        .find('.modal-body')
        .html('Loading ...')
        .load(url);
        return false;
});
JS;

$this->registerJs($js);

Modal::begin([
    'id' => 'popupWorkOrder',
    'size' => Modal::SIZE_LARGE,
    'title' => 'Work Order',
    'closeButton' => [
        'id'=>'close-button',
        'class'=>'close',
        'data-dismiss' =>'modal',
    ],
    'clientOptions' => [
        'backdrop' => false, 'keyboard' => true
    ]
]);

Modal::end();