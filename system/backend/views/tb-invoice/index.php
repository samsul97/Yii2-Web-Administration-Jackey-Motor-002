<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TbInvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Invoice';
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
                            // 'id',
                            // 'no_invoice',
                            'received',
                            'regdate',
                            'datein',
                            'dateout',
                            'km',
                            [
                            'format' => 'raw',
                            'attribute' => 'is_invoice',
                            'value' => function ($model) {
                                if ($model->is_invoice == 0) {
                                    return '<button class="btn btn-danger disable">'. 'Invoice' .'</button>';
                                } else {
                                    return '<button class="btn btn-warning disable">'. 'Estimation' .'</button>';
                                }
                            },
                                'filter'=>[
                                    0 => 'Invoice',
                                    1 => 'Estimation',
                                ],
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'is_out',
                                'value' => function ($model) {
                                    if ($model->is_out == 0) {
                                        return Html::a('<button class ="btn btn-'. ($model->is_out == 0 ? 'info' : 'secondary') .'"> '. ($model->is_out == 0 ? '' : 'Sudah di ') .'Process </button>', ['tb-invoice/edit-status', 'id' => $model->id, 'is_out' => ($model->is_out == 0 ? 1 : 1)], ['data' => ['confirm' => ($model->is_out == 0 ? 'Apa Anda yakin Invoice ini sudah terbayar?' : false)],]);
                                    } else {
                                        return '<button class="btn btn-success disable">'. "Payment Success" .'</button>';
                                    }
                                },
                                'filter'=>[
                                    0 => 'Process',
                                    1 => 'Payment Success',
                                ],
                            ],
                            'timestamp',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view} {update} {printinvoice} {wo}',
                                'buttons' => [
                                    'view' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                            ['detail', 'id' => $model['id']], 
                                            ['title' => 'View', 'class' => 'popupInvoice', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'update' => function($url, $model) {
                                        if ($model->is_out == 0) {
                                            return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                                ['update', 'id' => $model['id']], 
                                                ['title' => 'Update', 'data' => 
                                                ['pjax' => 1]
                                            ]);
                                        }
                                    },
                                    'printinvoice' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-money-check"></i></button>', 
                                            ['print-invoice', 'id' => $model['id']], 
                                            ['title' => 'Print Invoice', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                    'delete' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                            ['delete', 'id' => $model['id']], 
                                            ['title' => 'Delete', 'class' => '', 'data' => 
                                            ['confirm' => 'Apakah anda ingin menghapus data ?', 'method' => 'post', 'pjax' => 1],
                                        ]);
                                    },
                                    'wo' => function($url, $model) {
                                        return Html::a('<button class="btn btn-sm btn-info"><i class="fa fa-money-check"></i></button>', 
                                            ['print-mechanic', 'id' => $model['id']], 
                                            ['title' => 'Print Working Order', 'data' => 
                                            ['pjax' => 1]
                                        ]);
                                    },
                                ]
                            ],
                        ];

                        echo ExportMenu::widget([
                            'filterModel' => $searchModel,
                            'columns' => $gridColumns,
                            'dataProvider' => $dataProvider,
                            'filename' => 'Data Invoice',
                            //'stream' => false,
                            //'linkPath' => false,
                            // 'batchSize' => 1024,
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