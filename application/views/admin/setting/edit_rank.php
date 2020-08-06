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
        <label>Counting Based On</label>
        <select class="form-control" name="based_on">
            <option selected><?php echo $result->based_on ?></option>
            <option>Member</option>
            <option>PV</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Rank Name</label>
        <input type="text" class="form-control" value="<?php echo set_value('rank_name', $result->rank_name) ?>" name="rank_name">
    </div>
    <div class="col-sm-6">
        <label>Achieve Duration <br/> </label>
        <input type="text" class="form-control" value="<?php echo set_value('rank_duration', $result->rank_duration) ?>"
               name="rank_duration"><span style="font-size: 11px">( Within how many days he/she should achieve this  ? 0 for no duration )</span>
    </div>
    <input type="hidden" name="id" value="<?php echo $result->id ?>">
    <div class="col-sm-6">
        <?php
        ?>
        <?php foreach ($leg as $key => $val) { ?>
            <label>Total People/PV at <?php echo $key ?> Side</label><input required type="text" class="form-control"
                                                                            placeholder="How many people or PV at <?php echo $key ?> side ?"
                                                                            name="<?php echo $key ?>" value="<?php echo set_value($key, $result->$key) ?>">
        <?php } ?>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>