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
        <label>Payout TAX (%)</label>
        <input type="text" class="form-control" value="<?php echo set_value('payout_tax', config_item('payout_tax')) ?>"
               name="payout_tax">
    </div>
    <div class="col-sm-6">
        <label>Allow User to Withdraw Fund</label>
        <select class="form-control" name="user_withdraw">
            <option selected><?php echo config_item('user_withdraw') ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Min amount allowed to Withdraw (in <?php echo config_item('currency') ?> )</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('min_withdraw', config_item('min_withdraw')) ?>"
               name="min_withdraw">
    </div>
    <div class="col-sm-6">
        <label>Use Payment API</label>
        <select class="form-control" name="payment_api">
            <option selected><?php echo config_item('payment_api') ?></option>
            <option>None</option>
            <option>Block.io</option>
        </select>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>