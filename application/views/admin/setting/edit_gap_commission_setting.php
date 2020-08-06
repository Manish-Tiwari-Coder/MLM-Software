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
        <label>Earning Name</label>
        <select class="form-control" name="income_name">
            <option selected><?php echo $result->income_name ?></option>
            <option>Level Income</option>
            <option>Matching Income</option>
            <option>Direct Income</option>
            <option>Other Income</option>
        </select>
    </div>
    <input type="hidden" name="id" value="<?php echo $result->id ?>">
    <div class="col-sm-6">
        <label>Commission Percentage</label>
        <input type="text" class="form-control" value="<?php echo set_value('amount', $result->amount) ?>" name="amount">
    </div>
    <div class="col-sm-6">
        <label>Total PV <br/> </label>
        <input type="text" class="form-control" value="<?php echo set_value('total_pv', $result->total_pv) ?>"
               name="total_pv">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Saving..'">
    </div>
    <?php echo form_close() ?>
</div>
