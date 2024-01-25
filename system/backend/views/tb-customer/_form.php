<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\TbCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
            
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'regdate')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder'  => 'Tanggal Pembuatan Mobil',
                    'autocomplete' => 'off',
                    'value' => $model->isNewRecord ? NULL : $model->regdate,
                ],
                'pluginOptions' => [
                    'autoclose'      => true,
                    'todayHighlight' => true,
                    'format'         => 'yyyy-mm-dd'
                ]
            ]) ?>
            <?= $form->field($model, 'plate')->textInput(['maxlength' => true, 'placeholder' => 'Nomor Plat']) ?>
        
            <?= $form->field($model, 'model')->textInput(['maxlength' => true, 'placeholder' => 'Model']) ?>
        
            <?= $form->field($model, 'merk')->textInput(['maxlength' => true, 'placeholder' => 'Merk']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'chasis')->textInput(['maxlength' => true, 'placeholder' => 'Chasis']) ?>
            
            <?= $form->field($model, 'engine')->textInput(['maxlength' => true, 'placeholder' => 'Engine']) ?>
            
            <?= $form->field($model, 'km')->textInput(['maxlength' => true, 'placeholder' => 'Km']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
