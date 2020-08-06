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
            <label>Stage Name</label>
            <input type="text" class="form-control" value="<?php echo set_value('package_name') ?>" name="package_name">
        </div>
        <div class="col-sm-6">
            <label>Upgradation / Donation Amount (In <?php echo config_item('currency') ?>)</label>
            <input type="text" class="form-control" value="<?php echo set_value('invst_amount') ?>" placeholder="Leave Blank for variable amount" name="invst_amount">
        </div>
        <div class="form-group">
            <p>
                &nbsp;&nbsp;&nbsp;<span style="color: #90111A">(Please leave unnecessary fields blank)</span>
            </p>
            <div class="col-sm-6">
                <label>Sponsor Income</label>
                <input type="text" class="form-control" name="sponsor_income"
                       value="<?php echo set_value('sponsor_income') ?>">
            </div>
            <div class="col-sm-6">
                <label>Position Income</label>
                <input type="text" class="form-control" name="position_income"
                       value="<?php echo set_value('position_income') ?>">
            </div>
            <div class="col-sm-6">
                <label>Donation Level (In Number)</label>
                <input type="number" class="form-control" placeholder="eg: For first level donation enter 1" name="donation_level"
                       value="<?php echo set_value('donation_level') ?>">
            </div>
            <div class="col-sm-6">
                <label>Donation Qty</label> (Including Incomes)
                <input type="number" class="form-control" placeholder="How many donation he/she has to send to upgrade to next one" name="donation_qty"
                       value="<?php echo set_value('donation_qty') ?>">
            </div>
            <div class="col-sm-6">
                <label>Expired After</label> (In days)
                <input type="number" class="form-control" placeholder="Expires after how many days" name="expiry_after"
                       value="<?php echo set_value('expiry_after', 2) ?>">
            </div>
            <!--- END ----------------->
        </div>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Create" onclick="this.value='Creating..'">
    </div>
<?php echo form_close() ?>