<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="alert alert-info">Your Wallet
    have
    <strong><?php echo config_item('currency') . $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id)) ?></strong>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo site_url('member/topup_wallet') ?>"
                                                                          class="btn btn-xs btn-warning">Add
        More Fund &rarr;</a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>SN</th>
            <th>Package Name</th>
            <th>Amount</th>
            <th>ROI</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->pack_name; ?></td>
                <td style="background-color: #3c763d; color: #fff"><?php echo $e->amount ? config_item('currency') . $e->amount : 'Any Amount'; ?></td>
                <?php if ($e->based == "Fixed") { ?>
                    <td><?php echo config_item('currency') . $e->roi; ?></td>
                <?php } else { ?>
                    <td><?php echo $e->roi; ?> %</td>
                <?php } ?>
                <td>
                    <a href="javascript:;"
                       onclick="document.getElementById('amt_div').style.display=<?php if ($e->amount > 0) {
                           echo "'none'";
                       } else echo "'block'"; ?>;document.getElementById('id').value='<?php echo $e->id ?>';document.getElementById('amt').value='<?php echo $e->amount ? $e->amount : '' ?>'; document.getElementById('ccode').innerHTML='<?php echo $e->pack_name ?>'"
                       data-toggle="modal" data-target="#coupon"
                       class="btn btn-info btn-xs">Invest Here</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>

<div id="coupon" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="ccode"></h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo form_open('investments/do-it') ?>
                    <input type="hidden" class="form-control" name="id" id="id" value=""><br/>
                <div id="amt_div">
                    <label>Investment Amount (In <?php echo config_item('currency') ?>) :</label>
                    <input type="text" class="form-control" name="amount" value="" id="amt"><br/>
                </div>
                <?php if (config_item('investment_mode') == "EPIN") { ?>

                    <label>Investment e-PIN (Value must be same as amount) :</label>
                    <input type="text" class="form-control" name="epin"><br/>

                <?php } ?>
                <button type="submit" class="btn btn-success">Click to Invest &rarr;</button>
                <?php echo form_close() ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>