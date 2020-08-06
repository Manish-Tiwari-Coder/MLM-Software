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
    <form method="post" action="<?php echo site_url('income/search_rewards') ?>">
        <div class="col-sm-6">
            <label>Enter User Id</label>
            <input type="text" name="user_id" class="form-control">
        </div>
        <div class="col-sm-6">
            <label>Status</label>
            <select name="status" class="form-control">
                <option selected>All</option>
                <option>Pending</option>
                <option>Delivered</option>
            </select>
        </div>
        <div class="col-sm-6">
            <label>Start Date</label>
            <input type="text" readonly class="form-control datepicker" name="sdate">
        </div>
        <div class="col-sm-6">
            <label>End Date</label>
            <input type="text" readonly class="form-control datepicker" name="edate">
            <br/>
            <button type="submit" class="btn btn-primary">Search &rarr;</button>
        </div>
    </form>
</div>