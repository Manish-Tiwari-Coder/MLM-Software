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

<div class="col-sm-6">
    <h3>
        <strong style="color: #0cc745">Available Wallet Balance:
            <?php echo config_item('currency') . $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id)) ?></strong>
    </h3>
    <hr/>
    <?php if (config_item('enable_epin') == "Yes") { ?>
        <div>
            <label>Enter e-PIN to redeem:</label>
            <input type="text" name="epin" class="form-control">
        </div>
        <h2>Or</h2>
    <?php } ?>
    <?php if (config_item('enable_pg') == "Yes") { ?>
        <div>
            <label>Enter Amount to Fund your wallet:</label>
            <br/>
            <input type="text" name="amount" class="form-control"><br/>
        </div>
        <?php
        $this->load->config('pg');
        if (config_item('enable_coinpayments') == "Yes") {
            ?>
            <label>Select Coin</label>
            <select class="form-control" name="coin_wallet">
                <option value="BTC">Bitcoin</option>
                <option value="XRP">Ripple</option>
                <option value="ETH">Ethereum</option>
                <option value="BCH">Bitcoin Cash</option>
                <option value="LTC">Litecoin</option>
            </select>
            <?php
        }
        ?>
    <?php } ?><br/>
    <button class="btn btn-success" name="submit" value="add">Proceed &rarr;</button><br/>
    <br/>
    <?php if ($address) {
        ?>
        <div class="row">
            <div class="col-sm-12 shadow" style="background-color: #fff; text-align: center">
                <!--                <div class="alert alert-info">Please make payment of -->
                <?php //echo trim($this->input->post('amount')) ?><!--.</div>-->
                <h3><?php echo $address ?></h3>

                <div align="center">
                    <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?php echo $address ?>">
                </div>
                <strong>Destination Tag (for Ripple, Monero etc): </strong> <?php echo $dest_tag ?>
                <p>&nbsp;
                <hr/>
                </p>
                <p>*Your payment might take few minutes to an hour to reflect in your account.</p>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<?php echo form_close() ?>

