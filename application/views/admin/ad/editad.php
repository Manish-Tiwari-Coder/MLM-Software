<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open('ads/update') ?>
<div class="row">
    <div class="form-group col-sm-6">
        <label>Ad Title *</label><br/>
        <input required type="text" name="ad_title" value="<?php echo $ads->ad_title ?>" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <label>Expiry Date *</label>
        <input type="text" readonly value="<?php echo $ads->expiry_date ?>" name="expiry_date" class="form-control datepicker">
    </div>
    <div class="form-group col-sm-6">
        <label>Ad HTML Code / URL *</label>
        <textarea class="form-control" rows="10" name="ad_html"><?php echo $ads->ad_html ?></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label>Level Earning %<br/>
            <span style="font-size: 13px; color: red">(Comma Separated. First one is self income. If you donot want to give
                            direct or self income please use 0. eg: 0, 5, 6)</span></label>
        <input type="text" name="level_earning" value="<?php echo $ads->level_earning ?>" class="form-control">
    </div>
    <input type="hidden" name="id" value="<?php echo $ads->id ?>">
    <div class="form-group col-sm-6">
        <label>Type *</label>
        <select class="form-control" name="type">
            <option selected><?php echo $ads->type ?></option>
            <option value="html">HTML / Text</option>
            <option value="url">URL</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <button type="submit" class="btn btn-success">Update &rarr;</button>
    </div>
    <?php echo form_close() ?>
</div>