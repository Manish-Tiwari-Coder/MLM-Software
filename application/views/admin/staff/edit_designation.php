<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without
 * permission. Project Developer: Bidush Sarkar Developed for: Exolim IT Services
 * Pvt Ltd
 **************************************************************************************************/
$perms = unserialize($data->des_permission);
?>
<div class="row">
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Designation Name</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('des_name', $data->des_title) ?>"
               name="des_name">
    </div>
    <div class="col-sm-6">
        <label>Payscale (In decimal)</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('payscale', $data->payscale) ?>"
               name="payscale">
    </div>
    <div class="col-sm-12">
        <label>Select Permissions</label>
        <p>
            <input type="checkbox" value="1" <?php if ($perms['b_setting'] == "1") {
                echo 'checked';
            } ?> name="b_setting"> Business Setting (Admin Right)<br/>
            <input type="checkbox" value="1" <?php if ($perms['user_manage'] == "1") {
                echo 'checked';
            } ?> name="user_manage"> User Management (Admin Right)<br/>
            <input type="checkbox" value="1" <?php if ($perms['tree_view'] == "1") {
                echo 'checked';
            } ?> name="tree_view"> User View<br/>
            <input type="checkbox" value="1" <?php if ($perms['epin'] == "1") {
                echo 'checked';
            } ?> name="epin"> e-PIN Management<br/>
            <input type="checkbox" value="1" <?php if ($perms['wallet'] == "1") {
                echo 'checked';
            } ?> name="epin"> e-Wallet Management<br/>
            <input type="checkbox" value="1" <?php if ($perms['earning_manage'] == "1") {
                echo 'checked';
            } ?> name="earning_manage"> Manage Earning<br/>
            <input type="checkbox" value="1" <?php if ($perms['manage_poducts'] == "1") {
                echo 'checked';
            } ?> name="manage_poducts"> Manage Products<br/>
            <input type="checkbox" value="1" <?php if ($perms['view_orders'] == "1") {
                echo 'checked';
            } ?> name="view_orders"> View Orders<br/>
            <?php if (config_item('enable_coupon') == "Yes") : ?>
                <input type="checkbox" value="1" <?php if ($perms['coupon'] == "1") {
                    echo 'checked';
                } ?> name="coupon"> Coupon Management<br/>
            <?php endif; ?>
            <input type="checkbox" value="1" <?php if ($perms['staff'] == "1") {
                echo 'checked';
            } ?> name="staff"> Manage Staffs<br/>
            <input type="checkbox" value="1" <?php if ($perms['franchisee'] == "1") {
                echo 'checked';
            } ?> name="franchisee"> Manage Franchisee<br/>
            <input type="checkbox" value="1" <?php if ($perms['support'] == "1") {
                echo 'checked';
            } ?> name="support"> Manage Support<br/>
            <input type="checkbox" value="1" <?php if ($perms['expense'] == "1") {
                echo 'checked';
            } ?> name="expense"> Manage Expenses<br/>
            <input type="checkbox" value="1" <?php if ($perms['invoice'] == "1") {
                echo 'checked';
            } ?> name="invoice"> Manage Invoices<br/>
        </p>
    </div>
    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update"
               onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>