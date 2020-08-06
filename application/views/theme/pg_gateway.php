<h3 align="center" style="color: #0d638f">Please Select your Preferred Gateway to pay online !</h3>
<div class="container">
    <?php echo $this->session->flashdata('site_flash') ?>
    <div class="row">
        Dear <?php echo $this->session->_user_name_ ?>,<br/>
        Please follow the below steps &rarr;
        <hr/>
        <div align="center"><i class="fa fa-expeditedssl" style="font-size: 100px"></i></div>
        <div class="panel-group" id="accordion">
            <?php
            if (config_item('enable_paypal') == "Yes"):
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                Pay With Paypal &rarr;</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse in">
                        <div class="panel-body">The Easiest and safest way to pay online<br/>
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="business" value="<?php echo config_item('paypal_email') ?>">
                                <input type="hidden" name="item_name"
                                       value="<?php echo $this->db_model->select('prod_name', 'product', array('id' => $this->session->_product_)); ?>">
                                <input type="hidden" name="item_number" value="<?php echo $this->session->_product_ ?>">
                                <input type="hidden" name="invoice" value="<?php echo $this->session->_inv_id_ ?>">
                                <input type="hidden" name="amount" value="<?php echo $this->session->_price_ ?>">
                                <input type="hidden" name="first_name"
                                       value="<?php echo $this->session->_user_name_ ?>">
                                <input type="hidden" name="address1" value="<?php echo $this->session->_address_ ?>">
                                <input type="hidden" name="night_phone_a" value="<?php echo $this->session->_phone_ ?>">
                                <input type="hidden" name="notify_url"
                                       value="<?php echo site_url('gateway/paypal_ipn/' . $this->session->_type_) ?>">
                                <input type="hidden" name="cancel_return"
                                       value="<?php echo site_url('gateway/status/paypal') ?>">
                                <input type="hidden" name="return"
                                       value="<?php echo site_url('gateway/status/paypal') ?>">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="currency_code"
                                       value="<?php echo config_item('paypal_currency') ?>">
                                <input type="hidden" name="email" value="<?php echo $this->session->_email_ ?>">
                                <button class="btn btn-primary" type="submit">Pay with Paypal &rarr;</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            endif; ?>
            <?php
            if (config_item('enable_instamojo') == "Yes"):
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                Debit Card/ Net Banking / Credit Card / Wallet - Instamojo &rarr;</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse">
                        <div class="panel-body">
                            <a href="<?php echo site_url('gateway/instamojo_start') ?>" class="btn btn-danger">Pay Now
                                &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if (config_item('enable_block_io') == "Yes"):
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                Bitcoin / Dogecoin / Litecoin - Block.io &rarr;</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <a href="<?php echo site_url('gateway/block_io_start') ?>" class="btn btn-danger">Pay Now
                                &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php
            if (config_item('enable_coinpayments') == "Yes"):
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                Cryptocurrency - coinpayments.io &rarr;</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse">
                        <div class="panel-body">
                            <form action="https://www.coinpayments.net/index.php" method="post">
                                <input type="hidden" name="cmd" value="_pay">
                                <input type="hidden" name="reset" value="1">
                                <input type="hidden" name="merchant" value="<?php echo config_item('mrcnt_id') ?>">
                                <input type="hidden" name="item_name" value="Wallet Deposit">
                                <input type="hidden" name="first_name"
                                       value="<?php echo $this->session->_user_name_ ?>">
                                <input type="hidden" name="last_name"
                                       value="<?php echo $this->session->_user_name_ ?>">
                                <input type="hidden" name="email" id="email"
                                       value="<?php echo $this->session->_email_; ?>"/>
                                <input type="hidden" name="currency" value="<?php echo config_item('iso_currency') ?>">
                                <input type="hidden" name="amountf" value="<?php echo $this->session->_price_ ?>">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="allow_quantity" value="0">
                                <input type="hidden" name="want_shipping" value="0">
                                <input type="hidden" name="success_url"
                                       value="<?php echo site_url('gateway/coinpayment_success') ?>">
                                <input type="hidden" name="cancel_url"
                                       value="<?php echo site_url('gateway/coinpayment_fail') ?>">
                                <input type="hidden" name="ipn_url"
                                       value="<?php echo site_url('gateway/coinpayment_ipn') ?>">
                                <input type="hidden" name="allow_extra" value="0">
                                <input type="image" src="https://www.coinpayments.net/images/pub/buynow-wide-blue.png"
                                       alt="Buy Now with CoinPayments.net">
                            </form>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php
            if (config_item('enable_payumoney') == "Yes"):
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                Debit Card/ Net Banking / Credit Card - PayuMoney &rarr;</a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse">
                        <div class="panel-body">
                            <form action="https://secure.payu.in/_payment" method="post">
                                <input type="hidden" name="key" value="<?php echo config_item('payumoney_key') ?>"/>
                                <input type="hidden" name="hash" value="<?php echo config_item('sdsds') ?>"/>
                                <input type="hidden" name="txnid" value="<?php echo $this->session->_user_id_ ?>"/>
                                 <input name="amount" type="hidden" value="<?php echo $this->session->_price_; ?>"/>
                                <input type="hidden" name="firstname" id="firstname"
                                       value="<?php echo $this->session->_user_name_; ?>"/>
                                <input type="hidden" name="email" id="email"
                                       value="<?php echo $this->session->_email_; ?>"/>
                                <input type="hidden" name="phone" value="<?php echo $this->session->_phone_; ?>"/>
                                <input name="productinfo" type="hidden"
                                       value="<?php echo $this->db_model->select('prod_name', 'product', array('id' => $this->session->_product_)); ?>">
                                <input type="hidden" name="surl"
                                       value="<?php echo site_url('gateway/status/payumoney') ?>"/>
                                <input type="hidden" name="furl"
                                       value="<?php echo site_url('gateway/status/payumoney') ?>"/>
                                <input type="hidden" name="service_provider" value="payu_paisa"/>
                                <input type="hidden" name="lastname" id="lastname" value=""/>
                                <button class="btn btn-primary" type="submit">Pay with PayuMoney &rarr;</button>

                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
