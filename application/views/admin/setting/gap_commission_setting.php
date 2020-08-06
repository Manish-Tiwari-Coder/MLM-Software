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
    team if you have any query or you want to learn to how to use this setting.
</div>
<div class="row">
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Earning Name</label>
        <select class="form-control" name="income_name">
            <option>Level Income</option>
            <option>Matching Income</option>
            <option>Direct Income</option>
            <option>Other Income</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Commission Percentage</label>
        <input type="text" class="form-control" value="<?php echo set_value('amount') ?>" name="amount">
    </div>
    <div class="col-sm-6">
        <label>Total PV <br/> </label>
        <input type="text" class="form-control" value="<?php echo set_value('total_pv', '0') ?>"
               name="total_pv">
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
            <th>Total Member/PV</th>
            <th>Commission Percentage</th>
            <th>#</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->income_name; ?></td>
                <td><?php echo $e->total_pv; ?></td>
                <td><?php echo $e->amount; ?> %</td>
                <td>
                    <a href="<?php echo site_url('income/edit-gap-commission-setting/' . $e->id); ?>"
                       class="btn btn-info btn-xs glyphicon glyphicon-pencil"></a>
                    <a onclick="return confirm('Are you sure you want to delete this Income ?')"
                       href="<?php echo site_url('income/remove-gap-income/' . $e->id); ?>"
                       class="btn btn-danger btn-xs glyphicon glyphicon-remove"></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>