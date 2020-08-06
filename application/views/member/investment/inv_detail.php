<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>

<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8 table-responsive" style="background-color: #fff; padding: 10px">
        Dear <?php echo $this->session->name ?>,<br/>
        We have accepted your investment and your investment status is :
        <span style="padding: 5px; background-color: #0d638f; color: #fff"><?php echo $result->status ?></span>
        <a target="_blank" href="<?php echo site_url('investments/pdf_invoice/' . $result->id) ?>" class="fa fa-file-pdf-o pull-right" style="color: red; text-decoration: underline">
            Receipt</a>
        <p>&nbsp;</p>
        <table class="table table-striped">
            <tr>
                <td>Invested Package:</td>
                <td><?php echo $this->db_model->select('pack_name', 'investment_pack', array('id' => $result->pack_id)) ?></td>
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
        </table>
    </div>
    <div class="col-sm-2"></div>
</div>