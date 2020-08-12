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
    <?php echo form_open('users/cpass') ?>
    <div class="alert alert-info">Fill any or all fields as per your need.</div>
    <div class="col-sm-6">
        <label>User ID</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" class="form-control" id="userid" name="userid">
        </div>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">

        <a href="<?php echo site_url('admin') ?>" class="btn btn-danger">&larr; Go Back</a>
    </div>
    <?php echo form_close() ?>
</div>
<?php foreach ($members as $e){ }?>
<div class="col-sm-6">
    <label>User ID</label>
    <div class="input-group">
        <span class="input-group-addon"><span class="glyphicon glyphicon-pushpin"></span></span>
        <input type="text" class="form-control" value="<?php echo $e['id']; ?>" disabled>
    </div>
</div>
<div class="col-sm-6">
    <label>Name</label>
    <div class="input-group">
        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
        <input type="text" class="form-control" value="<?php echo $e['name']; ?>" disabled>
    </div>
</div>
<div class="col-sm-6">
    <label>Mobile</label>
    <div class="input-group">
        <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
        <input type="text" class="form-control" value="<?php echo $e['phone']; ?>" disabled>
    </div>
</div>
<div class="col-sm-6">
    <label>Current Password</label>
    
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            <input type="password" required class="form-control" value="<?php echo set_value('password') ?>" name="password" >
        
    </div>
</div>
<div class="col-sm-6">
    <label>New Password</label>
    
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            <input type="password" class="form-control" value="<?php echo set_value('newpass') ?>" name="newpass">
        
    </div>
</div>
    
   