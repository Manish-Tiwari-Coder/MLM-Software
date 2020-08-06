<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="col-sm-2"></div>
<div class="col-sm-8" style="background-color: #fff; padding: 50px">
    <ul class="nav nav-pills" style="font-weight: 900">
        <li class="active"><a data-toggle="tab" href="#mobile"><span class="fa fa-mobile-phone"></span> Mobile</a></li>
        <li><a data-toggle="tab" href="#dth"><span class="fa fa-umbrella"></span> DTH</a></li>
    </ul>

    <div class="tab-content">
        <div id="mobile" class="tab-pane fade in active">
            <p>
                <?php echo form_open('recharge/recharge/mobile') ?>
                <label>Enter Mobile No</label>
                <input type="text" name="mno" class="form-control">
                <label>Recharge Amount</label>
                <input type="text" name="amount" class="form-control">
                <label>Select Operator</label>
                <select name="operator" class="form-control">
                    <option value="">Airtel</option>
                    <option value="">Aircel</option>
                    <option value="">BSNL</option>
                    <option value="">Idea</option>
                    <option value="">Jio</option>
                    <option value="">MTNL Delhi</option>
                    <option value="">MTNL Mumbai</option>
                    <option value="">MTS</option>
                    <option value="">Reliance</option>
                    <option value="">T24</option>
                    <option value="">Tata Indicom</option>
                    <option value="">Tata Docomo CDMA</option>
                    <option value="">Tata Docomo GSM</option>
                    <option value="">Tata Walky</option>
                    <option value="">Telenor</option>
                    <option value="">Vodafone</option>
                </select>
                <label>Circle</label>
                <select name="circle" class="form-control">
                    <option value="1">Delhi/NCR</option>
                    <option value="2">Mumbai</option>
                    <option value="3">Kolkata</option>
                    <option value="4">Maharashtra</option>
                    <option value="5">Andhra Pradesh</option>
                    <option value="6">Tamil Nadu</option>
                    <option value="7">Karnataka</option>
                    <option value="8">Gujarat</option>
                    <option value="9">Uttar Pradesh (E)</option>
                    <option value="10">Madhya Pradesh</option>
                    <option value="11">Uttar Pradesh (W)</option>
                    <option value="12">West Bengal</option>
                    <option value="13">Rajasthan</option>
                    <option value="14">Kerala</option>
                    <option value="15">Punjab</option>
                    <option value="16">Haryana</option>
                    <option value="17">Bihar & Jharkhand</option>
                    <option value="18">Orissa</option>
                    <option value="19">Assam</option>
                    <option value="20">North East</option>
                    <option value="21">Himachal Pradesh</option>
                    <option value="22">Jammu & Kashmir</option>
                    <option value="23">Chennai</option>
                </select><br/>
                <button type="submit" class="btn btn-primary">Recharge</button>
                <?php echo form_close() ?>
            </p>
        </div>
        <div id="dth" class="tab-pane fade">
            <p>
                <?php echo form_open('recharge/recharge/dth') ?>
                <label>Enter Subscriber No</label>
                <input type="text" name="sub_no" class="form-control">
                <label>Recharge Amount</label>
                <input type="text" name="amount" class="form-control">
                <label>Select Operator</label>
                <select name="operator" class="form-control">
                    <option value="28">VIDEOCON DTH</option>
                    <option value="26">SUN DTH</option>
                    <option value="24">BIG TV DTH</option>
                    <option value="27">TATA SKY DTH</option>
                    <option value="23">AIRTEL DTH</option>
                    <option value="25">DISH DTH</option>
                </select>
                <br/>
                <button type="submit" class="btn btn-primary">Recharge</button>
                <?php echo form_close() ?>
            </p>
        </div>
    </div>
</div>
<div class="col-sm-2"></div>



