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
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Designation Name</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" class="form-control" value="<?php echo set_value('des_name') ?>" name="des_name">
        </div>
        
    </div>
    <div class="col-sm-6">
        <label>Payscale (In decimal)</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
            <input type="text" class="form-control" value="<?php echo set_value('payscale') ?>" name="payscale">
        </div>
    </div>
    <div class="col-sm-12">
        <label>Select Permissions</label>
        <p>
            <input type="checkbox" value="1" name="b_setting"> Business Setting (Admin Right)<br/>
            <input type="checkbox" value="1" name="user_manage"> User Management (Admin Right)<br/>
            <input type="checkbox" value="1" name="tree_view"> User View<br/>
            <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                <input type="checkbox" value="1" name="epin"> e-PIN Management<br/>
                <input type="checkbox" value="1" name="wallet"> e-Wallet Management<br/>
                <input type="checkbox" value="1" name="earning_manage"> Manage Earning<br/>
                <input type="checkbox" value="1" name="manage_poducts"> Manage Products<br/>
                <input type="checkbox" value="1" name="view_orders"> View Orders<br/>
                <?php if (config_item('enable_coupon') == "Yes") : ?>
                    <input type="checkbox" value="1" name="coupon"> Coupon Management<br/>
                <?php endif;
            } ?>
            <input type="checkbox" value="1" name="staff"> Manage Staffs<br/>
            <input type="checkbox" value="1" name="franchisee"> Manage Franchisee<br/>
            <input type="checkbox" value="1" name="support"> Manage Support<br/>
            <input type="checkbox" value="1" name="expense"> Manage Expenses<br/>
            <input type="checkbox" value="1" name="invoice"> Manage Invoices<br/>
        </p>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Create" onclick="this.value='Creating..'">
    </div>
    <?php echo form_close() ?>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Designation Name</th>
            <th>Payscale</th>
            <th>#</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->des_title; ?></td>
                <td><?php echo config_item('currency') . $e->payscale; ?></td>
                <td><a href="<?php echo site_url('staff/edit-des/' . $e->id); ?>" class="btn btn-info btn-xs">Edit</a><a
                            onclick="return confirm('Are you sure you want to delete this Designation ?')"
                            href="<?php echo site_url('staff/remove-des/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>