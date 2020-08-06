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
<h3>Editing e-PIN: <?php echo $data->epin ?></h3>
<hr/>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-5">
        <label>e-PIN Amount*</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
            <input type="text" class="form-control" value="<?php echo set_value('amount', $data->amount) ?>"
                   placeholder="For free e-pin enter 0" name="amount">
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $data->id ?>">
    <div class="col-sm-5">
        <label>User ID (Whom to issue)*</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" value="<?php echo set_value('userid', config_item('ID_EXT') . $data->issue_to) ?>"
                   class="form-control" placeholder="1001" name="userid">
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
                <option>Used</option>
                <option>Un-used</option>
            </select>
        </div>
    </div>
    <div class="col-sm-5">
        <div>&nbsp;</div>
        <input type="submit" class="btn btn-danger" onclick="this.value='Please Wait..'" value="Update e-PIN">
    </div>
    <div class="col-sm-1"></div>
</div>
<?php echo form_close() ?>
