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
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-5">
        <label>Earning Amount*</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
            <input type="text" class="form-control" value="<?php echo set_value('amount', $data->amount) ?>"
                   name="amount">
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $data->id ?>">
    <div class="col-sm-5">
        <label>Date*</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            <input type="text" readonly value="<?php echo set_value('userid', $data->date) ?>"
                   class="form-control datepicker" name="date">
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>
<div>&nbsp;</div>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-5">
        <label>Status*</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-arrow-right"></span></span>
            <select name="status" class="form-control">
                <option selected><?php echo $data->status ?></option>
                <option>Pending</option>
                <option>Paid</option>
            </select>
        </div>
    </div>
    <div class="col-sm-5">
        <div>&nbsp;</div>
        <input type="submit" class="btn btn-danger" onclick="this.value='Working..'" value="Update Earning">
    </div>
    <div class="col-sm-1"></div>
</div>
<?php echo form_close() ?>
