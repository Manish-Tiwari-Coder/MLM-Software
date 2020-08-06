<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<link rel="stylesheet" type="text/css"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<h2 align="center">Receipt</h2>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8 table-responsive" style="background-color: #fff; padding: 10px">
        <h3>ID # <?php echo $result->id ?></h3>
        <p>&nbsp;</p>
        <table class="table table-striped">
            <tr>
                <td>Invested Package:</td>
                <td><?php $data = $this->db_model->select_multi('pack_name,roi,roi_frequency', 'investment_pack', array('id' => $result->pack_id));
                    echo $data->pack_name ?></td>
            </tr>
            <tr>
                <td>User Id:</td>
                <td><?php echo config_item('ID_EXT') . $result->userid ?></td>
            </tr>
            <tr>
                <td>Invested Amount:</td>
                <td><?php echo config_item('currency') . $result->amount ?></td>
            </tr>
            <tr>
                <td>Investment Date:</td>
                <td><?php echo $result->date ?></td>
            </tr>
            <tr>
                <td>Investment Status:</td>
                <td><?php echo $result->status ?></td>
            </tr>
            <tr>
                <td>ROI:</td>
                <td><?php echo $data->roi ?></td>
            </tr>
            <tr>
                <td>ROI Payout:</td>
                <td>Every <?php echo $data->roi_frequency ?> days</td>
            </tr>
        </table>
    </div>
    <div class="col-sm-2"></div>
</div>
<div align="center" style="font-size: 11px">Note: This is an electronically generated receipt. No need of signature.
</div>
<div align="center" style="font-size: 11px">www.<?php echo $_SERVER['HTTP_HOST'] ?></div>