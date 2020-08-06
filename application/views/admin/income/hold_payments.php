<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$this->db->where('status', 'Hold');
$data = $this->db->get('withdraw_request')->result();
?>
<hr/>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>S.N.</td>
            <td>User ID</td>
            <td>Amount</td>
            <td>Date</td>
            <td>Account Detail</td>
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
                <td><?php echo $e->userid ?></td>
                <td><?php echo config_item('currency') . $e->amount ?></td>
                <td><?php echo $e->date ?></td>
                <td><a data-toggle="modal" data-target="#myModal"
                       onclick="document.getElementById('payid').value='<?php echo $e->id ?>'"
                       class="btn btn-primary btn-xs">Pay</a>
                    <a href="<?php echo site_url('income/unhold/' . $e->id) ?>"
                       class="btn btn-success btn-xs">Un-Hold</a>
                    <a href="<?php echo site_url('income/remove/' . $e->id) ?>" class="btn btn-danger btn-xs"
                       onclick="return confirm('Are you sure want to delete this payout ?')">Delete</a></td>
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
                <h4 class="modal-title">Payout Detail</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('income/pay') ?>
                <label>Enter Transaction Detail</label>
                <input type="hidden" name="payid" value="" id="payid">
                <textarea class="form-control" name="tdetail"></textarea>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success">Pay Now</button>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
