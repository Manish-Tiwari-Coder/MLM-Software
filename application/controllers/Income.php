<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends CI_Controller
{
    /**
     * Income Section for Admin Only
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE) {
            redirect(site_url('site/admin'));
        }
        $this->load->library('pagination');
    }

    public function view_earning()
    {
        $config['base_url']   = site_url('income/view_earning');
        $config['per_page']   = 100;
        $config['total_rows'] = $this->db_model->count_all('earning');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, userid, amount, type, ref_id, date, pair_match')->from('earning')
                 ->limit($config['per_page'], $page);

        $data['earning'] = $this->db->get()->result_array();

        $data['title']      = 'Earnings';
        $data['breadcrumb'] = 'View Earnings';
        $data['layout']     = 'income/view_earning.php';
        $this->load->view('admin/base', $data);

    }

    public function search_earning()
    {
        $data['title']      = 'Search Income';
        $data['breadcrumb'] = 'Search Income';
        $data['layout']     = 'income/search_income.php';
        $this->load->view('admin/base', $data);
    }

    public function search_rewards()
    {
        $this->db->select('id, reward_id, userid, date, status, paid_date, tid')->from('rewards');
        if (trim($this->input->post('user_id')) !== "") {
            $this->db->where('userid', $this->input->post('user_id'));
        }
        if ($this->input->post('status') !== "All") {
            $this->db->where('status', $this->input->post('status'));
        }
        if (trim($this->input->post('sdate')) !== "") {
            $this->db->where('date >=', $this->input->post('sdate'));
        }
        if (trim($this->input->post('edate')) !== "") {
            $this->db->where('date <=', $this->input->post('edate'));
        }
        $data['data']       = $this->db->get()->result();
        $data['title']      = 'Search Achieved Rewards';
        $data['breadcrumb'] = 'Search Achieved Rewards';
        $data['layout']     = 'income/list_rewards.php';
        $this->load->view('admin/base', $data);
    }

    public function reward_search_form()
    {
        $data['title']      = 'Search Achieved Rewards';
        $data['breadcrumb'] = 'Search Achieved Rewards';
        $data['layout']     = 'income/search_rewards.php';
        $this->load->view('admin/base', $data);
    }

    public function pay_rewards()
    {
        $this->db->select('id, reward_id, userid, date, status, paid_date, tid')->from('rewards');
        $this->db->where('status', 'Pending');
        $data['data']       = $this->db->get()->result();
        $data['title']      = 'Pay Achieved Rewards';
        $data['breadcrumb'] = 'Pay Achieved Rewards';
        $data['layout']     = 'income/list_rewards.php';
        $this->load->view('admin/base', $data);

    }

    public function search()
    {
        $income_name = $this->input->post('income_name');
        $userid      = $this->common_model->filter($this->input->post('userid'));
        $startdate   = $this->input->post('startdate');
        $enddate     = $this->input->post('enddate');

        $this->db->select('id, userid, amount, type, ref_id, date, pair_match')->from('earning');
        if ($income_name !== "All") {
            $this->db->where('type', $this->input->post('income_name'));
        }
        if (trim($userid) !== "") {
            $this->db->where('userid', $userid);
        }
        if (trim($startdate) !== "") {
            $this->db->where('date >=', $startdate);
        }
        if (trim($enddate) !== "") {
            $this->db->where('date <=', $enddate);
        }

        $data['earning']    = $this->db->get()->result_array();
        $data['title']      = 'Search Results';
        $data['breadcrumb'] = 'Search Earnings';
        $data['layout']     = 'income/view_earning.php';
        $this->load->view('admin/base', $data);

    }

    public function edit_earning($id)
    {
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['data']       = $this->db_model->select_multi('id, amount, date, status', 'earning', array(
                'id',
                $id,
            ));
            $data['title']      = 'Edit Earning';
            $data['breadcrumb'] = 'Edit Earning';
            $data['layout']     = 'income/edit_earning.php';
            $this->load->view('admin/base', $data);
        } else {
            $date   = $this->input->post('date');
            $status = $this->input->post('status');
            $amount = $this->common_model->filter($this->input->post('amount'), 'float');

            $data = array(
                'amount' => $amount,
                'date'   => $date,
                'status' => $status,
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('earning', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Earning Detail Updated successfully.</div>');
            redirect('income/view_earning');


        }
    }

    public function remove_earning($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('earning');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Earning Record Deleted successfully.</div>');
        redirect('income/view_earning');
    }

    public function printout_withdraw_list()
    {
        $this->db->select('userid, amount')->where('status', 'Un-Paid');
        $data = $this->db->get('withdraw_request')->result();
        echo '<html><head><link rel="stylesheet" type="text/css" 
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="' . base_url('axxets/qrcode.js') . '"></script>
</head><body>
<table class="table table-striped" style="max-width: 800px" align="center">
<tr style="background-color: #5b9bd1; color:#fff">
<td>S.N.</td>
<td>User Detail</td>
<td>Amount</td>
</tr>
';
        $sn = 1;
        foreach ($data as $e) {
            $total += $e->amount;
            echo '<tr>
<td>' . $sn++ . '</td>
<td>';
            ?>
            <?php
            echo $this->db_model->select('name', 'member', array('id' => $e->userid)) . "<br/>";
            $data = $this->db_model->select_multi('bank_ac_no, bank_name, bank_ifsc, bank_branch, btc_address, tcc_address', 'member_profile', array('userid' => $e->userid));
            echo $data->bank_name ? '<strong>Bank Name:</strong> ' . $data->bank_name . '<br/>' : '';
            echo $data->bank_ac_no ? '<strong>A/C No:</strong> ' . $data->bank_ac_no . '<br/>' : '';
            echo $data->bank_ifsc ? '<strong>IFSC:</strong> ' . $data->bank_ifsc . '<br/>' : '';
            echo $data->bank_branch ? '<strong>Bank Branch:</strong> ' . $data->bank_branch . '<br/>' : '';
            echo $data->btc_address ? '<strong>BTC Add:</strong> ' . $data->btc_address . '<br/>' : '';
            ?>
            <?php
            echo '</td><td>' . config_item('currency') . ($e->amount - ($e->amount * config_item('payout_tax') / 100)) . '</td>';
            echo '</tr>';
        }
        echo '<tr style="background-color: #5b9bd1; color:#fff">
<td></td>
<td align="right">Total Payable</td>
<td>' . config_item('currency') . number_format($total) . '</td>
</tr>';
    }

    public function make_payment()
    {
        $data['title']      = 'Make Payment';
        $data['breadcrumb'] = 'Withdrawl List';
        $data['layout']     = 'income/makepayment.php';
        $this->load->view('admin/base', $data);
    }

    public function hold_payments()
    {
        $data['title']      = 'Hold Payments';
        $data['breadcrumb'] = 'Hold Payments';
        $data['layout']     = 'income/hold_payments.php';
        $this->load->view('admin/base', $data);
    }

    public function pay()
    {
        $payid   = $this->input->post('payid');
        $tdetail = $this->input->post('tdetail');
        $amount  = $this->db_model->select_multi('userid,amount', 'withdraw_request', array('id' => $payid));

        $data = array(
            'status'    => 'Paid',
            'paid_date' => date('Y-m-d'),
            'tid'       => $tdetail,
            'tax'       => ($amount->amount * config_item('payout_tax') / 100),
        );
        $this->db->where('id', $payid);
        $this->db->update('withdraw_request', $data);

        $data = array(
            'userid'     => $amount->userid,
            'amount'     => $amount->amount,
            'payout_id'  => $payid,
            'tax_amount' => ($amount->amount * config_item('payout_tax') / 100),
            'tax_percnt' => config_item('payout_tax'),
            'date'       => date('Y-m-d'),
        );
        $this->db->insert('tax_report', $data);

        $user_data = $this->db_model->select_multi('name, phone, email', 'member', array('id' => $amount->userid));

        $this->common_model->sms($user_data->phone, 'Hi, ' . $user_data->name . ', Your payout of ' . config_item('currency') . $amount->amount . ' has been generated and paid. Please check your account. --' . config_item('company_name'));
        $this->common_model->mail($user_data->email, 'Payout Generated', 'Hi, ' . $user_data->name . ', Your payout of ' . config_item('currency') . $amount->amount . ' has been generated and paid. Please check your account. <hr/>--' . config_item('company_name'));

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Marked as Paid successfully.</div>');
        redirect('income/make_payment');
    }

    private function block_io_pay()
    {
        $apiKey   = config_item('api_key');
        $version  = 2; // API version
        $pin      = config_item('secret_pin');
        $block_io = new BlockIo($apiKey, $pin, $version);
        $this->db->select('userid,amount')->from('withdraw_request')->where('status', 'Un-Paid');
        $data  = $this->db->get()->result();
        $names = array();
        foreach ($data as $e) {
            $address = $this->db_model->select('btc_address', 'member_profile', array('userid' => $e->userid));
            if (strlen($address) > 10) {
                $wallet_add .= "," . $address;

                if (trim(config_item('iso_currency')) !== "XBT" && trim(config_item('iso_currency')) !== "BTC") {
                    $url      = "https://blockchain.info/tobtc?currency=" . trim(config_item('iso_currency')) . "&value=" . $e->amount . "";
                    $btc_rate = $this->common_model->curl($url);
                } else {
                    $btc_rate = $e->amount;
                }
                $amount .= "," . $btc_rate;
            } else {
                $names = array_merge($names, array($e->userid));
                $this->session->set_userdata('skip_autopay', 'BTC Address');
            }
        }
        if (strlen($wallet_add) > 10) {
            $wallet_add = substr($wallet_add, 1);
            $amount     = substr($amount, 1);
            $data       = json_encode($block_io->withdraw(array(
                'amounts'      => '' . $amount . '',
                'to_addresses' => '' . $wallet_add . '',
            )));
            $data       = json_decode($data, TRUE);
        }
        if ($data['status'] == "success") {
            $this->db->where_not_in('userid', $names);
            $this->db->where('status', 'Un-Paid');
            $this->db->update('withdraw_request', array('status' => 'Paid'));
            $status = "success";
        } else {
            $status = "danger";
        }

        return $status;

    }

    public function payall_gateway()
    {
        $this->load->config('pg');
        if ($this->uri->segment(3) == "accept") {
            if (config_item('payment_api') == "Block.io") {
                $return = $this->block_io_pay();
            }

            $data['title']      = 'Autopay';
            $data['breadcrumb'] = 'Autopay';
            $data['layout']     = 'income/autopay_status.php';
            $data['status']     = $return;
            $this->load->view('admin/base', $data);

        } else {
            $data['title']           = 'Make Payment';
            $data['breadcrumb']      = 'Withdrawl List';
            $data['layout']          = 'income/autopay.php';
            $data['payable_balance'] = $this->db_model->sum('amount', 'withdraw_request', array('status' => 'Un-Paid'));
            $this->load->view('admin/base', $data);
        }
    }

    public function reward_pay()
    {
        $payid   = $this->input->post('payid');
        $tdetail = $this->input->post('tdetail');

        $data = array(
            'status'    => 'Delivered',
            'paid_date' => date('Y-m-d'),
            'tid'       => $tdetail,
        );
        $this->db->where('id', $payid);
        $this->db->update('rewards', $data);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Marked as Paid successfully.</div>');
        redirect('income/pay-rewards');
    }

    public function hold($id)
    {
        $data = array(
            'status' => 'Hold',
        );
        $this->db->where('id', $id);
        $this->db->update('withdraw_request', $data);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Hold the payment  successfully.</div>');
        redirect('income/make_payment');
    }

    public function unhold($id)
    {
        $data = array(
            'status' => 'Un-Paid',
        );
        $this->db->where('id', $id);
        $this->db->update('withdraw_request', $data);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Un-Hold the payment  successfully.</div>');
        redirect('income/make_payment');
    }

    public function unpay($id)
    {
        $data = array(
            'status' => 'Un-Paid',
        );
        $this->db->where('id', $id);
        $this->db->update('withdraw_request', $data);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Un-Paid the payment  successfully.</div>');
        redirect('income/make_payment');
    }

    public function remove($id)
    {
        $get_fund_uid    = $this->db_model->select_multi('userid,amount', 'withdraw_request', array('id' => $id));
        $get_old_balance = $this->db_model->select('balance', 'wallet', array('userid' => $get_fund_uid->userid));
        $new_fund        = $get_fund_uid->amount + $get_old_balance;
        $array           = array(
            'balance' => $new_fund,
        );
        $this->db->where('userid', $get_fund_uid->userid);
        $this->db->update('wallet', $array);


        $this->db->where('id', $id);
        $this->db->delete('withdraw_request');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-warning">Removed the payment  record and refunded the balance to User Wallet successfully.</div>');
        redirect('income/make_payment');
    }

    public function reward_remove($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rewards');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-warning">Removed the reward  record successfully.</div>');
        redirect('income/search-rewards');
    }

    public function search_payout()
    {
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        $status = $this->input->post('status');
        $sdate  = $this->input->post('sdate');
        $edate  = $this->input->post('edate');
        if (trim($top_id) == ""):
            $data['title']      = 'Withdrawal Report';
            $data['breadcrumb'] = 'Withdrawal Report';
            $data['layout']     = 'income/search_payout.php';
            $this->load->view('admin/base', $data);

        else:

            redirect(site_url('income/search_payout/' . $top_id . '/' . $status . '/' . $sdate . '/' . $edate));
        endif;
    }

    public function tax_report()
    {
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        $sdate  = $this->input->post('sdate');
        $edate  = $this->input->post('edate');
        if (trim($top_id) == ""):
            $data['title']      = 'Tax Report';
            $data['breadcrumb'] = 'Tax Report';
            $data['layout']     = 'income/tax_report.php';
            $this->load->view('admin/base', $data);

        else:
            redirect(site_url('income/tax_report/' . $top_id . '/' . $sdate . '/' . $edate));
        endif;
    }

    public function flexible_income()
    {
        $this->load->model('plan_model');
        $this->form_validation->set_rules('income_name', 'Income Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('id, income_name, income_duration, amount');
            $data['result']     = $this->db->get('flexible_income')->result();
            $data['leg']        = $this->plan_model->create_leg();
            $data['title']      = 'Advance Income Setting';
            $data['breadcrumb'] = 'Advance Income Setting';
            $data['layout']     = 'setting/flexible_income.php';
            $this->load->view('admin/base', $data);
        } else {
            $income_name     = $this->input->post('income_name');
            $income_duration = $this->input->post('income_duration');
            $amount          = $this->input->post('amount');
            $based_on        = $this->input->post('based_on');

            $a = $this->input->post('A') ? $this->input->post('A') : 0;
            $b = $this->input->post('B') ? $this->input->post('B') : 0;
            $c = $this->input->post('C') ? $this->input->post('C') : 0;
            $d = $this->input->post('D') ? $this->input->post('D') : 0;
            $e = $this->input->post('E') ? $this->input->post('E') : 0;

            $array = array(
                'income_name'     => $income_name,
                'income_duration' => $income_duration,
                'amount'          => $amount,
                'based_on'        => $based_on,
                'A'               => $a,
                'B'               => $b,
                'C'               => $c,
                'D'               => $d,
                'E'               => $e,
            );
            $this->db->insert('flexible_income', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Saved Successfully</div>');
            redirect('income/flexible-income');

        }
    }

    public function set_level_wise()
    {
        $this->form_validation->set_rules('income_name', 'Income Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('id, income_name, level_no, amount');
            $data['result']     = $this->db->get('level_wise_income')->result();
            $data['title']      = 'Level Wise Income Setting';
            $data['breadcrumb'] = 'Level Wise Income Setting';
            $data['layout']     = 'setting/set_level_wise.php';
            $this->load->view('admin/base', $data);
        } else {
            $income_name     = $this->input->post('income_name');
            $income_duration = $this->input->post('income_duration');
            $amount          = $this->input->post('amount');
            $level_no        = $this->input->post('level_no');
            $total_member    = $this->input->post('total_member');

            $array = array(
                'income_name'     => $income_name,
                'income_duration' => $income_duration,
                'amount'          => $amount,
                'level_no'        => $level_no,
                'total_member'    => $total_member,
            );
            $this->db->insert('level_wise_income', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Saved Successfully</div>');
            redirect('income/set_level_wise');

        }
    }

    public function edit_level_wise_income($id)
    {
        $this->form_validation->set_rules('income_name', 'Income Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('id, income_name, total_member, income_duration, level_no, amount', 'level_wise_income', array(
                'id' => $id,
            ));
            $data['title']      = 'Edit Level Wise Income Setting';
            $data['breadcrumb'] = 'EditLevel Wise Income Setting';
            $data['layout']     = 'setting/edit_level_wise.php';
            $this->load->view('admin/base', $data);
        } else {
            $income_name     = $this->input->post('income_name');
            $income_duration = $this->input->post('income_duration');
            $amount          = $this->input->post('amount');
            $level_no        = $this->input->post('level_no');
            $total_member    = $this->input->post('total_member');

            $array = array(
                'income_name'     => $income_name,
                'income_duration' => $income_duration,
                'amount'          => $amount,
                'level_no'        => $level_no,
                'total_member'    => $total_member,
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('level_wise_income', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Updated Successfully</div>');
            redirect('income/set_level_wise');

        }
    }

    public function gap_commission_setting()
    {
        $this->load->model('plan_model');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('id,income_name, amount, total_pv');
            $data['result']     = $this->db->get('gap_commission_setting')->result();
            $data['leg']        = $this->plan_model->create_leg();
            $data['title']      = 'Gap Commission Setting';
            $data['breadcrumb'] = 'Gap Commission Setting';
            $data['layout']     = 'setting/gap_commission_setting.php';
            $this->load->view('admin/base', $data);
        } else {
            $income_name = $this->input->post('income_name');
            $amount      = $this->input->post('amount');

            $e = $this->input->post('total_pv') ? $this->input->post('total_pv') : 0;

            $array = array(
                'income_name' => $income_name,
                'amount'      => $amount,
                'total_pv'    => $e,
            );
            $this->db->insert('gap_commission_setting', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Saved Successfully</div>');
            redirect('income/gap-commission-setting');

        }
    }

    public function income_setting()
    {
        $this->form_validation->set_rules('id', 'Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('direct_income, level_income, binary_income');
            $data['result']     = $this->db->get('fix_income')->row();
            $data['title']      = 'General Income Setting';
            $data['breadcrumb'] = 'General Income Setting';
            $data['layout']     = 'setting/income_setting.php';
            $this->load->view('admin/base', $data);
        } else {
            $direct_income = $this->input->post('direct_income');
            $level_income  = $this->input->post('level_income');
            $binary_income = $this->input->post('binary_income');

            $array = array(
                'direct_income' => $direct_income,
                'level_income'  => $level_income,
                'binary_income' => $binary_income,
            );
            // $this->db->where('id', $this->input->post('id'));
            $this->db->update('fix_income', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Saved Successfully</div>');
            redirect('income/income-setting');

        }
    }

    public function edit_flexi_income($id)
    {
        $this->load->model('plan_model');
        $this->form_validation->set_rules('income_name', 'Income Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('id, income_name, income_duration, A, B, C, D, E, amount, based_on', 'flexible_income', array('id' => $id));
            $data['leg']        = $this->plan_model->create_leg();
            $data['title']      = 'Update Advance Income';
            $data['breadcrumb'] = 'Update Advance Income';
            $data['layout']     = 'setting/edit_flexible_income.php';
            $this->load->view('admin/base', $data);
        } else {
            $income_name     = $this->input->post('income_name');
            $income_duration = $this->input->post('income_duration');
            $amount          = $this->input->post('amount');
            $based_on        = $this->input->post('based_on');

            $a = $this->input->post('A') ? $this->input->post('A') : 0;
            $b = $this->input->post('B') ? $this->input->post('B') : 0;
            $c = $this->input->post('C') ? $this->input->post('C') : 0;
            $d = $this->input->post('D') ? $this->input->post('D') : 0;
            $e = $this->input->post('E') ? $this->input->post('E') : 0;

            $array = array(
                'income_name'     => $income_name,
                'income_duration' => $income_duration,
                'amount'          => $amount,
                'based_on'        => $based_on,
                'A'               => $a,
                'B'               => $b,
                'C'               => $c,
                'D'               => $d,
                'E'               => $e,
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('flexible_income', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Saved Successfully</div>');
            redirect('income/flexible-income');

        }
    }

    public function edit_gap_commission_setting($id)
    {
        $this->load->model('plan_model');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->where('id', $id);
            $this->db->select('id,income_name, amount, total_pv');
            $data['result']     = $this->db->get('gap_commission_setting')->row();
            $data['title']      = 'Gap Commission Setting';
            $data['breadcrumb'] = 'Gap Commission Setting';
            $data['layout']     = 'setting/edit_gap_commission_setting.php';
            $this->load->view('admin/base', $data);
        } else {
            $income_name = $this->input->post('income_name');
            $amount      = $this->input->post('amount');

            $e = $this->input->post('total_pv') ? $this->input->post('total_pv') : 0;

            $array = array(
                'income_name' => $income_name,
                'amount'      => $amount,
                'total_pv'    => $e,
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('gap_commission_setting', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Income Settings Saved Successfully</div>');
            redirect('income/gap-commission-setting');

        }
    }


    public function remove_level_wise_income($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('level_wise_income');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Setting of Income Deleted Successfully</div>');
        redirect('income/set_level_wise');
    }

    public function remove_flexi_income($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('flexible_income');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Setting of Income Deleted Successfully</div>');
        redirect('income/flexible-income');
    }

    public function remove_gap_income($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('gap_commission_setting');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Setting of Income Deleted Successfully</div>');
        redirect('income/gap-commission-setting');
    }
}