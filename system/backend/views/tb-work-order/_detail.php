<div class="table-responsive table-nowrap">
    <h2>Data Pelanggan </h2>
    <p>Nama     : <?= $customer->name ?></p>
    <p>Telp     : <?= $customer->phone ?></p>
    <p>Alamat   : <?= $customer->address ?></p>
    <p>Chasis   : <?= $customer->chasis ?></p>
    <p>Plat     : <?= $customer->plate ?></p>
    <p>Engine   : <?= $customer->engine ?></p>
    <p>model    : <?= $customer->model ?></p>
    <p>Merk     : <?= $customer->merk ?></p>
    <p>KM     : <?= $customer->km ?></p>
    <p>Regdate     : <?= $customer->regdate ?></p>
    
    <h2>Data Work Order</h2>
    <p>Mekanik : <?= $model->mechanic ? $model->mechanic->name : null  ?></p>
    <p>Broughtin : <?= $model->broughtin ?></p>
    <p>Received : <?= $model->received ?></p>
    <p>Datein : <?= $model->datein ?></p>
    <p>Dateout : <?= $model->dateout ?></p>

    <h2>Data Service </h2>
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