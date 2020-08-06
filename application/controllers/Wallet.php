<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller
{
    /**
     * Income Section for Admin Only
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->library('pagination');
    }

    public function manage_wallet_fund()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->form_validation->set_rules('uid', 'User ID', 'trim|required');
        $this->form_validation->set_rules('balance', 'Wallet Balance', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Manage Wallet Funds';
            $data['breadcrumb'] = 'Wallet Funds';
            $data['layout']     = 'wallet/manage_funds.php';
            $this->load->view('admin/base', $data);
        } else {
            $uid     = $this->common_model->filter($this->input->post('uid'));
            $balance = $this->input->post('balance');
            $type    = $this->input->post('submit');

            $get_fund = $this->db_model->select('balance', 'wallet', array('userid' => $uid));
            $new_fund = $get_fund + $balance;
            if ($type == "remove") {
                $new_fund = $get_fund - $balance;
            }

            $array = array(
                'balance' => $new_fund,
            );
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Wallet Balance Updated.</div>');
            $this->db->where('userid', $uid);
            $this->db->update('wallet', $array);
            redirect('wallet/manage_wallet_fund');

        }
    }

    public function transfer_fund()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->form_validation->set_rules('userid', 'User ID', 'trim|required');
        $this->form_validation->set_rules('transferid', 'Transfer ID', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Transfer Wallet Funds';
            $data['breadcrumb'] = 'Transfer Funds';
            $data['layout']     = 'wallet/transfer_funds.php';
            $this->load->view('admin/base', $data);
        } else {
            $uid        = $this->common_model->filter($this->input->post('userid'));
            $transferid = $this->common_model->filter($this->input->post('transferid'));
            $balance    = $this->input->post('amount');

            $get_fund_uid = $this->db_model->select('balance', 'wallet', array('userid' => $uid));
            $get_fund_tid = $this->db_model->select('balance', 'wallet', array('userid' => $transferid));
            if ($get_fund_uid < $balance || $balance <= 0) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">User donot have sufficient balance in his/her wallet.</div>');
                redirect('wallet/transfer_fund');
            }
            $new_fund = $get_fund_tid + $balance;
            $array    = array(
                'balance' => $new_fund,
            );
            $this->db->where('userid', $transferid);
            $this->db->update('wallet', $array);

            $array = array(
                'balance' => ($get_fund_uid - $balance),
            );
            $this->db->where('userid', $uid);
            $this->db->update('wallet', $array);

            $data = array(
                'transfer_from' => $uid,
                'transfer_to'   => $transferid,
                'amount'        => $balance,
                'time'          => date('Y-m-d'),
            );
            $this->db->insert('transfer_balance_records', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund Transferred Successfully.</div>');
            redirect('wallet/transfer_fund');

        }
    }

    public function withdraw_fund()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->form_validation->set_rules('userid', 'User ID', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Withdraw Wallet Funds';
            $data['breadcrumb'] = 'Withdraw Funds';
            $data['layout']     = 'wallet/withdraw_fund.php';
            $this->load->view('admin/base', $data);
        } else {
            $uid     = $this->common_model->filter($this->input->post('userid'));
            $balance = $this->input->post('amount');

            $get_fund_uid = $this->db_model->select('balance', 'wallet', array('userid' => $uid));
            if ($get_fund_uid < $balance || $balance <= 0) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">User donot have sufficient balance in his/her wallet.</div>');
                redirect('wallet/withdraw_fund');
            }
            $new_fund = $get_fund_uid - $balance;
            $array    = array(
                'balance' => $new_fund,
            );
            $this->db->where('userid', $uid);
            $this->db->update('wallet', $array);

            $data = array(
                'userid' => $uid,
                'amount' => $balance,
                'date'   => date('Y-m-d'),
            );
            $this->db->insert('withdraw_request', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund Withdrawn Successfully.</div>');
            redirect('wallet/withdraw_fund');

        }
    }

    public function wallet_transactions()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        if (trim($top_id) == ""):
            $data['title']      = 'Wallet Transactions';
            $data['breadcrumb'] = 'Wallet Transactions';
            $data['layout']     = 'wallet/wallet_transactions.php';
            $this->load->view('admin/base', $data);

        else:
            if (trim($this->session->user_id) !== "" && $top_id < $this->session->user_id) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">You cannot view upline Detail !</div>');
                redirect('wallet/wallet_transactions/');
            }
            redirect(site_url('wallet/wallet_transactions/' . $top_id));
        endif;
    }

    public function withdrawl_report()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        $status = $this->input->post('status');
        $sdate  = $this->input->post('sdate');
        $edate  = $this->input->post('edate');
        if (trim($top_id) == ""):
            $data['title']      = 'Withdrawal Report';
            $data['breadcrumb'] = 'Withdrawal Report';
            $data['layout']     = 'wallet/withdrawl_report.php';
            $this->load->view('admin/base', $data);

        else:
            if (trim($this->session->user_id) !== "" && $top_id < $this->session->user_id) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">You cannot view upline Detail !</div>');
                redirect('wallet/withdrawl_report/');
            }
            redirect(site_url('wallet/withdrawl_report/' . $top_id . '/' . $status . '/' . $sdate . '/' . $edate));
        endif;
    }

    public function generate_payout()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $old_password = $this->input->post('password');
        if (trim($old_password) == ""):
            $data['title']      = 'Generate Payout';
            $data['breadcrumb'] = 'Generate Payout';
            $data['layout']     = 'wallet/generate_payout.php';
            $this->load->view('admin/base', $data);

        else:
            $original_pass = $this->db_model->select('password', 'admin', array('id' => $this->session->admin_id));
            if (password_verify($old_password, $original_pass) == FALSE) {
                $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>Entered Current Password is wrong.</div>");
                redirect(site_url('wallet/generate_payout'));
            }
            ################ We will generate payout now ################

            $this->db->select('userid, balance')->where('balance >=', config_item('min_withdraw'));
            $res = $this->db->get('wallet')->result();
            foreach ($res as $result) {
                $e       = 1;
                $uid     = $result->userid;
                $balance = $result->balance;

                $array = array(
                    'balance' => 0,
                );
                $this->db->where('userid', $uid);
                $this->db->update('wallet', $array);

                $data = array(
                    'userid' => $uid,
                    'amount' => $balance,
                    'date'   => date('Y-m-d'),
                );
                $this->db->insert('withdraw_request', $data);
                $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Payout Generated Successfully.</div>');
            }
            if ($e !== 1) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-info">No User Id has sufficient balance, Hence No Payout Generated.</div>');
            }
            redirect('income/make-payment');

            #############################################################
        endif;
    }


    ############################## MEMBER SECTION HERE ###########################################

    public function transfer_balance()
    {
        $this->form_validation->set_rules('transferid', 'Transfer ID', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Transfer Wallet Funds';
            $data['breadcrumb'] = 'Transfer Funds';
            $data['layout']     = 'wallet/transfer_funds.php';
            $this->load->view('member/base', $data);
        } else {
            $uid        = $this->session->user_id;
            $transferid = $this->common_model->filter($this->input->post('transferid'));
            $balance    = $this->input->post('amount');

            $get_fund_uid = $this->db_model->select('balance', 'wallet', array('userid' => $uid));
            $get_fund_tid = $this->db_model->select('balance', 'wallet', array('userid' => $transferid));
            if ($get_fund_uid < $balance || $balance <= 0) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">User donot have sufficient balance in your wallet.</div>');
                redirect('wallet/transfer_balance');
            }
            $new_fund = $get_fund_tid + $balance;
            $array    = array(
                'balance' => $new_fund,
            );
            $this->db->where('userid', $transferid);
            $this->db->update('wallet', $array);

            $array = array(
                'balance' => ($get_fund_uid - $balance),
            );
            $this->db->where('userid', $uid);
            $this->db->update('wallet', $array);

            $data = array(
                'transfer_from' => $uid,
                'transfer_to'   => $transferid,
                'amount'        => $balance,
                'time'          => date('Y-m-d'),
            );
            $this->db->insert('transfer_balance_records', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund Transferred Successfully.</div>');
            redirect('wallet/transfer_balance');

        }
    }

    public function withdrawal_list()
    {
        $status = $this->input->post('status');
        $sdate  = $this->input->post('sdate');
        $edate  = $this->input->post('edate');
        if (trim($status) == ""):
            $data['title']      = 'Withdrawal Report';
            $data['breadcrumb'] = 'Withdrawal Report';
            $data['layout']     = 'wallet/withdrawl_report.php';
            $this->load->view('member/base', $data);

        else:
            redirect(site_url('wallet/withdrawal_list/' . $status . '/' . $sdate . '/' . $edate));
        endif;
    }

    public function withdraw_payouts()
    {
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|greater_than[' . config_item('min_withdraw') . ']');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Withdraw Wallet Funds';
            $data['breadcrumb'] = 'Withdraw Funds';
            $data['layout']     = 'wallet/withdraw_fund.php';
            $this->load->view('member/base', $data);
        } else {
            $uid     = $this->session->user_id;
            $balance = $this->input->post('amount');

            $get_fund_uid = $this->db_model->select('balance', 'wallet', array('userid' => $uid));
            if ($get_fund_uid < $balance || $balance < config_item('min_withdraw')) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">User donot have sufficient balance in his/her wallet. Use have to withdraw minimum: ' . config_item('currency') . config_item('min_withdraw') . '</div>');
                redirect('wallet/withdraw_payouts');
            }
            $new_fund = $get_fund_uid - $balance;
            $array    = array(
                'balance' => $new_fund,
            );
            $this->db->where('userid', $uid);
            $this->db->update('wallet', $array);

            $data = array(
                'userid' => $uid,
                'amount' => $balance,
                'date'   => date('Y-m-d'),
            );
            $this->db->insert('withdraw_request', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund Withdrawn Successfully.</div>');
            redirect('wallet/withdraw_payouts');

        }
    }

    public function balance_transfer_list()
    {
        $data['title']      = 'Wallet Transactions';
        $data['breadcrumb'] = 'Wallet Transactions';
        $data['layout']     = 'wallet/wallet_transactions.php';
        $this->load->view('member/base', $data);
    }
}