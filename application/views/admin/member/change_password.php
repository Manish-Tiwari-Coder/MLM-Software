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
    <?php echo form_open('users/password_search') ?>
    <div class="form-horizontal">
    <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">User ID</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" class="form-control" id="userid" name="userid">
                </div>
            </div>
        </div> 
        <?php foreach($members as $e) {} ?>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">User ID</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                    <input type="text" class="form-control" value="<?php echo $e['username']; ?>" name="email" disabled>
                </div>
            </div>
        </div>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" class="form-control" value="<?php echo $e['name']; ?> " name="name" disabled>
                </div>
            </div>
        </div>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">Email ID</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="text" class="form-control" value="<?php echo $e['email']; ?>" name="email" disabled>
                </div>
            </div>
        </div>
        <div class="form-group form-horizontal">
            <label for="inputext" class="col-lg-2 control-label">Mobile No</label>
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                    <input type="text" class="form-control" value="<?php echo $e['phone']; ?>" name="email" disabled>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-lg-offset-2">
            <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">  
        </div>
    </div>
    <?php echo form_close() ?>
</div>