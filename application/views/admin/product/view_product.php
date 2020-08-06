<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="row view">
    <div class="col-sm-6"><strong>Product Name: </strong> <?php echo $data->prod_name ?></div>
    <div class="col-sm-6"><strong>Member Price: </strong> <?php echo config_item('currency') . $data->prod_price ?>
    </div>
    <div class="col-sm-6"><strong>Dealer/Franchisee
            Price: </strong> <?php echo config_item('currency') . $data->dealer_price ?></div>
    <div class="col-sm-6"><strong>BV/PV: </strong> <?php echo $data->pv ?></div>
    <div class="col-sm-6"><strong>GST / Tax: </strong> <?php echo $data->gst ?></div>
    <div class="col-sm-6"><strong>Available Qty: </strong> <?php echo $data->qty ?></div>
</div><p class="hr_divider">&nbsp;</p>
<div class="row view">
    <div class="col-sm-12"><strong>Product Detail: </strong> <?php echo $data->prod_desc ?></div>
</div><p class="hr_divider">&nbsp;</p>
<div class="row view">
    <div class="col-sm-6"><strong>Direct Referral Income: </strong> <?php echo $data->direct_income ?></div>
    <div class="col-sm-6"><strong>Level Incomes: </strong> <?php echo $data->level_income ?></div>
    <div class="col-sm-6"><strong>Matching Incomes: </strong> <?php echo $data->matching_income ?></div>
    <div class="col-sm-6"><strong>Matching Income Capping: </strong> <?php echo $data->capping ?></div>
    <div class="col-sm-6"><strong>ROI Income: </strong> <?php echo $data->roi ?></div>
    <div class="col-sm-6"><strong>ROI payout frequency: </strong> Every <?php echo $data->roi_frequency ?> days</div>
    <div class="col-sm-6"><strong>ROI Validity Limit: </strong> <?php echo $data->roi_limit ?> days</div>
    <div class="col-sm-6"><strong>ROI Validity Limit: </strong> <?php echo $data->roi_limit ?> days</div>
    <div class="col-sm-6"><strong>Total Sold: </strong> <?php echo $data->sold_qty ?> qty</div>
    <div class="col-sm-6"><strong>Selling Status: </strong> <?php echo $data->status ?></div>
</div>
<div align="center">
    <img src="<?php echo $data->image ? base_url('uploads/' . $data->image) : base_url('uploads/default.jpg'); ?>"
         class="img-responsive img-rounded" style="max-width: 600px">
</div>