<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$top_id = $this->uri->segment('3') ? $this->uri->segment('3') : config_item('top_id');
$this->db->select('id, transfer_from, transfer_to, amount, time')->from('transfer_balance_records')
         ->where('transfer_to', htmlentities($top_id))->or_where('transfer_from', htmlentities($top_id));
$this->db->limit(100);
$data = $this->db->get()->result();
?>
<div class="row col-md-offset-2">
    <div class="col-sm-5">
        <form method="post" action="<?php echo site_url('wallet/wallet_transactions') ?>">
            <label>Enter User Id</label>
            <input type="text" name="top_id" class="form-control">
            <button class="btn btn-xs btn-danger" type="submit">Search</button>
        </form>
    </div>
    <hr/>
</div>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>S.N.</td>
            <td>Transferred From</td>
            <td>Transferred To</td>
            <td>Amount</td>
            <td>Date</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $sn = 1;
        foreach ($data as $e) {

            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->transfer_from ?></td>
                <td><?php echo $e->transfer_to ?></td>
                <td><?php echo config_item('currency') . $e->amount ?></td>
                <td><?php echo $e->time ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
