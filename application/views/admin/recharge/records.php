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
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>User ID</label>
        <input class="form-control" name="userid" type="text">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">
    </div>
    <?php echo form_close() ?>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>User Id</th>
            <th>Service Type</th>
            <th>Recharge No</th>
            <th>Amount</th>
            <th>Area / Operator</th>
            <th>Date</th>
            <th>#</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($rcg as $e) {
            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo config_item('ID_EXT') . $e->userid; ?></td>
                <td><?php echo $e->service_type; ?></td>
                <td><?php echo $e->recharge_no; ?></td>
                <td><?php echo $e->amount; ?></td>
                <td><?php echo $e->area; ?><br/>(<?php echo $e->operator; ?>)</td>
                <td><?php echo date('d/m/Y', $e->time); ?></td>
                <td>
                    <a class="btn btn-xs btn-danger" href="<?php echo site_url('recharge/remove-record/' . $e->id) ?>">Remove</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>