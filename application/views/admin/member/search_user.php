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
    <?php echo form_open('users/search') ?>
    <div class="alert alert-info">Fill any or all fields as per your need.</div>
    <div class="col-sm-6">
        <label>User ID</label>
        <input type="text" class="form-control" id="userid" name="userid">
    </div>
    <div class="col-sm-6">
        <label>Phone No</label>
        <input type="text" class="form-control" id="phone" name="phone">
    </div>
    <div class="col-sm-6">
        <label>Join Start Date</label>
        <input type="text" class="form-control datepicker" readonly id="startdate" name="startdate">
    </div>
    <div class="col-sm-6">
        <label>Join End Date</label>
        <input type="text" class="form-control datepicker" readonly id="enddate" name="enddate">
    </div>
    <div class="col-sm-6">
        <label>Email ID</label>
        <input type="text" class="form-control" id="email" name="email">
    </div>
    <div class="col-sm-6">
        <label>Sponsor ID</label>
        <input type="text" class="form-control" id="sponsor" name="sponsor">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">

        <a href="<?php echo site_url('admin') ?>" class="btn btn-danger">&larr; Go Back</a>
    </div>
    <?php echo form_close() ?>
</div>
