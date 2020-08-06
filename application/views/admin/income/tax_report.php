<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$top_id = $this->uri->segment('3') ? $this->uri->segment('3') : config_item('top_id');
$sdate  = $this->uri->segment('5') ? $this->uri->segment('5') : '';
$edate  = $this->uri->segment('6') ? $this->uri->segment('6') : '';
$this->db->where('userid', htmlentities($top_id));
if ($sdate !== "") {
    $this->db->where('date >=', $sdate);
}
if ($edate !== "") {
    $this->db->where('date <=', $edate);
}
$this->db->limit(100);
$data = $this->db->get('tax_report')->result();
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
            <label>Start Date</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" readonly class="form-control datepicker" name="sdate">
            </div>
            
        </div>
        <div class="col-sm-6">
            <label>End Date</label>
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
            <td>Payout Amount</td>
            <td>Tax</td>
            <td>Net Paid</td>
            <td>Tax (%)</td>
            <td>Date</td>
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
                <td><?php echo config_item('currency') . $e->tax_amount ?></td>
                <td><?php echo config_item('currency') . ($e->amount - $e->tax_amount) ?></td>
                <td><?php echo $e->tax_percnt ?></td>
                <td><?php echo $e->date ?></td>
                <td>

                    <a href="<?php echo site_url('income/tax-remove/' . $e->id) ?>" class="btn btn-danger btn-xs"
                       onclick="return confirm('Are you sure want to delete this record ?')">Delete</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>