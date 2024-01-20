<div class="table-responsive table-nowrap">
    <h2>Data Customer</h2>
    <p>Nama     : <?= $customer->name ?></p>
    <p>Telp     : <?= $customer->phone ?></p>
    <p>Alamat   : <?= $customer->address ?></p>
    <p>Chasis   : <?= $customer->chasis ?></p>
    <p>Plat     : <?= $customer->plate ?></p>
    <p>Engine   : <?= $customer->engine ?></p>
    <p>model    : <?= $customer->model ?></p>
    <p>Merk     : <?= $customer->merk ?></p>
    
    <h2>Data Invoice</h2>
    <p>Kode     : <?= $model->no_invoice ?></p>
    <p>broughtin: <?= $model->broughtin ?></p>
    <p>received : <?= $model->received ?></p>
    <p>regdate  : <?= $model->regdate ?></p>
    <p>datein   : <?= $model->datein ?></p>
    <p>dateout   : <?= $model->dateout ?></p>
    <p>KM   : <?= $model->km ?></p>

    <?php if (!empty($serviceFromEstimation)) : ?>

        <h2>Data Service Dari Estimasi Sebelumnya</h2>
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
            foreach ($serviceFromEstimation as $serviced) {
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
            // Tambahkan baris "Labour Charge" terakhir jika tidak ada SparePart di akhir
            if ($isSparePart == true) {
                echo '
                    <tr>
                        <td colspan="5" class="text-left"><b>Labour Charge</b></td>
                    </tr>
                ';
            }
            ?>
            </tbody>
        </table>
        <div class="pull-right m-t-10 text-right">
            <h5><b>Total : Rp. <?= number_format($sumFromEstimation, 2)?></b></h5>
        </div>
        
    <?php endif ?>

    <h2>Data Service Invoice</h2>
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
        // Tambahkan baris "Labour Charge" terakhir jika tidak ada SparePart di akhir
        if ($isSparePart == true) {
            echo '
                <tr>
                    <td colspan="5" class="text-left"><b>Labour Charge</b></td>
                </tr>
            ';
        }
        ?>
        </tbody>
    </table>
    <div class="pull-right m-t-10 text-right">
        <h5><b>Total : Rp. <?= number_format($sum, 2)?></b></h5>
    </div>
</div>


<?php 
$cssInline = <<< CSS
.table1 {
    font-family: sans-serif;
    color: #232323;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #000000;
}
.table1, th, td {
    border: 1px solid #000000;
    padding: 3px 2px;
}
.table1 tr:hover {
    background-color: #f5f5f5;
}
CSS;

$this->registerCss($cssInline);

?>