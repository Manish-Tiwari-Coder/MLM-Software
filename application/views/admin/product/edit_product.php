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
            <input type="text" class="form-control" name="prod_name"
                   value="<?php echo set_value('prod_name', $data->prod_name) ?>">
        </div>
        <input type="hidden" name="id" value="<?php echo $data->id ?>">
        <input type="hidden" name="image" value="<?php echo $data->image ?>">
        <div class="col-sm-6">
            <label>Product/Service Category</label>
            <select class="form-control" name="category">
                <option selected value="<?php $category = set_value('category', $data->category);
                echo $category ?>"><?php echo $this->db_model->select('cat_name', 'product_categories', array('id' => $category)) ?></option>
                <?php foreach ($parents as $val) {
                    echo '<option value="' . $val['id'] . '">' . $val['cat_name'] . '</option>';
                } ?>
            </select>
        </div>
        <div>&nbsp;</div>
        <div class="col-sm-12">
            <label>Product/Service Description</label>
            <textarea class="form-control" id="editor"
                      name="prod_desc"><?php echo set_value('prod_desc', $data->prod_desc) ?></textarea>
        </div>
        <div class="col-sm-6">
            <label>Product/Service Price (Member Price)</label>
            <input type="text" class="form-control" name="prod_price"
                   value="<?php echo set_value('prod_price', $data->prod_price) ?>">
        </div>
        <div class="col-sm-6">
            <label>Dealer Price (Franchisee Price)</label>
            <input type="text" class="form-control" name="dealer_price"
                   value="<?php echo set_value('dealer_price', $data->dealer_price) ?>">
        </div>
        <div class="col-sm-6">
            <label>Business Value or PV</label>
            <input type="text" class="form-control" name="pv" value="<?php echo set_value('pv', $data->pv) ?>">
        </div>
        <div class="col-sm-6">
            <label>Available Qty (-1 for no limit)</label>
            <input type="number" class="form-control" placeholder="-1 for unlimited" name="qty"
                   value="<?php echo set_value('qty', $data->qty) ?>">
        </div>
        <div class="col-sm-6">
            <label>GST/TAX (%)</label>
            <input type="text" class="form-control" name="gst" value="<?php echo set_value('gst', $data->gst) ?>">
        </div>
        <div class="col-sm-6">
            <label>Product Image (Please leave blank if you donot want to change image)</label>
            <input type="file" name="img">
        </div>
        <div class="col-sm-6">
            <label>Show on Registration Form ?</label>
            <input type="checkbox" value="Yes" name="join_form" <?php if ($data->show_on_regform == "Yes") {
                echo 'checked';
            } ?>> Yes
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#commission">Add
                Commission
            </button>
        </div>
    </div>
</div>
<?php if (config_item('fix_income') == 'Yes') { ?>
    <div class="alert alert-danger">
        <strong>Warning !</strong> You have enabled "Give Fix Income" option at Advance Setting section of Business
        Setting. This means, product/service based income setting will not work now. So Income Setting is disabled
        Here..
    </div>
<?php } else { ?>
    <div class="row">
        <!--- COMMISSION PART ----->
        <div class="form-group collapse" id="commission">
            <p><span style="color: #90111A">(Please leave unnecessary fields blank)</span>
            </p>
            <div class="col-sm-6">
                <label>Direct Income (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" name="direct_income"
                       value="<?php echo set_value('direct_income', $data->direct_income) ?>">
            </div>
            <div class="col-sm-6">
                <label>Level Income (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" placeholder="Comma separate each level income. eg: 12,3,4"
                       name="level_income" value="<?php echo set_value('level_income', $data->level_income) ?>">
            </div>
            <div class="col-sm-6">
                <label>Matching Income (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" name="matching_income"
                       value="<?php echo set_value('matching_income', $data->matching_income) ?>">
            </div>
            <div class="col-sm-6">
                <label>Capping Amount (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" name="capping"
                       value="<?php echo set_value('capping', $data->capping) ?>">
            </div>
            <div class="col-sm-6">
                <label>ROI (In <?php echo config_item('currency') ?>)</label>
                <input type="text" class="form-control" placeholder="Return of Investment"
                       value="<?php echo set_value('roi', $data->roi) ?>" name="roi">
            </div>
            <div class="col-sm-6">
                <label>ROI Frequency (In Days)</label>
                <input type="number" class="form-control" placeholder="How frequently you'll pay ROI" name="roi_frequency"
                       value="<?php echo set_value('roi_frequency', $data->roi_frequency) ?>">
            </div>
            <div class="col-sm-6">
                <label>ROI Limit (In Number)</label>
                <input type="number" class="form-control" placeholder="How many time you'll pay ROI ?" name="roi_limit"
                       value="<?php echo set_value('roi_limit', $data->roi_limit) ?>">
            </div>
            <div class="col-sm-6">
                <label>Selling Status</label>
                <select name="status" class="form-control">
                    <option><?php echo $data->status ?></option>
                    <option>Selling</option>
                    <option>Not-Selling</option>
                </select>
            </div>
            <!--- END ----------------->
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-sm-12"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>