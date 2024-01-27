<?php

use backend\models\TbInvoice;
use backend\models\TbWorkOrder;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TbEstimationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Estimasi';
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
            <div class="tb-estimation-index">
            <p>
                <?= Html::a('Tambah Estimasi', ['create'], ['class' => 'btn btn-success']) ?>
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
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view} {update} {delete} {printestimation} {generate-work-order}',
                                'buttons' => [
                                    'view' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                            ['detail', 'id' => $model['id']], 
                                            ['title' => 'View', 'class' => 'popupEstimation', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'update' => function($url, $model) {
                                        if ($model->is_work_order == TbWorkOrder::IS_NOT_WORK_ORDER) {
                                            return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                                ['update', 'id' => $model['id']], 
                                                ['title' => 'Update', 'data' => 
                                                ['pjax' => 1]
                                            ]);
                                        }
                                    },
                                    'delete' => function($url, $model) {
                                        if ($model->is_work_order == TbWorkOrder::IS_NOT_WORK_ORDER) {
                                            return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                                ['delete', 'id' => $model['id']], 
                                                ['title' => 'Delete', 'class' => '', 'data' => 
                                                [
                                                    'confirm' => 'Menghapus data ini menyebabkan service juga ikut terhapus. Apakah Anda yakin ingin menghapus data ini?', 'method' => 'post', 'pjax' => 1],
                                            ]);
                                        }
                                    },
                                    'printestimation' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-money-check"></i></button>', 
                                            ['print-estimation', 'id' => $model['id']], 
                                            ['title' => 'Print Estimasi', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'generate-work-order' => function($url, $model) {
                                        if ($model->is_invoice == TbInvoice::IS_INVOICE) { // jika invoice sudah dibuat
                                            if ($model->workOrder->invoice !== null && $model->workOrder->invoice->is_out == TbInvoice::IS_OUT) { // namun statusnya sudah dibayar
                                                return Html::a('<button class="btn btn-sm btn-success disabled"> Invoice sudah dibayar </button>');
                                            } else { // jika belum dibayar
                                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Wo & Invoice sudah dibuat </button>', 
                                                    ['tb-invoice/view', 'id' => $model->workOrder->invoice->id], 
                                                    ['title' => 'Check Invoice', 'data' => ['method' => 'post']]
                                                );
                                            }
                                        } else { // jika invoice belum dbuat
                                            if ($model->is_work_order == TbWorkOrder::IS_WORK_ORDER && 
                                                $model->is_invoice == TbInvoice::IS_NOT_INVOICE) { // jika work order sudah dibuat dan invoice belum dibuat
                                                return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-arrow-right"></i> Work Order Berhasil Dibuat, Mau Lihat? </button>',
                                                    ['view-work-order', 'id' => $model['id']],
                                                    ['title' => 'Lihat Work Order']
                                                );
                                            } 
                                            else { // jika tidak, maka buat work order terlebih dahulu
                                                return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-arrow-right"></i> Buat Work Order </button>', 
                                                    ['generate-work-order', 'id' => $model['id']], 
                                                    ['title' => 'Generate Work Order', 'data' => 
                                                        ['confirm' => 'Apakah Anda ingin buatkan Work Order dari Estimasi ini?', 'method' => 'post', 'pjax' => 1],
                                                    ]
                                                );
                                            }
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
$(".popupEstimation").on("click", function(e) {
    e.preventDefault();
    url = $(this).attr('href');
    $('#popupEstimation')
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
    'id' => 'popupEstimation',
    'size' => Modal::SIZE_LARGE,
    'title' => 'Rincian Data Estimasi',
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