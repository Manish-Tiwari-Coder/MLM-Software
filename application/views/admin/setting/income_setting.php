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
    <div class="alert alert-danger">
        <strong>Warning !</strong> You have enabled "Give Fix Income" option at Advance Setting section of Business Setting. This means, product/service based income setting will not work now. You have to set income here.
    </div>
    <div class="col-sm-6">
        <label>Direct Income (% of registration fee)</label>
        <input type="text" class="form-control" value="<?php echo set_value('direct_income', $result->direct_income) ?>" name="direct_income">
    </div>
    <input type="hidden" name="id" value="1">
    <div class="col-sm-6">
        <label>Level Income (Comma Separated and in % of registration fee)</label>
        <input type="text" class="form-control" value="<?php echo set_value('level_income', $result->level_income) ?>" name="level_income">
    </div>
    <div class="col-sm-6">
        <label>Matching Income (in % of registration fee.)</label>
        <input type="text" class="form-control" value="<?php echo set_value('binary_income', $result->binary_income) ?>" name="binary_income">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>