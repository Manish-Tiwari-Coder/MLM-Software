<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<hr/>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr style="font-weight: bold">
            <td>S.N.</td>
            <td>User ID</td>
            <td>Reward Name</td>
            <td>Achieve Date</td>
            <td>Paid Date</td>
            <td>Delivery Detail</td>
            <td>#</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $sn = 1;
        foreach ($data as $e) {

            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo config_item('ID_EXT') . $e->userid ?></td>
                <td><?php echo $this->db_model->select('reward_name', 'reward_setting', array('id' => $e->reward_id)) ?></td>
                <td><?php echo $e->date ?></td>
                <td><?php echo $e->paid_date ?></td>
                <td><?php echo $e->tid ?></td>
                <td>
                    <?php if ($e->status == "Pending") { ?>
                        <a data-toggle="modal" data-target="#myModal"
                           onclick="document.getElementById('payid').value='<?php echo $e->id ?>'"
                           class="btn btn-primary btn-xs">Pay</a>
                    <?php } ?>
                    <a href="<?php echo site_url('income/reward_remove/' . $e->id) ?>" class="btn btn-danger btn-xs"
                       onclick="return confirm('Are you sure want to delete this reward ?')">Delete</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delivery Detail</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('income/reward_pay') ?>
                <label>Enter Delivery/Courier Detail</label>
                <input type="hidden" name="payid" value="" id="payid">
                <textarea class="form-control" name="tdetail"></textarea>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success">Pay Reward Now</button>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
