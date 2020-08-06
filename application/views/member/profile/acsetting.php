<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open() ?>
<div class="col-sm-7 col-md-offset-2">
    <label>Enter Current Password:</label>
    <input type="password" name="oldpass" required class="form-control"><br/>
    <label>Enter New Password:</label>
    <input type="password" name="newpass" required class="form-control"><br/>
    <label>Retype New Password:</label>
    <input type="password" name="repass" required class="form-control"><br/>
    <button class="btn btn-success" name="submit" value="add">Update</button>
</div>
<?php echo form_close() ?>

