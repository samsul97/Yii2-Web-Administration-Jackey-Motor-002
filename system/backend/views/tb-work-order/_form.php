<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kidzen\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model backend\models\TbWorkOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-work-order-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="col-lg-12">
        <?= Select2::widget([
            'id' => 'customer',
            'name' => 'customer',
            'data' => $model->customerName() ?: [],
            'value' => $model->id_customer ? $model->id_customer : null,
            'options' => [
                'placeholder' => 'Pilih Pelanggan',
                'onChange' => '$.post("'.Url::base().'/tb-estimation/customer-data?id='.'" + $(this).val(), function(data) {
                    if (data) {
                        item = JSON.parse(data);
                        console.log(item);
                        $("#plate").val(item.plate);
                        $("#model").val(item.model);
                        $("#merk").val(item.merk);
                        $("#chasis").val(item.chasis);
                        $("#engine").val(item.engine);
                        $("#km").val(item.km);
                        $("#regdate").val(item.regdate);
                    } else {
                        // Handle error or set default values
                        $("#plate").val("");
                        $("#model").val("");
                        $("#merk").val("");
                        $("#chasis").val("");
                        $("#engine").val("");
                        $("#km").val("");
                        $("#regdate").val("");
                    }
                    }
                );',
            ],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ]) ?>
    </div>

    <hr style="border-top: 2px double #337ab7">

    <div class="row">

        <div class="col-lg-4">

            <?= Html::label('Plat Nomor', 'plate', ['class' => 'control-label']) ?>
            <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['plate'] : null ?>" name="plate" id="plate" readonly="true">

            <?= Html::label('Model', 'model', ['class' => 'control-label']) ?>
            <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['model'] : null ?>" name="model" id="model" readonly="true">
        
        </div>

        <div class="col-lg-4">
            <?= Html::label('Chasis', 'chasis', ['class' => 'control-label']) ?>
            <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['chasis'] : null ?>" name="chasis" id="chasis" readonly="true">

            <div class="row">
                <div class="col-md-6">
                    <?= Html::label('Engine', 'engine', ['class' => 'control-label']) ?>
                    <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['engine'] : null ?>" name="engine" id="engine" readonly="true">
                </div>
                <div class="col-md-6">
                    <?= Html::label('KM', 'km', ['class' => 'control-label']) ?>
                    <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['km'] : null ?>" name="km" id="km" readonly="true">
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <?= Html::label('Merk', 'merk', ['class' => 'control-label']) ?>
            <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['merk'] : null ?>" name="merk" id="merk" readonly="true">
            
            <?= Html::label('Regdate', 'regdate', ['class' => 'control-label']) ?>
            <input type="text" class="form-control" value="<?= $model->customer ? $model->customer['regdate'] : null ?>" name="regdate" id="regdate" readonly="true">
        </div>

    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'datein')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder'  => 'Tanggal Masuk',
                    'autocomplete' => 'off',
                    'value' => $model->datein ? $model->datein : NULL,
                ],
                'pluginOptions' => [
                    'autoclose'      => true,
                    'todayHighlight' => true,
                    'format'         => 'yyyy-mm-dd'
                ]
            ]) ?>

            <?= $form->field($model, 'dateout')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder'  => 'Tanggal Keluar',
                    'autocomplete' => 'off',
                    'value' => $model->dateout ? $model->dateout : NULL,
                ],
                'pluginOptions' => [
                    'autoclose'      => true,
                    'todayHighlight' => true,
                    'format'         => 'yyyy-mm-dd'
                ]
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'received')->textInput(['maxlength' => true, 'placeholder' => 'Received']) ?>
            
            <?= $form->field($model, 'broughtin')->textInput(['maxlength' => true, 'placeholder' => 'Broughtin']) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'id_mechanic')->widget(Select2::classname(),[
                    'data' => $model->getMechanicName(),
                    'options' => [
                        'placeholder' => 'Pilih Mekanik',
                        'value' => $model->isNewRecord ? $model->id_mechanic : $model->id_mechanic,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]);
            ?>
        </div>
    </div>

    <hr style="border-top: 2px double #e67e22">

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 100, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $serviceModel[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'name',
            'qty',
            'price',
        ],
    ]);
    
    ?>
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Service
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Service</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
        <?php // var_dump($serviceModel); die; ?>
            <?php foreach ($serviceModel as $index => $item): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address"></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (!$item->isNewRecord) {
                                echo Html::activeHiddenInput($item, "[{$index}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-lg-4">
                                <?= $form->field($item, "[{$index}]name")->textArea(['maxlength' => true, 'rows' => 6]) ?>
                            </div>
                            <div class="col-lg-4">
                                <?= $form->field($item, "[{$index}]qty")->textInput(['maxlength' => true, 'type' => 'number', 'min' => 0, 'value' => $item->isNewRecord ? 0 : null]) ?>
                            </div>
                            <div class="col-lg-4">
                                <?= $form->field($item, "[{$index}]price")->widget(MaskMoney::classname(), [
                                    'pluginOptions' => [
                                        'prefix' => 'RP ',
                                        'allowNegative' => false
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<?php
$js = '
$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
';

$this->registerJs($js);