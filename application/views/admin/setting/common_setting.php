<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
$this->load->config('email');
?>
<div class="row">
    <?php echo form_open_multipart() ?>
    <div class="col-sm-6">
        <label>SMTP Host</label>
        <input type="text" class="form-control" value="<?php echo set_value('smtp_host', config_item('smtp_host')) ?>"
               name="smtp_host">
    </div>
    <div class="col-sm-6">
        <label>SMTP User</label>
        <input type="text" class="form-control" value="<?php echo set_value('smtp_user', config_item('smtp_user')) ?>"
               name="smtp_user">
    </div>
    <div class="col-sm-6">
        <label>SMTP Pass</label>
        <input type="text" class="form-control" value="<?php echo set_value('smtp_pass', config_item('smtp_pass')) ?>"
               name="smtp_pass">
    </div>
    <div class="col-sm-6">
        <label>SMTP Port (SSL Only)</label>
        <input type="text" class="form-control" value="<?php echo set_value('smtp_port', config_item('smtp_port')) ?>"
               name="smtp_port">
    </div>
    <div class="col-sm-6">
        <br/>
        <span class="btn btn-default btn-file"><span>Choose Logo</span><input name="logo" type="file"/></span>
    </div>
    <div class="col-sm-6">
        <br/>
        <span class="btn btn-default btn-file"><span>Choose Favicon.ico</span><input name="favicon" type="file"/></span>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>