<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="alert alert-danger">
    <strong>Warning !</strong> if you don't know what you are doing. Please do not modify this setting. Call our support
    team if you have any query or you want to learn to how to use this setting. From here you can set when an user will
    get
    commission and on which condition basis.
</div>
<div class="row">
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Matching Patern</label>
        <select class="form-control" name="income_name">
            <option selected><?php echo $result->income_name ?></option>
            <option>Total Member</option>
            <option>Matching Income</option>
            <option>Direct Income</option>
            <option>Other Income</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Earning Name</label>
        <select class="form-control" name="income_name">
            <option selected><?php echo $result->income_name ?></option>
            <option>Level Income</option>
            <option>Matching Income</option>
            <option>Direct Income</option>
            <option>Other Income</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Counting Based On</label>
        <select class="form-control" name="based_on">
            <option selected><?php echo $result->based_on ?></option>
            <option>Member</option>
            <option>PV</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Earning Amount</label>
        <input type="text" class="form-control" value="<?php echo set_value('amount', $result->amount) ?>" name="amount">
    </div>
    <div class="col-sm-6">
        <label>Achieve Duration <br/> </label>
        <input type="text" class="form-control" value="<?php echo set_value('income_duration', $result->income_duration) ?>"
               name="income_duration"><span style="font-size: 11px">( Within how many days he/she should achieve this  ? 0 for no duration )</span>
    </div>
    <div class="col-sm-6">
        <?php
        ?>
        <?php foreach ($leg as $key => $val) { ?>
            <label><?php echo $key ?></label><input type="text" class="form-control"
                                                    placeholder="How many people at <?php echo $key ?> side ?"
                                                    name="<?php echo $key ?>" value="<?php echo set_value($key, $result->$key) ?>">
        <?php } ?>
    </div>
    <input type="hidden" name="id" value="<?php echo $result->id ?>">
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Save" onclick="this.value='Saving..'">
    </div>
    <?php echo form_close() ?>
</div>