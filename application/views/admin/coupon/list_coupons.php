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
    <?php echo form_open('coupon/search') ?>
    <div class="col-sm-6">
        <label>Select Category</label>
        <select class="form-control" name="coupon_cat">
            <option selected value="All">All</option>
            <?php
            foreach ($cats as $e) {
                echo '<option value="' . $e->id . '">' . $e->cat_name . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Status</label>
        <select class="form-control" name="status">
            <option selected value="All">All</option>
            <option value="Used">Used</option>
            <option value="Un-Used">Un-Used</option>
            <option value="Use Request">Requested for Use</option>
        </select>
    </div>
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
            <th>Coupon</th>
            <th>Userid</th>
            <th>Coupon Amt</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->coupon; ?></td>
                <td><?php echo $e->userid; ?></td>
                <td><?php echo config_item('currency') . $e->coupon_amt; ?></td>
                <td><?php echo $e->status; ?></td>
                <td>
                    <?php if ($e->status == "Use Request") { ?>
                        <a onclick="return confirm('Are you sure you want to mark this Coupon as used ?')"
                           href="<?php echo site_url('coupon/mark_use/' . $e->id); ?>" class="btn btn-info btn-xs">Mark
                            as
                            Used</a>
                    <?php } ?>
                    <a onclick="return confirm('Are you sure you want to delete this Coupon ?')"
                       href="<?php echo site_url('coupon/remove_coupon/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
