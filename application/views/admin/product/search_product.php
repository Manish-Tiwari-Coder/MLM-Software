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
    <?php echo form_open('product/search') ?>
    <div class="alert alert-info">Fill any or all fields as per your need.</div>
    <div class="col-sm-6">
        <label>Category</label>
        <select class="form-control" name="category">
            <option selected>All</option>
            <?php foreach ($parents as $val) {
                echo '<option value="' . $val['id'] . '">' . $val['cat_name'] . '</option>';
            } ?>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Product Name</label>
        <input type="text" class="form-control" id="pname" name="pname">
    </div>
    <div class="col-sm-6">
        <label>Selling Status</label>
        <select class="form-control" name="status">
            <option selected>All</option>
            <option>Selling</option>
            <option>Not-Selling</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Sign Up Product</label>
        <select class="form-control" name="is_sign_up">
            <option selected>All</option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-12"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">
    </div>
    <?php echo form_close() ?>
</div>