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
        <label>Name</label>
        <input type="text" class="form-control" value="<?php echo set_value('name', $result->name) ?>" name="name">
    </div>
    <div class="col-sm-6">
        <label>Email ID</label>
        <input type="text" class="form-control" value="<?php echo set_value('email', $result->email) ?>" name="email">
    </div>
    <div class="col-sm-6">
        <label>Current Password</label>
        <input type="password" required class="form-control" value="<?php echo set_value('password') ?>"
               name="password">
    </div>
    <div class="col-sm-6">
        <label>New Password</label>
        <input type="password" class="form-control" value="<?php echo set_value('newpass') ?>" name="newpass">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>