<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without
 * permission. Project Developer: Bidush Sarkar Developed for: Exolim IT Services
 * Pvt Ltd
 **************************************************************************************************/
?>
<div class="alert alert-danger">
    <strong>Warning !</strong> Please donot change any setting here until and unless you know what you are doing. Please
    take support team or developer advice before making any changes at live site.
</div>
<div class="row">
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Company Name</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('company_name', config_item('company_name')) ?>" name="company_name">
    </div>
    <div class="col-sm-6">
        <label>Company Address</label>
        <textarea class="form-control"
                  value="<?php echo set_value('company_address', config_item('company_address')) ?>"
                  name="company_address"></textarea>
    </div>
    <div class="col-sm-6">
        <label>ID Prefix</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('id_ext', config_item('ID_EXT')) ?>"
               name="id_ext">
    </div>
    <div class="col-sm-6">
        <label>Currency Sign</label>
        <input type="text" class="form-control" value="<?php echo set_value('currency', config_item('currency')) ?>"
               name="currency">
    </div>
    <div class="col-sm-6">
        <label>Currency ISO Code (3 Character)</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('iso_currency', config_item('iso_currency')) ?>"
               name="iso_currency">
    </div>
    <div class="col-sm-6">
        <label>How Many Leg to Show in Tree ?</label>
        <select class="form-control" name="leg">
            <option selected><?php echo set_value('leg', config_item('leg')) ?></option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to show Leg Select Option at Sign Up form ?</label>
        <select class="form-control" name="show_leg_choose">
            <option selected><?php echo set_value('show_leg_choose', config_item('show_leg_choose')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to show Placement ID Option at Sign Up form ?</label>
        <select class="form-control" name="show_placement_id">
            <option selected><?php echo set_value('show_placement_id', config_item('show_placement_id')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Is this autopool Registration ?</label>
        <select class="form-control" name="autopool_registration">
            <option selected><?php echo set_value('autopool_registration', config_item('autopool_registration')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to show Joining Products at Registration form ?</label>
        <select class="form-control" name="show_join_product">
            <option selected><?php echo set_value('show_join_product', config_item('show_join_product')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to enable e-PIN ?</label>
        <select class="form-control" name="enable_epin">
            <option selected><?php echo set_value('enable_epin', config_item('enable_epin')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to enable Payment Gateway ?</label>
        <select class="form-control" name="enable_pg">
            <option selected><?php echo set_value('enable_pg', config_item('enable_pg')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Is registration is free ?</label>
        <select class="form-control" name="free_registration">
            <option selected><?php echo set_value('free_registration', config_item('free_registration')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to enable Top-Up Options ?</label>
        <select class="form-control" name="enable_topup">
            <option selected><?php echo set_value('enable_topup', config_item('enable_topup')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to Give Income when Top-Up ?</label>
        <select class="form-control" name="give_income_on_topup">
            <option selected><?php echo set_value('give_income_on_topup', config_item('give_income_on_topup')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Gap Commission on Repurchase ?</label>
        <select class="form-control" name="enable_gap_commission">
            <option selected><?php echo set_value('enable_gap_commission', config_item('enable_gap_commission')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Want to send SMS on Registration ?</label>
        <select class="form-control" name="sms_on_join">
            <option selected><?php echo set_value('sms_on_join', config_item('sms_on_join')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Automatically mark registration products as Delivered ?</label>
        <select class="form-control" name="prevent_join_product_entry">
            <option selected
                    value="<?php echo set_value('prevent_join_product_entry', config_item('prevent_join_product_entry')) ?>"><?php echo set_value('prevent_join_product_entry', config_item('prevent_join_product_entry')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>SMS API
            <div style="font-size: 12px">(Format: https://apiurl.com?no={{phone}}&msg={{msg}}&other_parameters.)</div>
        </label>
        <input type="text" class="form-control" value="<?php echo set_value('sms_api', config_item('sms_api')) ?>"
               name="sms_api">
    </div>
    <div class="col-sm-6">
        <label>Stop New Member Registration ?</label>
        <select class="form-control" name="disable_registration">
            <option selected
                    value="<?php echo set_value('disable_registration', config_item('disable_registration')) ?>"><?php echo set_value('disable_registration', config_item('disable_registration')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Give Fix Income (Not Product/Service Based Income)</label>
        <select class="form-control" name="fix_income">
            <option selected
                    value="<?php echo set_value('fix_income', config_item('fix_income')) ?>"><?php echo set_value('fix_income', config_item('fix_income')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
</div>
<hr/>
<h2 align="center">Enable / Disable Module</h2>
<div class="row">
    <div class="col-sm-6">
        <label>Enable Repurchase System ?</label>
        <select class="form-control" name="enable_repurchase">
            <option selected
                    value="<?php echo set_value('enable_repurchase', config_item('enable_repurchase')) ?>"><?php echo set_value('enable_repurchase', config_item('enable_repurchase')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Coupon ?</label>
        <select class="form-control" name="enable_coupon">
            <option selected
                    value="<?php echo set_value('enable_coupon', config_item('enable_coupon')) ?>"><?php echo set_value('enable_coupon', config_item('enable_coupon')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Advertisement Income ?</label>
        <select class="form-control" name="enable_ad_incm">
            <option selected
                    value="<?php echo set_value('enable_ad_incm', config_item('enable_ad_incm')) ?>"><?php echo set_value('enable_ad_incm', config_item('enable_ad_incm')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Survey ?</label>
        <select class="form-control" name="enable_survey">
            <option selected
                    value="<?php echo set_value('enable_survey', config_item('enable_survey')) ?>"><?php echo set_value('enable_survey', config_item('enable_survey')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Recharge Module ?</label>
        <select class="form-control" name="enable_recharge">
            <option selected
                    value="<?php echo set_value('enable_recharge', config_item('enable_recharge')) ?>"><?php echo set_value('enable_recharge', config_item('enable_recharge')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Rewards ?</label>
        <select class="form-control" name="enable_reward">
            <option selected
                    value="<?php echo set_value('enable_reward', config_item('enable_reward')) ?>"><?php echo set_value('enable_reward', config_item('enable_reward')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Product & Services ?</label>
        <select class="form-control" name="enable_product">
            <option selected
                    value="<?php echo set_value('enable_product', config_item('enable_product')) ?>"><?php echo set_value('enable_product', config_item('enable_product')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Help Plan ?</label>
        <select class="form-control" name="enable_help_plan">
            <option selected
                    value="<?php echo set_value('enable_help_plan', config_item('enable_help_plan')) ?>"><?php echo set_value('enable_help_plan', config_item('enable_help_plan')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Enable Investment Plan ?</label>
        <select class="form-control" name="enable_investment">
            <option selected
                    value="<?php echo set_value('enable_investment', config_item('enable_investment')) ?>"><?php echo set_value('enable_investment', config_item('enable_investment')) ?></option>
            <option>Yes</option>
            <option>No</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Investment Type ?</label>
        <select class="form-control" name="investment_mode">
            <option selected
                    value="<?php echo set_value('investment_mode', config_item('investment_mode')) ?>"><?php echo set_value('investment_mode', config_item('investment_mode')) ?></option>
            <option>AUTO</option>
            <option>EPIN</option>
            <option>MANUAL</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Developer Password</label> (This is not admin password)
        <input type="password" class="form-control" name="dev_pass">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update"
               onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>