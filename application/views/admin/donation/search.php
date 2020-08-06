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
    <?php echo form_open('donation/search') ?>
    <div class="alert alert-info">Fill any or all fields as per your need.</div>
    <div class="col-sm-6">
        <label>Donation Level</label>
        <select class="form-control" name="pack_name">
            <option selected>All</option>
            <?php
            foreach ($result as $e) {
                echo '<option value="' . $e->id . '">' . $e->plan_name . ' (Stage ' . $e->donation_level . ')</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Status</label>
        <select class="form-control" name="status">
            <option selected>All</option>
            <option value="Sent">Not-Sent</option>
            <option value="Waiting">Sent</option>
            <option value="Accepted">Accepted</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>User ID</label>
        <input type="text" class="form-control" id="userid" name="userid">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">
    </div>
    <?php echo form_close() ?>
</div>