<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open() ?>
<div class="alert alert-info">Paypal Setting</div>
<div class="row">
    <div class="col-sm-6">
        <input type="checkbox" value="Yes"
               name="enable_paypal" <?php if (config_item('enable_paypal') == "Yes") echo 'checked'; ?>> Enable Paypal ?
        <label>Paypal Currency (All product prices will be using this currency)</label>
        <select name="paypal_currency" class="form-control">
            <option selected
                    value="<?php echo set_value('paypal_currency', config_item('paypal_currency')) ?>"><?php echo set_value('paypal_currency', config_item('paypal_currency')) ?></option>
            <option>AUD</option>
            <option>BRL</option>
            <option>CAD</option>
            <option>DKK</option>
            <option>EUR</option>
            <option>HKD</option>
            <option>HUF</option>
            <option>ILS</option>
            <option>JPY</option>
            <option>MYR</option>
            <option>MXN</option>
            <option>NOK</option>
            <option>NZD</option>
            <option>PHP</option>
            <option>PLN</option>
            <option>GBP</option>
            <option>RUB</option>
            <option>SGD</option>
            <option>SEK</option>
            <option>CHF</option>
            <option>TWD</option>
            <option>THB</option>
            <option>USD</option>
        </select>
    </div>
    <div class="col-sm-6">
        <br/>
        <label>(Paypal Email Address)</label>
        <input type="text" value="<?php echo set_value('paypal_email', config_item('paypal_email')) ?>"
               placeholder="Paypal Email ID" class="form-control" name="paypal_email">
    </div>
</div><p>&nbsp;</p>
<div class="alert alert-warning">Instamojo Setting (Need Instamojo Account ? Contact Us)</div>
<div class="row">
    <div class="col-sm-12">
        <input type="checkbox" value="Yes"
               name="enable_instamojo" <?php if (config_item('enable_instamojo') == "Yes") echo 'checked'; ?>> Enable
        Instamojo
        ?
        <div class="row">
            <div class="col-sm-6">
                <label>Private API Key</label>
                <input value="<?php echo set_value('instamojo_api_key', config_item('instamojo_api_key')) ?>"
                       type="text" placeholder="Private API Key" class="form-control" name="instamojo_api_key">
            </div>
            <div class="col-sm-6">
                <label>Private Auth Token</label>
                <input type="text" value="<?php echo set_value('instamojo_auth', config_item('instamojo_auth')) ?>"
                       placeholder="Private Auth Token" class="form-control" name="instamojo_auth">
            </div>
            <div class="col-sm-6">
                <label>Private Salt</label>
                <input type="text" value="<?php echo set_value('instamojo_salt', config_item('instamojo_salt')) ?>"
                       placeholder="Private Salt" class="form-control" name="instamojo_salt">
            </div>
        </div>
    </div>
</div><p>&nbsp;</p>
<div class="alert alert-info">PayuMoney Setting</div>
<div class="row">
    <div class="col-sm-12">
        <input type="checkbox" value="Yes"
               name="enable_payumoney" <?php if (config_item('enable_payumoney') == "Yes") echo 'checked'; ?>> Enable
        PayuMoney
        ?
        <div class="row">
            <div class="col-sm-6">
                <label>Merchant key</label>
                <input type="text" value="<?php echo set_value('payumoney_key', config_item('payumoney_key')) ?>"
                       placeholder="Merchant key" class="form-control" name="payumoney_key">
            </div>
            <div class="col-sm-6">
                <label>Merchant Salt</label>
                <input type="text" value="<?php echo set_value('payumoney_salt', config_item('payumoney_salt')) ?>"
                       placeholder="Private Auth Token" class="form-control" name="payumoney_salt">
            </div>
        </div>
    </div>
</div><p>&nbsp;</p>
<div class="alert alert-info">Block.io (BITCOIN, DOGECOIN, OR LITECOIN)</div>
<div class="row">
    <div class="col-sm-12">
        <input type="checkbox" value="Yes"
               name="enable_block_io" <?php if (config_item('enable_block_io') == "Yes") echo 'checked'; ?>> Enable
        Block.io
        ?
        <div class="row">
            <div class="col-sm-6">
                <label>API KEY FOR BITCOIN, DOGECOIN, OR LITECOIN</label>
                <input type="text" value="<?php echo set_value('api_key', config_item('api_key')) ?>"
                       placeholder="API key" class="form-control" name="api_key">
            </div>
            <div class="col-sm-6">
                <label>Secret PIN</label>
                <input type="password" value="<?php echo set_value('secret_pin', config_item('secret_pin')) ?>"
                       placeholder="Secret PIN" class="form-control" name="secret_pin">
            </div>
        </div>
    </div>
</div><p>&nbsp;</p>
<div class="alert alert-info">Coin Payments</div>
<div class="row">
    <div class="col-sm-12">
        <input type="checkbox" value="Yes"
               name="enable_block_io" <?php if (config_item('enable_coinpayments') == "Yes") echo 'checked'; ?>> Enable
        CoinPayments.net ?
        <div class="row">
            <div class="col-sm-6">
                <label>Public Key</label>
                <input type="text" value="<?php echo set_value('pub_key', config_item('pub_key')) ?>"
                       placeholder="Public key" class="form-control" name="pub_key">
            </div>
            <div class="col-sm-6">
                <label>Private Key</label>
                <input type="text" value="<?php echo set_value('private_key', config_item('private_key')) ?>"
                       placeholder="Private PIN" class="form-control" name="private_key">
            </div>
            <div class="col-sm-6">
                <label>Merchant Id</label>
                <input type="text" value="<?php echo set_value('mrcnt_id', config_item('mrcnt_id')) ?>"
                       placeholder="Merchant Id" class="form-control" name="mrcnt_id">
            </div> <div class="col-sm-6">
                <label>Secret Code</label>
                <input type="text" value="<?php echo set_value('mrcnt_id', config_item('secret')) ?>"
                       placeholder="Secret Code" class="form-control" name="secret">
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6"><br/>
    <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
</div>
<?php echo form_close() ?>
</div>