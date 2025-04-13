<?php

use backend\models\TbCustomer;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TbInvoiceSearch */
/* @var $form yii\widgets\ActiveForm */

$data = ArrayHelper::map(TbCustomer::find()
    ->leftJoin('tb_invoice', 'tb_customer.id = tb_invoice.id_customer')
    // ->where(['tb_invoice.id_customer' => null])
    ->all(), 'id', function($model) {
        return $model->name . ' - ' . $model->plate;
});
?>

<div class="tb-invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'id_customer')->widget(Select2::classname(),[
                    'data' => $data,
                    'options' => [
                        'placeholder' => 'Cari Berdasarkan No Plat',
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'no_invoice')->textInput(['placeholder' => 'Cari Berdasarkan No Order Invoice']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
