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
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Salary (in <?php echo config_item('currency') ?> )</label>
        <input type="text" class="form-control" value="<?php echo set_value('salary', $salary->salary) ?>"
               name="salary">
    </div>

    <div class="col-sm-6">
        <label>Salary Month</label>
        <select name="month" class="form-control">
            <option selected><?php echo $salary->month ?></option>
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">May</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08">Aug</option>
            <option value="09">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Salary Year</label>
        <select name="year" class="form-control">
            <option selected><?php echo $salary->year ?></option>
            <option><?php echo date('Y', strtotime('last year')) ?></option>
            <option><?php echo date('Y') ?></option>
            <option><?php echo date('Y', strtotime('next year')) ?></option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Salary Pay Date</label>
        <input type="text" class="form-control datepicker" name="paydate"
               value="<?php echo set_value('paydate', $salary->paydate) ?>">
    </div>
    <input type="hidden" name="id" value="<?php echo $salary->id ?>">
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Doing.....'">
    </div>
    <?php echo form_close() ?>
</div>