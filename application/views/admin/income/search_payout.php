<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$top_id = $this->uri->segment('3') ? $this->uri->segment('3') : config_item('top_id');
$status = $this->uri->segment('4') ? $this->uri->segment('4') : '';
$sdate  = $this->uri->segment('5') ? $this->uri->segment('5') : '';
$edate  = $this->uri->segment('6') ? $this->uri->segment('6') : '';
$this->db->where('userid', htmlentities($top_id));
if ($status !== "") {
    $this->db->where('status', $status);
}
if ($sdate !== "") {
    $this->db->where('paid_date >=', $sdate);
}
if ($edate !== "") {
    $this->db->where('paid_date <=', $edate);
}
$this->db->limit(100);
$data = $this->db->get('withdraw_request')->result();
?>
<div class="row">
    <form method="post" action="">
        <div class="col-sm-6">
            <label>Enter User Id</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input type="text" required name="top_id" class="form-control">
            </div>
        </div>
        <div class="col-sm-6">
            <label>Status</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                <select name="status" class="form-control">
                    <option selected>Paid</option>
                    <option>Un-Paid</option>
                    <option>Hole</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <label>Start Payout Date</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" readonly class="form-control datepicker" name="sdate">
            </div>
        </div>
        <div class="col-sm-6">
            <label>End Payout Date</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" readonly class="form-control datepicker" name="edate">
            </div>
            <br/>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
<hr/>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>S.N.</td>
            <td>User ID</td>
            <td>Amount</td>
            <td>Tax Deducted</td>
            <td>Date</td>
            <td>Status</td>
            <td>Transaction Detail</td>
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
                <td><?php echo config_item('currency') . $e->amount ?></td>
                <td><?php echo config_item('currency') . $e->tax ?></td>
                <td><?php echo $e->date ?></td>
                <td><?php echo $e->status ?></td>
                <td><?php echo $e->tid ?></td>
                <td>
                    <?php if ($e->status == "Un-Paid") { ?>
                        <a data-toggle="modal" data-target="#myModal"
                           onclick="document.getElementById('payid').value='<?php echo $e->id ?>'"
                           class="btn btn-primary btn-xs">Pay</a>
                    <?php } ?>
                    <?php if ($e->status == "Hold") { ?>
                        <a href="<?php echo site_url('income/unhold/' . $e->id) ?>" class="btn btn-success btn-xs">Un-Hold</a>
                    <?php } else { ?>
                        <a href="<?php echo site_url('income/hold/' . $e->id) ?>"
                           class="btn btn-success btn-xs">Hold</a>

                    <?php } ?>
                    <?php if ($e->status == "Paid") { ?>
                        <a href="<?php echo site_url('income/unpay/' . $e->id) ?>"
                           class="btn btn-success btn-xs">Un-Pay</a>
                    <?php } ?>

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