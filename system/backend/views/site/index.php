<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Jackey Motor Application';
$this->params['page_title'] = 'Dashboard';
$this->params['page_desc'] = $this->title;
$this->params['title_card'] = 'Information';

$level = Yii::$app->user->identity->level;

?>
<!-- Default box -->
<div class="card">
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
      SELAMAT DATANG JACKEY MOTOR!
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

