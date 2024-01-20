<?php

use backend\models\MrCompany;
use backend\models\MrInCategory;
use backend\models\MrInType;
use backend\models\MrTkp;
use backend\models\TbAssets;
use backend\models\TbAssetsBroken;
use backend\models\TbCustomer;
use backend\models\TbEmpAdministration;
use backend\models\TbEmpAttendance;
use backend\models\TbEmpLeave;
use backend\models\TbEmpLoan;
use backend\models\TbEmployee;
use backend\models\TbInventory;
use backend\models\TbInvoice;
use backend\models\TbMechanic;
use backend\models\TbService;
use backend\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use barcode\barcode\BarcodeGenerator;
use yii\bootstrap4\LinkPager as Bootstrap4LinkPager;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */

$this->title = 'Jackey Motor Application';
$this->params['page_title'] = 'Dashboard';
$this->params['page_desc'] = $this->title;
$this->params['title_card'] = 'Information';

// $select_level = ArrayHelper::map(UserLevel::find()->asArray()->all(), function($model, $defaultValue) {

//     return sprintf('%s', $model['code']);

// }, function($model, $defaultValue) {

//         return sprintf('%s', $model['name']);
//     }
// );
$level = Yii::$app->user->identity->level;
// var_dump($select_level == $level);
// die;

?>
<!-- USER ADMIN -->
<?php if($level == '6fb4f22992a0d164b77267fde5477248') : ?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button> -->
        </div>
    </div>
    <div class="card-body">
        <div class="site-index">
            <div class="row" style="margin: 3px;">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <p>Data User</p>
                        <h3><?=Yii::$app->formatter->asInteger(User::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?=Url::to(['user/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <p>Data Absensi</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbEmpAttendance::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-hourglass"></i>
                    </div>
                    <a href="<?=Url::to(['tb-emp-attendance/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-gradient-gray">
                    <div class="inner">
                        <p>Data Cuti</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbEmpLeave::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cut"></i>
                    </div>
                    <a href="<?=Url::to(['tb-emp-leave/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <p>Data Kerusakan Barang</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbAssetsBroken::getCountBroken()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-trash"></i>
                    </div>
                    <a href="<?=Url::to(['tb-assets/broken']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
        </div>
        <div class="site-index">
            <div class="row" style="margin: 3px;">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>Data Inventori Kantor</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbAssets::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-square"></i>
                    </div>
                    <a href="<?=Url::to(['tb-assets/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-olive">
                    <div class="inner">
                        <p>Data Inventori Bahan Baku</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbInventory::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="<?=Url::to(['tb-inventory/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <p>Data TKP</p>
                        <h3><?=Yii::$app->formatter->asInteger(MrTkp::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <a href="<?=Url::to(['mr-tkp/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <p>Data Karyawan</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbEmployee::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <a href="<?=Url::to(['tb-employee/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="box-header with-border">
          <!-- <center><h4 class="box-title">Status Karyawan</h4></center> -->
        </div>
        <div class="box-body">
          <?=Highcharts::widget([
            'options' => [
              'credits' => false,
              'title' => ['text' => 'Karyawan Berdasarkan TKP'],
              'exporting' => ['enabled' => true],
              'plotOptions' => [
                'pie' => [
                  'cursor' => 'pointer',
                ],
              ],
              'series' => [
                [
                  'type' => 'pie',
                  'name' => 'Karyawan',
                  'data' => MrTkp::getGrafikTkpEmployee(),
                ],
              ],
            ],
          ]);?>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="box-header with-border">
          <!-- <center><h4 class="box-title">Pendidikan Karyawan</h4></center> -->
        </div>
        <div class="box-body">
          <?=Highcharts::widget([
            'options' => [
              'credits' => false,
              'title' => ['text' => 'Assets Berdasarkan TKP'],
              'exporting' => ['enabled' => true],
              'plotOptions' => [
                'pie' => [
                  'cursor' => 'pointer',
                ],
              ],
              'series' => [
                [
                  'type' => 'pie',
                  'name' => 'Assets',
                  'data' => MrTkp::getGrafikTkpAssets(),
                ],
              ],
            ],
          ]);?>
        </div>
      </div>
    </div>
    <div>&nbsp;</div>
    <div class="row">
      <div class="col-sm-6">
        <div class="box-header with-border">
          <!-- <center><h4 class="box-title">Status Karyawan</h4></center> -->
        </div>
        <div class="box-body">
          <?=Highcharts::widget([
            'options' => [
              'credits' => false,
              'title' => ['text' => 'Assets Berdasarkan Kategori'],
              'exporting' => ['enabled' => true],
              'plotOptions' => [
                'pie' => [
                  'cursor' => 'pointer',
                ],
              ],
              'series' => [
                [
                  'type' => 'pie',
                  'name' => 'Assets',
                  'data' => MrInCategory::getGrafikCategoryAssets(),
                ],
              ],
            ],
          ]);?>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="box-header with-border">
          <!-- <center><h4 class="box-title">Pendidikan Karyawan</h4></center> -->
        </div>
        <div class="box-body">
          <?=Highcharts::widget([
            'options' => [
              'credits' => false,
              'title' => ['text' => 'Inventory Berdasarkan Jenis'],
              'exporting' => ['enabled' => true],
              'plotOptions' => [
                'pie' => [
                  'cursor' => 'pointer',
                ],
              ],
              'series' => [
                [
                  'type' => 'pie',
                  'name' => 'Inventory',
                  'data' => MrInType::getGrafikTypeInventory(),
                ],
              ],
            ],
          ]);?>
        </div>
      </div>
    </div>
    <!-- <div class="card-body">

        <div class="jumbotron">

            <h1>Congratulations!</h1>

            <p class="lead">You have successfully created your Yii-powered application.</p>

            <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
        
        </div>

        <div class="body-content">

            <div class="row">

                <div class="col-lg-4">

                    <h2>Heading</h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
                </div>

                <div class="col-lg-4">

                    <h2>Heading</h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
                </div>

                <div class="col-lg-4">

                    <h2>Heading</h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                        ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur.</p>

                    <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
                
                </div>
            
            </div>

        </div>

    </div> -->
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
<?php endif ?>


<!-- USER HRD -->
<?php if($level == '2b6cc9c30eaad9c109091ea928529cbd') : ?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Maximize">
            <i class="fas fa-expand"></i></button>
            <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button> -->
        </div>
    </div>
    <div class="card-body">
      SELAMAT DATANG JACKEY MOTOR!
        <!-- <div class="site-index">
            <div class="row" style="margin: 3px;">
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>Total Orderan</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbInvoice::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <a href="<?=Url::to(['tb-invoice/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <p>Total Customer</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbCustomer::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <a href="<?=Url::to(['tb-customer/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-olive">
                    <div class="inner">
                        <p>Total Karyawan/Mechanic</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbMechanic::getCount()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-circle"></i>
                    </div>
                    <a href="<?=Url::to(['tb-mechanic/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <p>Total Omset Keseluruhan</p>
                        <h3><?=Yii::$app->formatter->asInteger(TbService::getCountOmset()); ?></h3>
                    </div>
                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <a href="<?=Url::to(['site/index']); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div class="text-center"><i><?= Html::encode($this->title) ?></i></div>
    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
<?php endif ?>

