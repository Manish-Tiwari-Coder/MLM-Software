<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Investments extends CI_Controller
{
    /**
     * Check Valid Login or display login page.
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->library('pagination');
        $this->load->model('investment');
    }

    public function manage_packs()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath.</h3>');
        }
        $config['base_url']   = site_url('investments/manage_packs');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('investment_pack');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('investment_pack')->result();
        $data['title']      = 'Investment Packages';
        $data['breadcrumb'] = 'Investment Packages';
        $data['layout']     = 'investment/list_packages.php';
        $this->load->view('admin/base', $data);

    }


    public function edit_pack($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath.</h3>');
        }

        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('*', 'investment_pack', array('id' => $id));
            $data['title']      = 'Edit Investment Package';
            $data['breadcrumb'] = 'Edit Investment Package';
            $data['layout']     = 'investment/edit_package.php';
            $this->load->view('admin/base', $data);
        } else {
            $array = array(
                'pack_name'       => $this->input->post('package_name'),
                'amount'          => $this->input->post('invst_amount'),
                'based'           => $this->input->post('based'),
                'direct_income'   => $this->input->post('direct_income'),
                'level_income'    => $this->input->post('level_income'),
                'matching_income' => $this->input->post('matching_income'),
                'capping'         => $this->input->post('capping'),
                'roi'             => $this->input->post('roi'),
                'roi_frequency'   => $this->input->post('roi_frequency'),
                'roi_limit'       => $this->input->post('roi_limit'),
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('investment_pack', $array);

            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Package updated successfully.</div>");
            redirect(site_url('investments/manage_packs'));
        }

    }

    public function create_pack()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath.</h3>');
        }

        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Create an Investment Package';
            $data['breadcrumb'] = 'Create an Investment Package';
            $data['layout']     = 'investment/create_package.php';
            $this->load->view('admin/base', $data);
        } else {
            $array = array(
                'pack_name'       => $this->input->post('package_name'),
                'based'           => $this->input->post('based'),
                'amount'          => $this->input->post('invst_amount'),
                'direct_income'   => $this->input->post('direct_income'),
                'level_income'    => $this->input->post('level_income'),
                'matching_income' => $this->input->post('matching_income'),
                'capping'         => $this->input->post('capping'),
                'roi'             => $this->input->post('roi'),
                'roi_frequency'   => $this->input->post('roi_frequency'),
                'roi_limit'       => $this->input->post('roi_limit'),
            );

            $this->db->insert('investment_pack', $array);

            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Package created successfully.</div>");
            redirect(site_url('investments/manage_packs'));
        }

    }

    public function remove_inv_pack($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('investment_pack');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Package Deleted successfully.</div>");
        redirect(site_url('investments/manage_packs'));
    }

    public function manage_investments()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('investments/manage_investments');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('investments');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('investments')->result();
        $data['title']      = 'Manage Investments';
        $data['breadcrumb'] = 'Manage Investments';
        $data['layout']     = 'investment/investments.php';
        $this->load->view('admin/base', $data);

    }

    public function approve_investments()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('investments/approve_investments');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('investments', array('status' => 'Pending'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->where(array('status' => 'Pending'));
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('investments')->result();
        $data['title']      = 'Manage Investments';
        $data['breadcrumb'] = 'Manage Investments';
        $data['layout']     = 'investment/investments.php';
        $this->load->view('admin/base', $data);

    }

    public function remove_invstment($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('investments');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Investment Deleted successfully.</div>");
        redirect(site_url('investments/manage_investments'));
    }

    public function approve_invstment($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->update('investments', array(
            'status' => 'Active',
            'date'   => date('Y-m-d'),
        ));

        $pack_id       = $this->db_model->select_multi('userid, amount, pack_id', 'investments', array('id' => $id));
        $userid        = $pack_id->userid;
        $my_business   = $this->db_model->select_multi('my_business, topup', 'member', array('id' => $userid));
        $topup         = $my_business->topup;
        $my_business   = $my_business->my_business;
        $inv_amount    = $pack_id->amount;
        $pack_id       = $pack_id->pack_id;
        $matching_incm = $this->db_model->select('matching_income', 'investment_pack', array('id' => $pack_id));

        $this->db->where('id', $userid);
        $this->db->update('member', array(
            'topup'       => $topup + $inv_amount,
            'my_business' => $my_business + $matching_incm,
        ));

        $this->investment->inv_earning($userid, $this->db_model->select('sponsor', 'member', array('id' => $userid)), $id, $inv_amount);
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Investment Approved successfully.</div>");
        redirect(site_url('investments/approve_investments'));
    }

    public function search_investments()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $data['result']     = $this->db->get('investment_pack')->result();
        $data['title']      = 'Search Investments';
        $data['breadcrumb'] = 'Search Investments';
        $data['layout']     = 'investment/search.php';
        $this->load->view('admin/base', $data);
    }

    public function search()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }

        if ($this->input->post('pack_name') !== "All") {
            $this->db->where('pack_id', $this->input->post('pack_name'));
        }
        if ($this->input->post('status') !== "All") {
            $this->db->where('status', $this->input->post('status'));
        }
        if (trim($this->input->post('userid')) !== "") {
            $this->db->where('userid', $this->input->post('userid'));
        }
        if (trim($this->input->post('startdate')) !== "") {
            $this->db->where('date >=', $this->input->post('startdate'));
        }
        if (trim($this->input->post('enddate')) !== "") {
            $this->db->where('date <=', $this->input->post('enddate'));
        }


        $data['result']     = $this->db->get('investments')->result();
        $data['title']      = 'Investment Search Result';
        $data['breadcrumb'] = 'Investment Search Result';
        $data['layout']     = 'investment/investments.php';
        $this->load->view('admin/base', $data);

    }

    ##################### USER PART ##################################

    public function new_invest()
    {
        if ($this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->db->select('id, pack_name, amount, roi, based');
        $data['result'] = $this->db->get('investment_pack')->result();
        $data['title']  = 'New Investment';
        $data['layout'] = 'investment/new_invest.php';
        $this->load->view('member/base', $data);
    }

    public function do_it()
    {
        if ($this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $pack_name  = $this->input->post('id');
        $amount     = $this->input->post('amount');
        $pack_price = $this->db_model->select('amount', 'investment_pack', array('id' => $pack_name));

        if ($pack_price > 0) {
            $invst_price = $pack_price;
        } else {
            $invst_price = $amount;
        }
        $status = 'Pending';
        if (config_item('investment_mode') == "EPIN") {

            $epin_value = $this->db_model->select_multi('amount, type', 'epin', array(
                'epin'   => $this->input->post('epin'),
                'status' => 'Un-used',
            ));
            if ($epin_value->amount < $invst_price) {

                $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>Entered e-PIN is not valid.</div>");
                redirect(site_url('investments/new_invest'));
            } else {
                if ($epin_value->type == "Multi Use"):
                    $amount = $epin_value->amount - $invst_price;
                    if ($amount <= 0):
                        $data = array(
                            'status'    => 'Used',
                            'used_by'   => $this->session->user_id,
                            'used_time' => date('Y-m-d'),
                        );
                    else:
                        $data = array(
                            'amount'    => $amount,
                            'used_by'   => $this->session->user_id,
                            'used_time' => date('Y-m-d'),
                        );
                    endif;
                    $this->db->where('epin', $this->input->post('epin'));
                    $this->db->update('epin', $data);
                else:
                    $data = array(
                        'status'    => 'Used',
                        'used_by'   => $this->session->user_id,
                        'used_time' => date('Y-m-d'),
                    );
                    $this->db->where('epin', $this->input->post('epin'));
                    $this->db->update('epin', $data);
                endif;

                $status = 'Active';
            }
        }
        if (config_item('investment_mode') == "AUTO") {
            $balance = $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id));

            if ($balance < $invst_price) {
                $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>Your Wallet do not have sufficient fund to create this investment.</div>");
                redirect(site_url('investments/new_invest'));
            } else {
                $this->db->where('userid', $this->session->user_id);
                $this->db->update('wallet', array('balance' => ($balance - $invst_price)));
                $status = "Active";
            }

        }

        $array = array(
            'userid'  => $this->session->user_id,
            'pack_id' => $pack_name,
            'amount'  => $invst_price,
            'date'    => date('Y-m-d'),
            'status'  => $status,
        );
        $this->db->insert('investments', $array);
        $inv_id = $this->db->insert_id();
        if ($status == "Active") {

            $pack_id       = $this->db_model->select_multi('userid, amount, pack_id', 'investments', array('id' => $inv_id));
            $userid        = $pack_id->userid;
            $my_business   = $this->db_model->select_multi('my_business, topup', 'member', array('id' => $userid));
            $topup         = $my_business->topup;
            $my_business   = $my_business->my_business;
            $inv_amount    = $pack_id->amount;
            $pack_id       = $pack_id->pack_id;
            $matching_incm = $this->db_model->select('matching_income', 'investment_pack', array('id' => $pack_id));

            $this->db->where('id', $userid);
            $this->db->update('member', array(
                'topup'       => $inv_amount + $topup,
                'my_business' => $my_business + $matching_incm,
            ));

            $this->investment->inv_earning($this->session->user_id, $this->db_model->select('sponsor', 'member', array('id' => $this->session->user_id)), $inv_id);
        }

        redirect('investments/inv_detail/' . $inv_id);
    }

    public function inv_detail($inv_id)
    {
        $data['result'] = $this->db_model->select_multi('id,pack_id, amount, date, status', 'investments', array('id' => $inv_id));
        $data['title']  = 'Investment Status';
        $data['layout'] = 'investment/inv_detail.php';
        $this->load->view('member/base', $data);
    }

    public function pdf_invoice($inv_id)
    {
        $data['result'] = $this->db_model->select_multi('id, userid, pack_id, amount, date, status', 'investments', array('id' => $inv_id));
        $this->load->library('pdf');
        $html     = $this->load->view('member/investment/inv_pdf.php', $data, TRUE);
        $filename = 'invoice_' . $inv_id;
        $this->pdf->generate($html, $filename);
    }

    public function recent_investment()
    {
        $config['base_url']   = site_url('investments/recent_investment');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('investments', array(
            'status !=' => 'Expired',
            'userid'    => $this->session->user_id,
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->where(array('status !=' => 'Expired', 'userid' => $this->session->user_id));
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('investments')->result();
        $data['title']      = 'Recent Investments';
        $data['breadcrumb'] = 'Recent Investments';
        $data['layout']     = 'investment/recent_investments.php';
        $this->load->view('member/base', $data);

    }

    public function expired_investment()
    {
        $config['base_url']   = site_url('investments/expired_investment');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('investments', array('status' => 'Expired'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->where(array('status' => 'Expired'));
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('investments')->result();
        $data['title']      = 'Expired Investments';
        $data['breadcrumb'] = 'Expired Investments';
        $data['layout']     = 'investment/recent_investments.php';
        $this->load->view('member/base', $data);

    }
}
