<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Coupon Code</th>
            <th>Amount</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->coupon; ?></td>
                <td><?php echo $e->coupon_amt; ?></td>
                <td><?php echo $this->db_model->select('cat_name', 'coupon_categories', array('id' => $e->id)); ?></td>
                <td><?php echo $e->status; ?></td>
                <td>
                    <?php if ($e->status == "Un-Used") { ?>
                        <a href="javascript:;"
                           onclick="document.getElementById('id').value='<?php echo $e->id ?>'; document.getElementById('ccode').innerHTML='<?php echo $e->coupon ?>'"
                           data-toggle="modal" data-target="#coupon"
                           class="btn btn-info btn-xs">Use</a>
                    <?php } ?>
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
                <h4 class="modal-title">Want to Use This Coupon ? </h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo form_open('coupon/use-it') ?>
                    <label>Coupon Code: </label><span id="ccode"></span>
                    <input type="hidden" class="form-control" name="id" id="id" value=""><br/>
                    <button type="submit" class="btn btn-success">Request to Use</button>
                    <?php echo form_close() ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>