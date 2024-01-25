<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left d-flex justify-content-center align-items-center text-center">
                        <div>
                            <img src="<?= Url::base(). '/dist/img/jackeyfix.png'; ?>" width="100px"><p>
                            <img src="<?= Url::base(). '/dist/img/jackeytext.png'; ?>" width="150px" style="padding-top: 2px;">
                            </p>
                            <p style="font-weight: bold; font-size:14px; line-height: 5px; padding-top: 0rem;"><b>Jl. Raya Jombang No.21, Sektor 9, Bintaro, Tangerang Selatan</b></p>
                            <p><b>Phone: (021) 7486 3338 - 7045 0606</b></p>
                        </div>
                    </div>
                    <div class="pull-left text-left">
                        <div style="line-height: inherit;">
                            <h5><b>Kepada Yth,</b></h5>
                            <h4 style="font-weight: bold"><?= $model->customer ? $model->customer->name : null ?></h4>
                            <p style="font-weight: bold"><?= $model->customer ? $model->customer->address : null ?></p>
                            <p style="font-weight: bold"><?= $model->customer ? $model->customer->phone : null ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-left d-flex justify-content-center align-items-center text-center">
                        <h3 style="font-weight: bold;">Working Order</h3>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40">
                        <table class="table1">
                            <tr>
                                <th>WO ID : <?=$model->no_work_order?></th>
                                <th>Date In: <?= $model->datein ?></th>
                                <th>Model: <?=$model->customer ? $model->customer->model : null ?></th>
                                <th><h5><strong>Mechanic: <?= $model->mechanic ? $model->mechanic->name : null  ?></strong></h5></th>
                            </tr>
                            <tr>
                                <th>Plat: <?= $model->customer ? $model->customer->plate : null ?></th>
                                <th>Date Out: <?= $model->dateout ?></th>
                                <th>Chasis: <?= $model->customer ? $model->customer->chasis : null?></th>
                                <th>KM: <?= $model->customer ? $model->customer->km : null ?></th>
                            </tr>
                            <tr>
                                <th>Brought in: <?= $model->broughtin ?></th>
                                <th>Received: <?= $model->received ?></th>
                                <th>Engine: <?= $model->customer ? $model->customer->engine : null ?></th>
                                <th>Reg Date: <?= $model->customer ? $model->customer->regdate : null ?></th>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach($allServices as $serviced) { ?>
                                    <tr>
                                        <td class="text-center"><b><?= $no++ ?></b></td>
                                        <td class="text-left"><b><?= nl2br($serviced['name']) ?></b></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>