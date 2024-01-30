<?php

use backend\models\TbCustomer;
use backend\models\TbMechanic;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TbWorkOrderSearch */
/* @var $form yii\widgets\ActiveForm */
$customer = ArrayHelper::map(TbCustomer::find()->joinWith('workOrder')->all(), 'id', function($model) {
    return $model->name . ' - ' . $model->plate;
});
?>

<div class="tb-work-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'id_customer')->widget(Select2::classname(),[
                    'data' => $customer,
                    'options' => [
                        'placeholder' => 'Cari Berdasarkan No Plat',
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_mechanic')->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(TbMechanic::find()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Cari Berdasarkan Mekanik',
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'no_work_order')->textInput(['placeholder' => 'Cari Berdasarkan No Working Order']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
