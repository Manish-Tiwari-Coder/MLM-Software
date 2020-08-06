<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Gateway extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->config('pg');
    }

    public function registration_form()
    {
        $layout['layout'] = "pg_gateway.php";
        $this->load->view('theme/default/base', $layout);
    }


    public function coinpayment_success()
    {
        $this->session->set_userdata('_status_', 'Paid');
        $data = array(
            'userid'         => $this->session->_user_id_,
            'amount'         => $this->session->_price_,
            'gateway'        => 'Coinpayments.net',
            'time'           => time(),
            'transaction_id' => htmlentities($_REQUEST['txn_id']),
        );
        $this->db->insert('transaction', $data);

        if ($this->session->_type_ == "userid") {
            $array = array('topup' => $this->session->_price_);
            $this->db->where('id', $this->session->_user_id_);
            $this->db->update('member', $array);
        }
        else {
            $data = array(
                'userid'         => $this->session->_user_id_,
                'amount'         => config_item('currency') . $this->session->_price_ . "/Payment Status Unknown",
                'gateway'        => 'Block.io',
                'time'           => time(),
                'transaction_id' => "Paid to Wallet: " . $address,
            );

            $this->db->insert('transaction', $data);
        }
        redirect(site_url('gateway/status/block_io'));
    }


    public function status_block_io($address)
    {
        $apiKey   = config_item('api_key');
        $version  = 2; // API version
        $pin      = config_item('secret_pin');
        $block_io = new BlockIo($apiKey, $pin, $version);
        $balance  = json_encode($block_io->get_address_balance(array('addresses' => $address)));
        $balance  = json_decode($balance, true);

        $balance = $balance['data']['available_balance'] + $balance['data']['pending_received_balance'];
        if ($balance >= $this->common_model->curl("https://blockchain.info/tobtc?currency=" . trim(config_item('iso_currency')) . "&value=" . $this->session->_price_ . "")) {
            $this->session->set_userdata('_status_', 'Paid');
            $data = array(
                'userid'         => $this->session->_user_id_,
                'amount'         => $this->session->_price_,
                'gateway'        => 'Block.io',
                'time'           => time(),
                'transaction_id' => $address,
            );
            $this->db->insert('transaction', $data);

            if ($this->session->_type_ == "userid") {
                $array = array('topup' => $this->session->_price_);
                $this->db->where('id', $this->session->_user_id_);
                $this->db->update('member', $array);
            }

        }
        else {
            $data = array(
                'userid'         => $this->session->_user_id_,
                'amount'         => config_item('currency') . $this->session->_price_ . "/Payment Status Unknown",
                'gateway'        => 'Block.io',
                'time'           => time(),
                'transaction_id' => "Paid to Wallet: " . $address,
            );
            $this->db->insert('transaction', $data);
        }
        redirect(site_url('gateway/status/block_io'));
    }

    public function paypal_ipn($type)
    {
        if ($_REQUEST['payment_status'] == "Completed") {
            $amount = $this->common_model->filter($_REQUEST['mc_gross'], 'float');
            $userid = htmlentities($_REQUEST['invoice']); // userid or order id.
            $data   = array(
                'userid'         => $userid,
                'amount'         => $amount,
                'gateway'        => 'PayPal',
                'time'           => time(),
                'transaction_id' => $_REQUEST['txn_id'],
            );
            $this->db->insert('transaction', $data);
            if ($type == "userid") {
                $array = array('topup' => $amount);
                $this->db->where('id', $userid);
                $this->db->update('member', $array);
            }
        }
    }

    public function instamojo_ipn($type)
    {
        $data         = $_POST;
        $mac_provided = $data['mac']; // Get the MAC from the POST data
        unset($data['mac']); // Remove the MAC key from the data.
        $ver   = explode('.', phpversion());
        $major = (int)$ver[0];
        $minor = (int)$ver[1];
        if ($major >= 5 and $minor >= 4) {
            ksort($data, SORT_STRING | SORT_FLAG_CASE);
        }
        else {
            uksort($data, 'strcasecmp');
        }
        $mac_calculated = hash_hmac("sha1", implode("|", $data), config_item('instamojo_salt'));
        if ($mac_provided == $mac_calculated) {
            $payment_id = $data['payment_id'];
            $amount     = $data['amount'];
            if ($data['status'] == "Credit") {
                $data = array(
                    'userid'         => $data['purpose'],
                    'amount'         => $amount,
                    'gateway'        => 'Instamojo',
                    'time'           => time(),
                    'transaction_id' => $payment_id,
                );
                $this->db->insert('transaction', $data);
                if ($type == "userid") {
                    $array = array('topup' => $amount);
                    $this->db->where('id', $data['purpose']);
                    $this->db->update('member', $array);
                }
            }
        }
    }

    public function status($pg)
    {
        switch ($pg) {
            case ($pg == "block_io"):
                break;
            case ($pg == "paypal"):
                break;
            case ($pg == "instamojo"):
                break;
            case ($pg == "payumoney"):
                $status = $this->input->post('status');

                if ($status == 'success') {
                    $txnid       = $this->input->post('txnid');
                    $amount      = $this->input->post('amount');
                    $productinfo = $this->input->post('productinfo');
                    $firstname   = $this->input->post('firstname');
                    $hash        = $this->input->post('hash');
                    $email       = $this->input->post('email');
                    $udf1        = $this->input->post('udf1');
                    $udf2        = $this->input->post('udf2');
                    $udf3        = $this->input->post('udf3');
                    $udf4        = $this->input->post('udf4');
                    $udf5        = $this->input->post('udf5');
                    $key         = $this->input->post('key');


                    $SALT = config_item('payumoney_salt');


                    If (isset($_POST["additionalCharges"])) {
                        $additionalCharges = $_POST["additionalCharges"];
                        $retHashSeq        = $additionalCharges . '|' . $SALT . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
                    }
                    else {
                        $retHashSeq = $SALT . '|' . $status . '|||||||||||' . $udf5 . '|' . $udf4 . '|' . $udf3 . '|' . $udf2 . '|' . $udf1 . '|' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;

                    }

                    $rethash = hash("sha512", $retHashSeq);


                    if ($rethash != $hash) {
                        $status = 'UnPaid';
                    }
                    else {
                        $status = 'Paid';
                        $data   = array(
                            'userid'         => $txnid,
                            'amount'         => $amount,
                            'gateway'        => 'Instamojo',
                            'time'           => time(),
                            'transaction_id' => $txnid,
                        );
                        $this->db->insert('transaction', $data);
                        if ($this->session->_type_ == "userid") {
                            $array = array('topup' => $amount);
                            $this->db->where('id', $txnid);
                            $this->db->update('member', $array);
                        }
                    }
                }
                break;
        }
        $amount = $this->db_model->select('amount', 'transaction', array(
            'userid' => $this->session->_user_id_,
            'time >' => (time() - 60),
        ));
        if ((float)$amount >= (float)$this->session->_price_) {
            $this->session->set_userdata('_status_', 'Paid');
        }
        else {
            $this->session->set_userdata('_status_', 'UnPaid');
        }
        if ($this->session->_type_ == "userid") {

            $get_topup = $this->db_model->select('topup', 'member', array('id' => $this->session->_user_id_));

            if ($get_topup > 0) {
                $status = 'Paid';
            }
            else {
                $status = 'UnPaid';
            }

        }
        else {
            $status = $this->session->_status_;
        }

        if ($this->session->_type_ == "userid" && $status == "Paid") {
            redirect(site_url('cron/complete_registration'));
        }
        else if ($this->session->_type_ == "userid" && $status !== "Paid") {
            redirect(site_url('site/failed_registration'));
        }
        else if ($this->session->_type_ == "wallet" && $status !== "Paid") {
            redirect(site_url('member/failed_fund'));
        }
        else if ($this->session->_type_ == "wallet" && $status == "Paid") {
            redirect(site_url('member/complete_add_fund'));
        }
        else {
            redirect(site_url('site/failed_registration'));
        }
    }

    public function block_io_start()
    {

        $apiKey   = config_item('api_key');
        $version  = 2; // API version
        $pin      = config_item('secret_pin');
        $block_io = new BlockIo($apiKey, $pin, $version);
        $network  = json_encode($block_io->get_current_price(array()));
        $network  = json_decode($network, true);
        if (trim(config_item('iso_currency')) !== "XBT" && trim(config_item('iso_currency')) !== "BTC") {
            $url      = "https://blockchain.info/tobtc?currency=" . trim(config_item('iso_currency')) . "&value=" . $this->session->_price_ . "";
            $btc_rate = $this->common_model->curl($url) . " " . $network['data']['network'];
        }
        else {
            $btc_rate = $this->session->_price_ . " " . $network['data']['network'];;
        }
        $data = json_encode($block_io->get_new_address());
        $data = json_decode($data, true);
        echo '<html><head><link rel="stylesheet" type="text/css" 
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="' . base_url('axxets/qrcode.js') . '"></script>
</head><body>';
        echo '<div align="center"><span class="alert alert-info">Please send ' . $btc_rate . '</span></div>';
        echo '<h2 align="center">Please Make Payment to the below Address: </h2>';
        echo '<div class="row"><div class="col-sm-3"></div><div class="col-sm-6"><h3 align="center" style="background-color: #1b8edb;
 padding: 
20px;
 color:#fff; margin:10px">
' . $data['data']['address'] . '</h3></div><div class="col-sm-3"></div></div>';
        echo '<br/><div id="qrcode" align="center"></div>
<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
	text: "' . $data['data']['address'] . '",
	width: 150,
	height: 150,
	colorDark : "#000000",
	colorLight : "#ffffff",
	correctLevel : QRCode.CorrectLevel.H
});
</script>';
        echo '<p>&nbsp;</p><p>&nbsp;</p><div align="center">Please click on "Payment Made button after making the payment, else your payment will loose."<br/><p>&nbsp;</p><a href="' . site_url('gateway/status_block_io/' . $data['data']['address'] . '') . '" 
class="btn btn-success">Payment Made</a> <a class="btn btn-danger" href="' . site_url('gateway/status/block_io') . '">Cancel</a></div>';
        echo '</body></html>';


    }

    public function instamojo_start()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-Api-Key:" . config_item('instamojo_api_key') . "",
            "X-Auth-Token:" . config_item('instamojo_auth') . "",
        ));
        $payload = Array(
            'purpose'                 => $this->session->_user_id_,
            'amount'                  => $this->session->_price_,
            'phone'                   => $this->session->_phone_,
            'buyer_name'              => $this->session->_user_name_,
            'redirect_url'            => site_url('gateway/status/instamojo'),
            'webhook'                 => site_url('gateway/instamojo_ipn/' . $this->session->_type_),
            'send_email'              => false,
            'send_sms'                => false,
            'email'                   => $this->session->_email_,
            'allow_repeated_payments' => false,
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);


        $data = json_decode($response, true);
        $site = $data["payment_request"]["longurl"];

        if ($site == "") {
            echo '<p>&nbsp;</p><p>&nbsp;</p><div align="center">There are some erros with payment gateway. Please check whether you have filled phone no and email id or not. <a class="btn btn-danger" href="' . site_url('gateway/status/block_io') . '">Cancel</a></div>';

        }
        header('HTTP/1.1 301 Moved Permanently');
        header('Location:' . $site);
    }

}
