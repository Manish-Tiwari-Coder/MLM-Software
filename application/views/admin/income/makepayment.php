<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$this->db->where('status', 'Un-Paid');
$data = $this->db->get('withdraw_request')->result();
?>
<a target="_blank" href="<?php echo site_url('income/printout-withdraw-list') ?>" class="btn btn-danger">Print Out
    Payout List &rarr;</a>
<?php if (config_item('payment_api') !== "None") { ?>
    <a href="<?php echo site_url('income/payall-gateway') ?>" class="pull-right btn btn-success">Pay
        All Using Gateway &rarr;</a>
<?php } ?>
<hr/>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr style="font-weight: bold">
            <td>S.N.</td>
            <td>User ID</td>
            <td>Amount</td>
            <td>Tax (%)</td>
            <td>Net Payable</td>
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
                <td><?php echo config_item('ID_EXT') . $e->userid ?></td>
                <td><?php echo config_item('currency') . $e->amount ?></td>
                <td><?php echo config_item('payout_tax') ?> %</td>
                <td><?php echo config_item('currency') . ($e->amount - ($e->amount * config_item('payout_tax') / 100)) ?></td>
                <td><?php echo $e->date ?></td>
                <td style="font-size:12px;">
                    <?php
                    echo $this->db_model->select('name', 'member', array('id' => $e->userid)) . "<br/>";
                    $data = $this->db_model->select_multi('bank_ac_no, bank_name, bank_ifsc, bank_branch, btc_address, tcc_address', 'member_profile', array('userid' => $e->userid));
                    echo $data->bank_name ? '<strong>Bank Name:</strong> ' . $data->bank_name . '<br/>' : '';
                    echo $data->bank_ac_no ? '<strong>A/C No:</strong> ' . $data->bank_ac_no . '<br/>' : '';
                    echo $data->bank_ifsc ? '<strong>IFSC:</strong> ' . $data->bank_ifsc . '<br/>' : '';
                    echo $data->bank_branch ? '<strong>Bank Branch:</strong> ' . $data->bank_branch . '<br/>' : '';
                    echo $data->btc_address ? '<strong>BTC Add:</strong> ' . $data->btc_address . '<br/>' : '';
                    echo $data->tcc_address ? '<strong>TCC Add:</strong> ' . $data->tcc_address . '<br/>' : '';
                    ?>
                </td>
                <td><a data-toggle="modal" data-target="#myModal"
                       onclick="document.getElementById('payid').value='<?php echo $e->id ?>'"
                       class="btn btn-primary btn-xs">Pay</a>
                    <a href="<?php echo site_url('income/hold/' . $e->id) ?>" class="btn btn-warning btn-xs">Hold</a>
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
