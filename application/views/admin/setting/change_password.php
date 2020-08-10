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
    <div class="form-horizontal">
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" class="form-control" value="<?php echo set_value('name', $result->name) ?>" name="name" disabled>
                </div>
            </div>
        </div>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">Email ID</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="text" class="form-control" value="<?php echo set_value('email', $result->email) ?>" name="email" disabled>
                </div>
            </div>
        </div>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">Current Password</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" required class="form-control" value="<?php echo set_value('password') ?>"
               name="password" >
                </div>
            </div>
        </div>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">New  Password</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" class="form-control" value="<?php echo set_value('newpass') ?>" name="newpass">
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-3">
            <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
        </div>    
    </div>
    <?php echo form_close() ?>
</div>