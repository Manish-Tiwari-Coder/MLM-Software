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
    <?php echo form_open('users/topup_member') ?>
    <div class="col-sm-6">
        <label>User ID</label>
        <input type="text" value="<?php echo $this->uri->segment(3) ? $this->uri->segment(3) : '' ?>"
               class="form-control" id="userid" name="userid">
    </div>
    <div class="col-sm-6">
        <label>Amount to Topup</label>
        <input type="text" class="form-control" id="amt" name="amt">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="TopUp" onclick="this.value='Working..'">
    </div>
    <?php echo form_close() ?>
</div>