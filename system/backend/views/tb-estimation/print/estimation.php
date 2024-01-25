<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left d-flex justify-content-center align-items-center text-center" style="padding: 5">
                        <div>
                            <img src="<?= Url::base(). '/dist/img/jackeyfix.png'; ?>" width="100px"><p>
                            <img src="<?= Url::base(). '/dist/img/jackeytext.png'; ?>" width="150px" style="padding-top: 2px;">
                            </p>
                            <p style="font-weight: bold; font-size:14px; line-height: 5px; padding-top: 0rem;"><b>Jl. Raya Jombang No.21, Sektor 9, Bintaro, Tangerang Selatan</b></p>
                            <p style="font-weight: bold; font-size:14px; line-height: 10px;"><b>Phone: (021) 7486 3338 - 7045 0606</b></p>
                        </div>
                    </div>
                    <div class="pull-left text-left">
                        <div style="line-height: inherit;">
                            <p style="font-size:14px; line-height:10px"><b>Kepada Yth,</b></p>
                            <p style="font-weight: bold; font-size:14px; line-height: 10px;"><?= $model->customer ? $model->customer->name : null ?></p>
                            <p style="font-weight: bold; font-size:14px; line-height: 10px;"><?= $model->customer ? $model->customer->address : null ?></p>
                            <p style="font-weight: bold; font-size:14px; line-height: 10px;"><?= $model->customer ? $model->customer->phone : null ?></p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table1">
                            <tr>
                                <th>Estimation ID : <?= $model->no_estimation ?></br></th>
                                <th>Date In: <?= $model->datein ?></th>                         
                                <th>Model: <?= $model->customer? $model->customer->model : null ?></th>
                                <th class="text-center"><h3><strong>ESTIMASI</strong></h3></th>
                            </tr>
                            <tr>
                                <th>Car ID: <?= $model->customer? $model->customer->plate : null ?></th>
                                <th>Date Out: <?= $model->dateout ?></th>
                                <th>Chasis: <?= $model->customer ? $model->customer->chasis : null ?></th>
                                <th>KM:<?= $model->customer ? $model->customer->km : null ?></th>
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
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table1">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Service And Supplies</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            $isSparePart = false;
                            $isLabourCharge = false;
                            foreach ($allServices as $serviced) {
                                if (empty($serviced['qty'])) {
                                    // Cek jika ini adalah Labour Charge
                                    if ($isSparePart == true) {
                                        // Tambahkan baris "Labour Charge" jika sebelumnya ada SparePart
                                        echo '
                                            <tr>
                                                <td colspan="5" class="text-left"><b>Labour Charge</b></td>
                                            </tr>
                                        ';
                                        $isLabourCharge = true;
                                        $isSparePart = false;
                                    }
                                } else {
                                    // Ini adalah SparePart
                                    if ($isSparePart == false) {
                                        // Tambahkan baris "SparePart" pertama
                                        echo '
                                            <tr>
                                                <td colspan="5" class="text-left"><b>SparePart</b></td>
                                            </tr>
                                        ';
                                        $isSparePart = true;
                                        $isLabourCharge = false;
                                    }
                                }
                                // Tampilkan data service
                                echo '
                                    <tr>
                                        <td class="text-center"><b>' . $no++ . '</b></td>
                                        <td class="text-left"><b>' . nl2br($serviced['name']) . '</b></td>
                                        <td class="text-center"><b>' . ($serviced->qty ? $serviced->qty : 0)  . '</b></td>
                                        <td class="text-center"><b>' . number_format($serviced['price'], 0) . '</b></td>
                                        <td class="text-center"><b>Rp ' . number_format($serviced['amount'], 2) . '</b></td>
                                    </tr>
                                ';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-10 text-right" style="clear: both">
                        <h4><b>Total : Rp. <?= number_format($sum, 2)?></b></h4>
                    </div>
                </div>
                <!-- SIGNATURE -->
                <div>
                    <table style ="align:center; width:100%; padding-top:10px;">
                    <tr>
                        <td style="text-align: left; font-size: 14px; border: none; line-height:15px;">
                            <b>PEMBAYARAN DAPAT DITRANSFER <br style="line-height:10px;">REKENING KAMI <br><br>
                                <p style="font-style: italic;">BCA ACC No : 2181004233 a/n SUJOKO</p></br><br>
                                <p style="font-style: italic;">BNI ACC No : 0164100746 a/n SUJOKO </p></br>
                            </b>
                        </td>
                        <td style="text-align: left; font-size: 14px; border: none; line-height:15px;">
                            This order is Subject <br> 
                            To the terms of business
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; border: none;"></td>
                        <td style="text-align: left; border: none; font-size: 16px;">Signature and Company Stamp</td>
                    </tr>
                    </table>
                </div>
                <!-- SIGNATURE -->
            </div>
        </div>
    </div>
</div>