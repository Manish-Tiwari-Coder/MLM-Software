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
    <?php echo form_open_multipart() ?>
    <div class="form-group">
        <div class="col-sm-6">
            <label>Product/Service Name</label>
            <input type="text" class="form-control" name="prod_name" value="<?php echo set_value('prod_name') ?>">
        </div>
        <div class="col-sm-6">
            <label>Product/Service Category</label>
            <select class="form-control" name="category">
                <?php foreach ($parents as $val) {
                    echo '<option value="' . $val['id'] . '">' . $val['cat_name'] . '</option>';
                } ?>
            </select>
        </div>
        <div>&nbsp;</div>
        <div class="col-sm-12">
            <label>Product/Service Description</label>
            <textarea class="form-control" id="editor" name="prod_desc"><?php echo set_value('prod_desc') ?></textarea>
        </div>
        <div class="col-sm-6">
            <label>Product/Service Price (Member Price)</label>
            <input type="text" class="form-control" name="prod_price" value="<?php echo set_value('prod_price') ?>">
        </div>
        <div class="col-sm-6">
            <label>Dealer Price (Franchisee Price)</label>
            <input type="text" class="form-control" name="dealer_price" value="<?php echo set_value('dealer_price') ?>">
        </div>
        <div class="col-sm-6">
            <label>Business Value or PV</label>
            <input type="text" class="form-control" name="pv" value="<?php echo set_value('pv') ?>">
        </div>
        <div class="col-sm-6">
            <label>Available Qty (-1 for no limit)</label>
            <input type="number" class="form-control" placeholder="-1 for unlimited" name="qty"
                   value="<?php echo set_value('qty', '-1') ?>">
        </div>
        <div class="col-sm-6">
            <label>GST/TAX (%)</label>
            <input type="text" class="form-control" name="gst" value="<?php echo set_value('gst') ?>">
        </div>
        <div class="col-sm-6">
            <label>Product Image</label>
            <input type="file" name="img">
        </div>
        <div class="col-sm-6">
            <label>Show on Registration Form ?</label>
            <input type="checkbox" value="Yes" checked name="join_form"> Yes
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#commission">Add Commission
                ?
            </button>
        </div>
    </div>
</div>
<!--- COMMISSION PART ----->
<?php if (config_item('fix_income') == 'Yes') { ?>
    <div class="alert alert-danger">
        <strong>Warning !</strong> You have enabled "Give Fix Income" option at Advance Setting section of Business
        Setting. This means, product/service based income setting will not work now. So Income Setting is disabled
        Here..
    </div>
<?php } else { ?>
    <div class="row">
        <div class="form-group collapse" id="commission">
            <p>
                &nbsp;&nbsp;&nbsp;<span style="color: #90111A">(Please leave unnecessary fields blank)</span>
            </p>
            <div class="col-sm-6">
                <label>Direct Income (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" name="direct_income"
                       value="<?php echo set_value('direct_income') ?>">
            </div>
            <div class="col-sm-6">
                <label>Level Income (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" placeholder="Comma separate each level income. eg: 12,3,4"
                       name="level_income" value="<?php echo set_value('level_income') ?>">
            </div>
            <div class="col-sm-6">
                <label>Matching Income (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" name="matching_income"
                       value="<?php echo set_value('matching_income') ?>">
            </div>
            <div class="col-sm-6">
                <label>Capping Amount (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" name="capping" value="<?php echo set_value('capping') ?>">
            </div>
            <div class="col-sm-6">
                <label>ROI (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" placeholder="Return of Investment"
                       value="<?php echo set_value('roi') ?>" name="roi">
            </div>
            <div class="col-sm-6">
                <label>ROI Frequency (In Days)</label>
                <input type="number" class="form-control" placeholder="How frequently you'll pay ROI" name="roi_frequency"
                       value="<?php echo set_value('roi_frequency') ?>">
            </div>
            <div class="col-sm-6">
                <label>ROI Limit (In Number)</label>
                <input type="number" class="form-control" placeholder="How many time you'll pay ROI ?" name="roi_limit"
                       value="<?php echo set_value('roi_limit') ?>">
            </div>

            <!--- END ----------------->
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-sm-12"><br/>
        <input type="submit" class="btn btn-success" value="Create" onclick="this.value='Creating..'">
    </div>
    <?php echo form_close() ?>
</div>