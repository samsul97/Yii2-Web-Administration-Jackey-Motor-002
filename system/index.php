<?php

use backend\models\MrTkp;
use backend\models\TbAssetsBroken;
use backend\models\TbAssetsMove;
use backend\models\TbAssets;
use backend\models\TbAssetsBrokenSearch;
use backend\models\TbAssetsRepair;
use backend\models\User;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
// use yii\grid\GridView;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use barcode\barcode\BarcodeGenerator;
use yii\web\Response;
use yii\helpers\Url;
// use yii\db\Expression;
// use Da\QrCode\QrCode;
// use Endroid\QrCode\QrCode;
// use odaialali\qrcodereader\QrReader;
// use mdq\instascan\QrReader;

$select_tkp = ArrayHelper::map(MrTkp::find()->asArray()->all(), 'id', function($model, $defaultValue){
    return $model['name'];
}
);

$select_user = ArrayHelper::map(User::find()->asArray()->all(), 'id', function($model, $defaultValue){
    return $model['name'];
}
);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TbAssetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Aset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card table-card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <!-- <h6>Jumlah saat ini adalah jumlah yang sudah dihitung dengan barang rusak</h6> -->
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="tb-assets-index">
                <p>
                    <?= Html::a('Tambah Aset', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-barcode"></i>', ['barcode-print'], ['class' => 'btn btn-danger']) ?>
                </p>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="table-responsive table-nowrap">
                <?php
                    $gridColumns = [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'No',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' => 'text-align:center']
                        ],
                        // [
                        //     'class' => 'kartik\grid\ExpandRowColumn',
                        //     'width' => '50px',
                        //     'expandAllTitle' => 'Expand all',
                        //     'collapseTitle' => 'Collapse all',
                        //     // 'expandIcon'=>'<span class="glyphicon glyphicon-expand"></span>',
                        //     // 'expandIcon' => '<span class="glyphicon glyphicon-triangle-right"></span>',
                        //     // 'collapseIcon' => '<span class="glyphicon glyphicon-triangle-bottom"></span>',
                        //     'value' => function ($model, $key, $index, $column) {
                        //         return GridView::ROW_COLLAPSED;
                        //     },
                        //     // 'value' => function ($model, $key, $index) {
                        //     //     if ($key % 2 === 0) {
                        //     //         return GridView::ROW_EXPANDED;
                        //     //     }
                        //     //     return GridView::ROW_COLLAPSED;
                        //     // },
                        //     'detail'=>function ($model, $key, $index, $column) {
                        //         // $searchModel = new TbAssetsBrokenSearch();
                        //         // $searchModel->id_tb_assets = $model->id;
                        //         // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                        //         // Jumlah barang rusak berdasarkan id
                        //         $model_broken = TbAssetsBroken::find()->where(['id_tb_assets' => $model->id])->all();
                        //         $sum_qty_broken = TbAssetsBroken::find()->where(['id_tb_assets' => $model_broken])->sum('qty_broken');
                        //         // var_dump($model_broken->qty_broken);
                        //         // die;
                        //         // Total barang pindah berdasarkan id (count qty)
                        //         $model_move = TbAssetsMove::find()->where(['id_tb_assets' => $model->id])->all();
                        //         $sum_qty_move = TbAssetsMove::find()->where(['id_tb_assets' => $model_move])->sum('qty_move');
                                
                        //         // total barang perbaikan berdasarkan id (count qty)
                        //         $model_repair = TbAssetsRepair::find()->where(['id_tb_assets' => $model->id])->all();
                        //         $sum_qty_repair = TbAssetsRepair::find()->where(['id_tb_assets' => $model_repair])->sum('qty_repair');
                                
                        //         return Yii::$app->controller->renderPartial('_detail.php', [
                        //             'model' => $model,
                        //             // 'searchModel' => $searchModel,
                        //             // 'dataProvider'=> $dataProvider,
                        //             'model_broken' => $sum_qty_broken,
                        //             'model_move' => $sum_qty_move,
                        //             'model_repair' => $sum_qty_repair
                        //             ]);
                        //     },
                        //     'enableCache' => false,
                        //     'headerOptions' => ['class' => 'kartik-sheet-style'],
                        //     'expandOneOnly' => true,
                        // ],
                        [
                            'format' => 'raw',
                            'label' => 'Barcode',
                            // 'options' => ['style' => 'padding:100px;'],
                            'attribute' => 'sku',
                            'value' => function($model) {
                                $optionsArray = array(
                                    'elementId'=> 'showBarcode' . '-' . $model->sku,
                                    'value'=> $model->sku,
                                    'type'=>'code39',
                                );
                                BarcodeGenerator::widget($optionsArray);
                                // if ($model->is_condition == "Broken") {
                                //     return '<div id="showBarcode-'.$model->sku.'"></div>';
                                // }
                                // else {
                                    return Html::a('<div id="showBarcode-'.$model->sku.'"></div>', ['update', 'id' => $model->id]);
                                // }
                            }
                        ],
                        [
                            'format' => 'raw',
                            'attribute' => 'name',
                            'value' => function($model) {
                                return Html::a($model->name, ['view', 'id' => $model->id]);
                            }
                        ],
                        'qty',
                        [
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'text-align:center'],
                            'contentOptions' => ['style' =>'text-align:center;'],
                            'attribute' => 'id_tkp',
                            'filter' => $select_tkp,
                            'value' => function ($data) {
                                $tkp = MrTkp::findOne($data['id_tkp']);
                                return $tkp['name'];
                            },
                        ],
                        // 'dop',
                        // [
                        //     'format' => 'raw',
                        //     'headerOptions' => ['style' => 'text-align:center'],
                        //     'contentOptions' => ['style' =>'text-align:center;'],
                        //     'attribute' => 'id_user',
                        //     'filter' => $select_user,
                        //     'value' => function ($data) {
                        //         $user = User::findOne($data['id_user']);
                        //         return $user['name'];
                        //     },
                        // ],
                        // [
                        //     'attribute' => 'is_condition',
                        //     'format' => 'raw',
                        //     'value' => function ($model) {
                        //         if ($model->is_condition == 'Good') {
                        //             return '<button class ="btn btn-info btn-sm">' . "Normal" . '</button>';
                        //             // return Html::a('Normal', ['repair-form', 'id' => $model->id, 'is_condition' => $model->is_condition == 'Abnormal'], ['class' => 'btn btn-info', 'data' => 
                        //             // ['confirm' => 'Apakah Anda ingin merubah menjadi Barang Tidak Normal?']]);
                        //         }
                        //         if ($model->is_condition == 'Abnormal') {
                        //             return '<button class ="btn btn-warning btn-sm">' . "Tidak Normal" . '</button>';
                        //             // return Html::a('Tidak Normal', ['good'], ['class' => 'btn btn-warning', 'data' => 
                        //             // ['confirm' => 'Apakah Anda ingin merubah menjadi Barang Normal?']]);
                        //             // '<button class ="btn btn-danger" onclick="alert(\'' . $model->condition_issue . '\')">' . "Tidak Baik" . '</button>';
                        //         }
                        //         if ($model->is_condition == 'Broken') {
                        //             return '<button class ="btn btn-danger btn-sm">' . "Rusak" . '</button>';
                        //         }
                        //     },
                            // 'filter' => [
                            //     'Good' => 'Normal',
                            //     'Abnormal' => 'Abnormal',
                            //     'Broken' => 'Rusak',
                            // ],
                        // ],
                        // 'status',
                        // 'sku',
                        // [
                        //     'format' => 'raw',
                        //     'label' => 'QrCode',
                        //     'attribute' => 'sku',
                        //     'value' =>function($model) {
                                // $qrCode = (new QrCode($model->sku));
                                // ->setSize(250)
                                // ->setMargin(5)
                                // ->useForegroundColor(51, 153, 255);
                                // $file = Yii::$app->params['upload'] . 'assets/code.png';
                                // $qrCode->writeFile(Yii::getAlias('@webroot') . $file);
                                // header('Content-Type: '.$qrCode->getContentType());
                                // return $qrCode->writeString();
                        //     }
                        // ],
                        // [
                        //     'format' => 'raw',
                        //     'label' => 'Qrcode',
                        //     'attribute' => 'sku',
                        //     'value' => function($model) {
                        //         echo $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                        //             'data' => 'http://www.bryantan.info',
                        //             'subfolderVar' => false,
                        //             'matrixPointSize' => 5,
                        //             'displayImage'=>true,
                        //             'errorCorrectionLevel'=>'L',
                        //             'matrixPointSize'=>4,
                        //         ));
                        //     }
                        // ],
                        // 'name',
                        // 'weight',
                        // 'brand',
                        // 'price',
                        // 'guarantee',
                        // 'completeness:ntext',
                        // 'qty',
                        // 'other_information',
                        // 'status',
                        // 'is_condition',
                        // 'timestamp',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Opsi',
                            'template' => '{view} {update} {delete} {detail}',
                            'buttons' => [
                                // 'update' => function($url, $model) {
                                //     if ($model->is_condition == "Broken") {
                                //         return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>',
                                //         ['index'], 
                                //         ['title' => 'Update', 'data' =>
                                //         ['confirm' => 'Barang Rusak Tidak Bisa Di Edit Kembali', 'pjax' => 1],
                                //     ]);
                                //     }
                                //     else {
                                //         return Html::a('<button class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>', 
                                //         ['update', 'id' => $model['id']], 
                                //         ['title' => 'Update', 'data' => 
                                //         ['pjax' => 1]
                                //     ]);
                                //     }
                                    
                                // },
                                // 'view' => function($url, $model) {
                                //     return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                //         ['view', 'id' => $model['id']], 
                                //         ['title' => 'View', 'data' => 
                                //         ['pjax' => 1]
                                //     ]);
                                // },
                                // 'delete' => function($url, $model) {
                                //     return Html::a('<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>', 
                                //         ['delete', 'id' => $model['id']], 
                                //         ['title' => 'Delete', 'class' => '', 'data' => 
                                //         ['confirm' => 'Apakah anda ingin menghapus data ?', 'method' => 'post', 'pjax' => 1],
                                //     ]);
                                // }
                                'detail' => function($url, $model) {
                                    return Html::a('<button class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>', 
                                        ['detail', 'id' => $model['id']], 
                                        ['title' => 'Detail', 'class' => 'detailsaset', 'data' => 
                                        ['method' => 'post', 'data-pjax' => '0']
                                    ]);
                                },
                            ]
                        ],
                    ];

                    echo ExportMenu::widget([
                        'filterModel' => $searchModel,
                        'columns' => $gridColumns,
                        'dataProvider' => $dataProvider,
                        'filename' => 'assets',
                        //'stream' => false,
                        //'linkPath' => false,
                        // 'batchSize' => 1024,
                    ]);
                    // echo GridView::widget([
                    //     'dataProvider' => $dataProvider,
                    //     'filterModel' => $searchModel,
                    //     'columns' => $gridColumns,
                    //     // 'tableOptions' => [
                    //     //     'class' => 'table table-striped'
                    //     // ],
                    //     // 'responsive'=>true,
                    //     'hover'=>true
                    // ]);
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
$(".detailsaset").on("click", function(e) {
    e.preventDefault();
    url = $(this).attr('href');
    $('#detailAset')
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
    'id' => 'detailAset',
    'size' => Modal::SIZE_LARGE,
    'title' => 'Detail Jumlah Barang',
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