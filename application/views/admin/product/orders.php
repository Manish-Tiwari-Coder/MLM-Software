<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="row table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>User ID</th>
            <th>Product</th>
            <th>Cost</th>
            <th>Date</th>
            <th>#</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($orders as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo config_item('ID_EXT') . $e->userid; ?></td>
                <td><?php echo $this->db_model->select('prod_name', 'product', array('id' => $e->product_id)); ?></td>
                <td><?php echo config_item('currency') . $e->cost; ?></td>
                <td><?php echo $e->date; ?></td>
                <td>
                    <?php if ($e->status !== "Completed") { ?>
                        <a data-toggle="modal" data-target="#myModal"
                           onclick="document.getElementById('deliverid').value='<?php echo $e->id ?>'"
                           class="btn btn-primary btn-xs">Deliver</a>
                    <?php } ?>
                    <a href="<?php echo site_url('product/view_order/' . $e->id); ?>"
                       class="btn btn-success btn-xs">View</a>
                    <a onclick="return confirm('Are you sure you want to delete this Order ?')"
                       href="<?php echo site_url('product/remove_order/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="pull-right">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delivery Detail</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('product/deliver') ?>
                <label>Enter Delivery Detail (eg: Tracking No)</label>
                <input type="hidden" name="deliverid" value="" id="deliverid">
                <textarea class="form-control" name="tdetail"></textarea>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success">Deliver Now</button>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>