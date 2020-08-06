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
            <option selected>Member</option>
            <option>PV</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Rank Name</label>
        <input type="text" class="form-control" value="<?php echo set_value('rank_name') ?>" name="rank_name">
    </div>
    <div class="col-sm-6">
        <label>Achieve Duration <br/> </label>
        <input type="text" class="form-control" value="<?php echo set_value('rank_duration', '0') ?>"
               name="rank_duration"><span style="font-size: 11px">( Within how many days he/she should achieve this  ? 0 for no duration )</span>
    </div>
    <div class="col-sm-6">
        <?php
        ?>
        <?php foreach ($leg as $key => $val) { ?>
            <label>Total People/PV at <?php echo $key ?> Side</label><input required type="text" class="form-control"
                                                                            placeholder="How many people or PV at <?php echo $key ?> side ?"
                                                                            name="<?php echo $key ?>" value="<?php echo set_value($key) ?>">
        <?php } ?>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Save" onclick="this.value='Saving..'">
    </div>
    <?php echo form_close() ?>
</div><!------------- MANAGE REWARDS -------------------------------->

<p>&nbsp;</p>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Income Name</th>
            <th>Duration</th>
            <th>Based On</th>
            <th>#</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->rank_name; ?></td>
                <td><?php echo $e->rank_duration; ?></td>
                <td><?php echo $e->based_on; ?></td>
                <td>
                    <a href="<?php echo site_url('setting/edit-rank/' . $e->id); ?>"
                       class="btn btn-info btn-xs glyphicon glyphicon-pencil"></a>
                    <a onclick="return confirm('Are you sure you want to delete this Income ?')"
                       href="<?php echo site_url('setting/remove-rank/' . $e->id); ?>"
                       class="btn btn-danger btn-xs glyphicon glyphicon-remove"></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>