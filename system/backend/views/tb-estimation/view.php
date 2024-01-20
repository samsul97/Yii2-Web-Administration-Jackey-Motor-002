<?php

use backend\models\TbService;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

$sum = TbService::find()->andWhere(['id_tb_estimation' => $model->id])->sum('amount');

/* @var $this yii\web\View */
/* @var $model backend\models\TbInvoice */

$this->title = $model->no_invoice;
$this->params['breadcrumbs'][] = ['label' => 'Invoice', 'url' => ['index']];
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
            <div class="tb-estimation-view">
                <p>
                    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-print"></i> Cetak Estimasi', ['print-estimation', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<tr><th width="180px" style="text-align:right">{label}</th><td>{value}</td></tr>',
                    'attributes' => [
                        // 'id',
                        'name_cust',
                        'address_cust',
                        'phone_cust',
                        'number_plate',
                        'model',
                        // 'variant',
                        // 'prod_year',
                        'merk',
                        'chasis',
                        'received',
                        'regdate',
                        'datein',
                        'dateout',
                        'engine',
                        'km',
                        'timestamp',
                    ],
                ]) ?>

                <?= GridView::widget([
                    'dataProvider'=>new yii\data\ActiveDataProvider([
                        'query'=>$model->getOrderItems(),
                        'pagination'=>false,
                    ]),
                    'showFooter' => true,
                    'columns'=>[
                        // 'id',
                        'name',
                        'qty',
                        // 'price',
                        // 'amount',
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
                            'footer' => '<b> Rp.' . number_format($sum, 2) . '</b>',       
                          ],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>
