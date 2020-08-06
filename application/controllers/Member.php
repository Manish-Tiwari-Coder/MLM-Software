<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without
 * permission. Project Developer: Bidush Sarkar Developed for: Exolim IT Services
 * Pvt Ltd
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_member() == false) {
            redirect(site_url('site/login'));
        }
        $this->load->library('pagination');
        $this->load->library('cart');
    }

    public function index()
    {
        $data['detail'] = $this->db_model->select_multi('total_a, total_b, total_c, total_d, total_e', 'member', array('id' => $this->session->user_id));
        $data['title'] = 'Dashboard';
        $data['breadcrumb'] = 'dashboard';
        $this->load->view('member/base', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('site_flash', '<div class="alert alert-info">You have been logged out !</div>');
        redirect(site_url('site/login'));
    }

    // CORE MEMBER PARTS HERE NOW ############################################################ STARTS :

    public function used_epin()
    {
        $config['base_url'] = site_url('member/used_epin');
        $config['per_page'] = 50;
        $config['total_rows'] = $this->db_model->count_all('epin', array(
            'status' => 'Un-used',
            'issue_to' => $this->session->user_id,
        ));
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, used_by, used_time')->from('epin')->where('status', 'Used')
            ->where('issue_to', $this->session->user_id)->limit($config['per_page'], $page);

        $data['epin'] = $this->db->get()->result_array();

        $data['title'] = 'Used e-PINs';
        $data['layout'] = 'epin/used.php';
        $this->load->view('member/base', $data);

    }

    public function unused_epin()
    {
        $config['base_url'] = site_url('member/unused_epin');
        $config['per_page'] = 50;
        $config['total_rows'] = $this->db_model->count_all('epin', array(
            'status' => 'Un-used',
            'issue_to' => $this->session->user_id,
        ));
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, issue_to, generate_time, generate_time')->from('epin')
            ->where('status', 'Un-used')->where('issue_to', $this->session->user_id)
            ->limit($config['per_page'], $page);

        $data['epin'] = $this->db->get()->result_array();

        $data['title'] = 'Unused e-PINs';
        $data['layout'] = 'epin/unused.php';
        $this->load->view('member/base', $data);

    }

    public function transfer_epin()
    {

        $this->form_validation->set_rules('amount', 'e-PIN Amount', 'trim|required');
        $this->form_validation->set_rules('to', 'To User ID', 'trim|required');
        $this->form_validation->set_rules('qty', 'Number of e-PINs', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transfer e-PIN';
            $data['layout'] = 'epin/transfer_epin.php';
            $this->load->view('member/base', $data);
        } else {
            $amount = $this->common_model->filter($this->input->post('amount'), 'float');
            $to = $this->common_model->filter($this->input->post('to'));
            $from = $this->session->user_id;
            $qty = $this->common_model->filter($this->input->post('qty'), 'number');

            $avl_qty = $this->db_model->count_all('epin', array(
                'issue_to' => $from,
                'amount' => $amount,
                'status' => 'Un-used',
            ));
            if ($avl_qty < $qty) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">The User ID have only ' . $avl_qty . ' Un-used epin of ' . config_item('currency') . ' ' . $amount . '.</div>');
                $data['title'] = 'Transfer e-PIN';
                $data['layout'] = 'epin/transfer_epin.php';
                $this->load->view('member/base', $data);
            } else {
                $this->db->where(array(
                    'issue_to' => $from,
                    'amount' => $amount,
                    'status' => 'Un-used',
                ));
                $vals = array(
                    'issue_to' => $to,
                    'transfer_by' => $from,
                    'transfer_time' => date('Y-m-d'),
                );
                $this->db->limit($qty);
                $this->db->update('epin', $vals);

                $this->session->set_flashdata('common_flash', '<div class="alert alert-success">' . $qty . ' e-PIN transferred from  ' . $this->input->post('to') . ' to ' . $this->input->post('from') . ' of ' . config_item('currency') . ' ' . $amount . '.</div>');
                redirect('member/transfer_epin');
            }
        }
    }

    public function generate_epin()
    {
        $this->form_validation->set_rules('amount', 'e-PIN Amount', 'trim|required');
        $this->form_validation->set_rules('userid', 'Issue to ID', 'trim|required');
        $this->form_validation->set_rules('number', 'Number of e-PINs', 'trim|required|max_length[3]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Generate e-PIN';
            $data['layout'] = 'epin/generate.php';
            $this->load->view('member/base', $data);
        } else {
            $amount = $this->common_model->filter($this->input->post('amount'), 'float');
            $userid = $this->common_model->filter($this->input->post('userid'));
            $qty = $this->common_model->filter($this->input->post('number'), 'number');
            $total_amt = $amount * $qty;
            $get_user_balance = $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id));

            if ($get_user_balance < $total_amt) {
                $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>You wallet donot have sufficient balance to generate $qty e-PIN. Your wallet need to have " . config_item('currency') . $total_amt . "</div>");
                redirect('member/generate-epin');
            }

            $data = array();
            for ($i = 0; $i < $qty; $i++) {
                $rand = mt_rand(10000000, 99999999);
                $epin = $this->db_model->select("id", "epin", array("epin" => $rand));
                if ($rand == $epin) {
                    $rand = $rand + 1;
                }
                $array = array(
                    'epin' => $rand,
                    'amount' => $amount,
                    'issue_to' => $userid,
                    'generated_by' => $this->session->user_id,
                    'generate_time' => date('Y-m-d'),
                );
                array_push($data, $array);
            }
            $this->db->insert_batch('epin', $data);

            $arra = array(
                'balance' => ($get_user_balance - $total_amt),
            );
            $this->db->where('userid', $this->session->user_id);
            $this->db->update('wallet', $arra);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>$qty e-PIN created successfully.</div>");
            $this->common_model->mail($this->db_model->select('email', 'member', array('id' => $userid)), 'e-PIN Issued', 'Dear Sir, <br/> e-PIN of Qty ' . $qty . ', has been issued to your account from user id: ' . config_item('ID_EXT') . $this->session->user_id . ' on behalf of us.<br/><br/>---<br/>Regards,<br/>' . config_item('company_name'));
            redirect('member/generate_epin');

        }
    }

    public function view_earning()
    {
        $config['base_url'] = site_url('member/view_earning');
        $config['per_page'] = 100;
        $config['total_rows'] = $this->db_model->count_all('earning', array('userid' => $this->session->user_id));
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, userid, amount, type, ref_id, date, pair_match')->from('earning')
            ->where('userid', $this->session->user_id)->limit($config['per_page'], $page);

        $data['earning'] = $this->db->get()->result_array();

        $data['title'] = 'Earnings';
        $data['layout'] = 'income/view_earning.php';
        $this->load->view('member/base', $data);

    }

    public function topup_wallet()
    {
        if (!isset($_POST['amount']) && !isset($_POST['epin'])) {
            $data['title'] = 'Fund My Wallet';
            $data['layout'] = 'wallet/topup-wallet.php';
            $this->load->view('member/base', $data);
        } else {

            $epin = trim($this->input->post('epin'));
            $amount = trim($this->input->post('amount'));

            if ($epin !== "") {
                $epin_value = $this->db_model->select('amount', 'epin', array(
                    'epin' => $epin,
                    'status' => 'Un-used',
                ));

                if ($epin_value <= 0) {
                    $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">The entered e-PIN is invalid or doesn\'t exist.</div>');
                    redirect(site_url('member/topup-wallet'));
                } else {
                    $wallet_balance = $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id));
                    $this->db->where(array('userid' => $this->session->user_id));
                    $this->db->update('wallet', array('balance' => $wallet_balance + $epin_value));

                    $data = array(
                        'status' => 'Used',
                        'used_by' => $this->session->user_id,
                        'used_time' => date('Y-m-d'),
                    );

                    $this->db->where('epin', $epin);
                    $this->db->update('epin', $data);

                    $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund is added to your wallet.</div>');
                    redirect(site_url('member/topup-wallet'));
                }

            } else {

                $user_data = $this->db_model->select_multi('sponsor, address, email, phone', 'member', array('id' => $this->session->user_id));

                $this->session->set_userdata('_user_id_', $this->session->user_id);
                $this->session->set_userdata('_user_name_', $this->session->name);
                $this->session->set_userdata('_inv_id_', rand());
                $this->session->set_userdata('_sponsor_', $user_data->sponsor);
                $this->session->set_userdata('_address_', $user_data->address);
                $this->session->set_userdata('_email_', $user_data->email);
                $this->session->set_userdata('_phone_', $user_data->phone);
                $this->session->set_userdata('_product_', 'Add Wallet Fund');
                $this->session->set_userdata('_price_', $amount);
                $this->session->set_userdata('_type_', 'wallet');
                $this->session->set_userdata('_coin_', $this->input->post('coin_wallet'));
                $this->load->config('pg');
                if (config_item('enable_coinpayments') == "Yes") {
                    $this->load->library('coinpaymentsapi');
                    $this->coinpaymentsapi->Setup(config_item('private_key'), config_item('pub_key'));
                    $data['p_info'] = $this->coinpaymentsapi->GetCallbackAddress($this->input->post('coin_wallet'), site_url('gateway/coinpayment_success'));

                    $this->db->insert('pending_wallet', array(
                        'userid' => $this->session->user_id,
                        'balance' => $amount,
                        'txn_id' => $data['p_info']['result']['address'],
                    ));
                    $bata['address'] = $data['p_info']['result']['address'];
                    $bata['dest_tag'] = $data['p_info']['result']['dest_tag'];
                    $bata['title'] = 'Fund My Wallet';
                    $bata['layout'] = 'wallet/topup-wallet.php';
                    $this->load->view('member/base', $bata);

                } else {
                    redirect('gateway/registration_form');
                }
            }
        }
    }

    public function failed_fund()
    {
        $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>Your payment is not completed. So your fund was not added.</div>");
        redirect(site_url('member/topup-wallet'));
    }

    public function complete_add_fund()
    {
        $wallet_balance = $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id));
        $this->db->where(array('userid' => $this->session->user_id));
        $this->db->update('wallet', array('balance' => $wallet_balance + $this->session->_price_));
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund is added to your wallet.</div>');
        redirect(site_url('member/topup-wallet'));
    }


    public function my_rewards()
    {
        $config['base_url'] = site_url('member/my_rewards');
        $config['per_page'] = 100;
        $config['total_rows'] = $this->db_model->count_all('rewards', array('userid' => $this->session->user_id));
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, reward_id, date, paid_date, tid')->from('rewards')
            ->where('userid', $this->session->user_id)->limit($config['per_page'], $page);

        $data['rewards'] = $this->db->get()->result_array();

        $data['title'] = 'My Rewards';
        $data['layout'] = 'income/rewards.php';
        $this->load->view('member/base', $data);

    }

    public function search_earning()
    {
        $data['title'] = 'Search Income';
        $data['layout'] = 'income/search_income.php';
        $this->load->view('member/base', $data);
    }

    public function income_search()
    {
        $income_name = $this->input->post('income_name');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');

        $this->db->select('id, userid, amount, type, ref_id, date, pair_match')->from('earning');
        if ($income_name !== "All") {
            $this->db->where('type', $this->input->post('income_name'));
        }
        $this->db->where('userid', $this->session->user_id);
        if (trim($startdate) !== "") {
            $this->db->where('date >=', $startdate);
        }
        if (trim($enddate) !== "") {
            $this->db->where('date <=', $enddate);
        }

        $data['earning'] = $this->db->get()->result_array();
        $data['title'] = 'Search Results';
        $data['layout'] = 'income/view_earning.php';
        $this->load->view('member/base', $data);

    }

    public function settings()
    {
        $this->form_validation->set_rules('oldpass', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('newpass', 'New Password', 'trim|required');
        $this->form_validation->set_rules('repass', 'Retype Password', 'trim|required|matches[newpass]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $data['layout'] = 'profile/acsetting.php';
            $this->load->view('member/base', $data);
        } else {

            $mypass = $this->db_model->select('password', 'member', array('id' => $this->session->user_id));

            if (password_verify($this->input->post('oldpass'), $mypass) == true) {

                $array = array(
                    'password' => password_hash($this->input->post('newpass'), PASSWORD_DEFAULT),
                );
                $this->db->where('id', $this->session->user_id);
                $this->db->update('member', $array);
                $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Settings Saved Successfully.</div>');
                redirect('member/settings');
            } else {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">The entered "Current Password" is wrong.</div>');
                redirect('member/settings');
            }
        }
    }

    public function proile()
    {
        $this->form_validation->set_rules('oldpass', 'Current Password', 'trim|required');
        $data['data'] = $this->db_model->select_multi('*', 'member_profile', array('userid' => $this->session->user_id));
        if ($this->form_validation->run() == false) {
            $data['my'] = $this->db_model->select_multi('phone, email', 'member', array('id' => $this->session->user_id));
            $data['title'] = 'My Profile';
            $data['layout'] = 'profile/profile.php';
            $this->load->view('member/base', $data);
        } else {

            $mypass = $this->db_model->select('password', 'member', array('id' => $this->session->user_id));

            if (password_verify($this->input->post('oldpass'), $mypass) == true) {
                $add_proof = '';
                $id_proof = '';
                if (trim($_FILES['id_proof']['name'] !== "")) {

                    $this->load->library('upload');

                    if (!$this->upload->do_upload('id_proof')) {
                        $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">ID Proof not uploaded..<br/>' . $this->upload->display_errors() . '</div>');
                        redirect('member/proile');
                    } else {
                        $image_data = $this->upload->data();
                        $id_proof = $image_data['file_name'];
                        unlink('uploads/'.$data['data']->id_proof);
                    }
                }

                if (trim($_FILES['add_proof']['name'] !== "")) {

                    $this->load->library('upload');

                    if (!$this->upload->do_upload('add_proof')) {
                        $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">Address Proof not uploaded..<br/>' . $this->upload->display_errors() . '</div>');
                        redirect('member/proile');
                    } else {
                        $image_data = $this->upload->data();
                        $add_proof = $image_data['file_name'];
                        unlink('uploads/'.$data['data']->add_proof);
                    }
                }

                $array = array(
                    'tax_no' => $this->input->post('tax_no'),
                    'aadhar_no' => $this->input->post('aadhar_no'),
                    'bank_ac_no' => $this->input->post('bank_ac_no'),
                    'bank_name' => $this->input->post('bank_name'),
                    'bank_ifsc' => $this->input->post('bank_ifsc'),
                    'bank_branch' => $this->input->post('bank_branch'),
                    'btc_address' => $this->input->post('btc_address'),
                    'nominee_name' => $this->input->post('nominee_name'),
                    'nominee_add' => $this->input->post('nominee_add'),
                    'nominee_relation' => $this->input->post('nominee_relation'),
                    'date_of_birth' => $this->input->post('date_of_birth'),
                    'gstin' => $this->input->post('gstin'),
                    'id_proof' => $id_proof,
                    'add_proof' => $add_proof
                );
                $this->db->where('userid', $this->session->user_id);
                $this->db->update('member_profile', $array);

                $array = array(
                    'name' => $this->input->post('my_name'),
                    'phone' => $this->input->post('my_phone'),
                    'email' => $this->input->post('my_email'),
                );
                $this->db->where('id', $this->session->user_id);
                $this->db->update('member', $array);

                $this->session->set_userdata('name', $this->input->post('my_name'));
                $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Profile Updated Successfully.</div>');
                redirect('member/proile');
            } else {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">The entered "Current Password" is wrong.</div>');
                redirect('member/proile');
            }
        }
    }

    public function welcome_letter()
    {
        $data['file_data'] = file_get_contents(FCPATH . "uploads/welcome_letter.txt");
        $data['title'] = 'Welcome Letter';
        $data['layout'] = "profile/welcome_letter.php";
        $this->load->view('member/base', $data);
    }

    public function topup()
    {
        $epin_value = $this->db_model->select('amount', 'epin', array(
            'epin' => trim($this->input->post('topup')),
            'status' => 'Un-used',
        ));
        $this->load->model('earning');
        if (config_item('fix_income') == "Yes" && $epin_value > 0 && config_item('give_income_on_topup') == "Yes") {
            $this->earning->fix_income($this->session->user_id, $this->db_model->select('sponsor', 'member', array('id' => $this->session->user_id)), $epin_value);
        } else if (config_item('fix_income') !== "Yes" && $epin_value > 0 && config_item('give_income_on_topup') == "Yes") {

            $this->earning->reg_earning(
                $this->session->user_id,
                $this->db_model->select('sponsor', 'member', array('id' => $this->session->user_id)),
                $this->db_model->select('signup_package', 'member', array('id' => $this->session->user_id)),
                false
            );
        }
        if ($epin_value > 0) {
            $data = array(
                'topup' => $epin_value,
            );
            $this->db->where('id', $this->session->user_id);
            $this->db->update('member', $data);

            $data = array(
                'status' => 'Used',
                'used_by' => $this->session->user_id,
                'used_time' => date('Y-m-d'),
            );
            $this->db->where('epin', trim($this->input->post('topup')));
            $this->db->update('epin', $data);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Successfully Top-uped your account.</div>');
            redirect(site_url('member'));
        } else {
            $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">The entered e-PIN is not valid or used.</div>');
            redirect(site_url('member'));
        }
    }

    public function my_invoices()
    {
        $config['base_url'] = site_url('member/my_invoices');
        $config['per_page'] = 50;
        $config['total_rows'] = $this->db_model->count_all('invoice', array(
            'userid' => $this->session->fran_id,
            'user_type' => 'Franchisee',
        ));
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('invoice')->where(array(
            'userid' => $this->session->user_id,
            'user_type' => 'Member',
        ))->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $data['invoice'] = $this->db->get()->result();
        $data['title'] = 'My Invoices';
        $data['breadcrumb'] = 'My Invoices';
        $data['layout'] = 'invoice/my_invoices.php';
        $this->load->view('member/base', $data);
    }

    public function invoice_view($id)
    {
        $data['result'] = $this->db_model->select_multi('*', 'invoice', array('id' => $id));
        $this->load->view('member/invoice/print_invoice.php', $data);
    }
}

