<?php

use backend\models\TbMechanic;
use backend\models\TbService;
use yii\helpers\Url;


$sum = TbService::find()->andWhere(['id_tb_invoice' => $model->id])->sum('amount');

?>
<div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left d-flex justify-content-center align-items-center text-center">
                            <div>
                            <img src="C://xampp/htdocs/JackeyMotor/backend/dist/img/jackeyfix.png" width="100px"><p><!-- <br> -->
                                <img src="C://xampp/htdocs/JackeyMotor/backend/dist/img/jackeytext.png" width="150px" style="padding-top: 2px;">
                                </p>
                                <p style="font-weight: bold; font-size:14px; line-height: 5px; padding-top: 0rem;"><b>Jl. Raya Jombang No.21, Sektor 9, Bintaro, Tangerang Selatan</b></p>
                                <p><b>Phone: (021) 7486 3338 - 7045 0606</b></p>
                            </div>
                        </div>
                        <div class="pull-left text-left">
                            <div style="line-height: inherit;">
                                <h5><b>Kepada Yth,</b></h5>
                                <h4 style="font-weight: bold"><?= $model->customer['name']?></h4>
                                <p style="font-weight: bold"><?= $model->customer['address']?></p>
                                <p style="font-weight: bold"><?= $model->customer['phone']?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-left d-flex justify-content-center align-items-center text-center">
                            <!-- <address> -->
                                <h3 style="font-weight: bold;">Work Order</h3>
                            <!-- </address> -->
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40">
                            <table class="table1">
                                <tr>
                                    <th><?=$model['no_invoice']?></th>
                                    <th>Date In: <?=$model['datein']?></th>                           
                                    <th>Model: <?=$model->customer['model']?></th>
                                    <th><h5><strong>Mechanic: <?= $mechanic['name'] ?></strong></h5></th>
                                </tr>
                                <tr>
                                    <th>Plat: <?=$model->customer['plate']?></th>
                                    <th>Date Out: <?=$model['dateout']?></th>
                                    <th>Chasis: <?=$model->customer['chasis']?></th>
                                    <th>KM:<?=$model['km']?></th>
                                </tr>
                                <tr>
                                    <th>Brought in: <?=$model->customer['name']?></th>
                                    <th>Received: <?=$model['received']?></th>
                                    <th>Engine: <?=$model->customer['engine']?></th>
                                    <th>Reg Date: <?=$model['regdate']?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br>

                    <div class="col-md-12">
                        <div class="table-responsive m-t-40">
                            <table class="table1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Service And Supplies</th>
                                        <!-- <th class="text-right">Qty</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Amount</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach($allServices as $serviced) { ?>
                                        <tr>
                                            <td class="text-center"><b><?= $no++?></b></td>
                                            <td class="text-left"><b><?=nl2br($serviced['name'])?></b></td>
                                            <!-- <td class="text-right"><?= $serviced['qty'] ?>  </td>
                                            <td class="text-right"><?= number_format($serviced->price, 0)?> </td>
                                            <td class="text-right"><?= 'Rp'. number_format($serviced->amount, 0) ?> </td> -->
                                        </tr>;
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- <div class="pull-right m-t-10 text-right" style="clear: both"> -->
                            <!-- <hr style="border-width: thin"> -->
                            <!-- <h4><b>Total :</b> Rp. <?= number_format($sum, 0) ?><div style="display: inline;"></div></h4> -->
                        <!-- </div> -->
                        <!-- <div class="clearfix"></div> -->
                        <!-- <hr style="border-width: thin"> -->
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>

    