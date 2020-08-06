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
        <label>Current Admin Password</label>
        <input type="password" required class="form-control" value="<?php echo set_value('password') ?>"
               name="password">
    </div>
    <div class="col-sm-6">
        <label>Please Check Below to Agree</label><br/>
        <input type="checkbox" required name="agree"> I know that If I click the below button, All the entries from my
        database will get deleted which is not reversible.
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Reset My Database">
    </div>
    <?php echo form_close() ?>
</div>
<div class="alert alert-warning">
    <strong>Notice: </strong> Before you click on "Reset My Database", Please keep a backup of your existing database which will ensure further safety if anything goes wrong. <a href="<?php echo site_url('setting/export-final') ?>">Click Here for Backup &rarr;</a>
</div>