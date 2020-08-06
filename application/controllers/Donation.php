<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Donation extends CI_Controller
{
    /**
     * Check Valid Login or display login page.
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == false && $this->login->check_member() == false) {
            redirect(site_url('site/login'));
        }
        $this->load->library('pagination');
    }

    public function manage_packs()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">Yuk !! Go and have a bath.</h3>');
        }
        $config['base_url']   = site_url('donation/manage_packs');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('investment_pack');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('donation_package')->result();
        $data['title']      = 'Donation Packages';
        $data['breadcrumb'] = 'Donation Packages';
        $data['layout']     = 'donation/list_packages.php';
        $this->load->view('admin/base', $data);

    }


    public function edit_pack($id)
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">Yuk !! Go and have a bath.</h3>');
        }

        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['result']     = $this->db_model->select_multi('*', 'donation_package', array('id' => $id));
            $data['title']      = 'Edit Donation Package';
            $data['breadcrumb'] = 'Edit Donation Package';
            $data['layout']     = 'donation/edit_package.php';
            $this->load->view('admin/base', $data);
        } else {
            $array = array(
                'donation_level'  => $this->input->post('donation_level'),
                'plan_name'       => $this->input->post('package_name'),
                'sponsor_income'  => $this->input->post('sponsor_income'),
                'position_income' => $this->input->post('position_income'),
                'donation_amount' => $this->input->post('invst_amount'),
                'donation_qty'    => $this->input->post('donation_qty'),
                'expiry_duration' => $this->input->post('expiry_after'),
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('donation_package', $array);

            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Package updated successfully.</div>");
            redirect(site_url('donation/manage_packs'));
        }

    }

    public function create_pack()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">Yuk !! Go and have a bath.</h3>');
        }

        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title']      = 'Create a Donation Package';
            $data['breadcrumb'] = 'Create a Donation Package';
            $data['layout']     = 'donation/create_package.php';
            $this->load->view('admin/base', $data);
        } else {
            $array = array(
                'donation_level'  => $this->input->post('donation_level'),
                'plan_name'       => $this->input->post('package_name'),
                'sponsor_income'  => $this->input->post('sponsor_income'),
                'position_income' => $this->input->post('position_income'),
                'donation_amount' => $this->input->post('invst_amount'),
                'donation_qty'    => $this->input->post('donation_qty'),
                'expiry_duration' => $this->input->post('expiry_after'),
            );

            $this->db->insert('donation_package', $array);

            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Package created successfully.</div>");
            redirect(site_url('donation/manage_packs'));
        }

    }

    public function remove_don_pack($id)
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('donation_package');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Package Deleted successfully.</div>");
        redirect(site_url('donation/manage_packs'));
    }

    public function manage_donations()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('donation/manage_donations');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('donations');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('donations')->result();
        $data['title']      = 'Manage Donations';
        $data['breadcrumb'] = 'Manage Donations';
        $data['layout']     = 'donation/donations.php';
        $this->load->view('admin/base', $data);

    }

    public function remove_donation($id)
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('donations');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Donation Deleted successfully.</div>");
        redirect(site_url('donation/manage_donations'));
    }

    public function upgrade_level()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->select('id, donation_level, plan_name');
        $data['result']     = $this->db->get('donation_package')->result();
        $data['title']      = 'Upgrade Level';
        $data['breadcrumb'] = 'Upgrade Level';
        $data['layout']     = 'donation/upgrade.php';
        $this->load->view('admin/base', $data);
    }

    public function upgrade_user()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }

        $level = $this->db_model->select('donation_level', 'donation_package', array('id' => $this->input->post('upgrade_to')));
        $array = array(
            'gift_level' => $level,
        );
        $this->db->where('id', $this->input->post('userid'));
        $this->db->update('member', $array);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">User Level Changed</div>');
        redirect('donation/upgrade_level');
    }

    public function search_donations()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->select('id, donation_level, plan_name');
        $data['result']     = $this->db->get('donation_package')->result();
        $data['title']      = 'Search Donations';
        $data['breadcrumb'] = 'Search Donations';
        $data['layout']     = 'donation/search.php';
        $this->load->view('admin/base', $data);
    }

    public function search()
    {
        if ($this->login->check_session() == false) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }

        if ($this->input->post('pack_name') !== "All") {
            $this->db->where('donation_pack', $this->input->post('pack_name'));
        }
        if ($this->input->post('status') !== "All") {
            $this->db->where('status', $this->input->post('status'));
        }
        if (trim($this->input->post('userid')) !== "") {
            $this->db->where('sender_id', $this->input->post('userid'));
            $this->db->or_where('receiver_id', $this->input->post('userid'));
        }
        $this->db->limit(300)->order_by('id', 'DESC');
        $data['result']     = $this->db->get('donations')->result();
        $data['title']      = 'Donation Search Result';
        $data['breadcrumb'] = 'Donation Search Result';
        $data['layout']     = 'donation/src_donations.php';
        $this->load->view('admin/base', $data);

    }

    ##################### USER PART ##################################

    public function sent_donation()
    {

        $config['base_url']   = site_url('donation/sent_donation');
        $config['per_page']   = 20;
        $config['total_rows'] = $this->db_model->count_all('donations', array(
            'sender_id' => $this->session->user_id,
            'status !=' => 'Sent',
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->where(array(
                             'sender_id' => $this->session->user_id,
                             'status !=' => 'Sent',
                         ));
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('donations')->result();
        $data['title']      = 'Sent Donations';
        $data['breadcrumb'] = 'Sent Donations';
        $data['layout']     = 'donation/donations.php';
        $this->load->view('member/base', $data);
    }

    public function received_donation()
    {

        $config['base_url']   = site_url('donation/received_donation');
        $config['per_page']   = 20;
        $config['total_rows'] = $this->db_model->count_all('donations', array(
            'receiver_id' => $this->session->user_id,
            'status !='   => 'Sent',
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->where(array(
                             'receiver_id' => $this->session->user_id,
                             'status !='   => 'Sent',
                         ));
        $this->db->limit($config['per_page'], $page);
        $data['result']     = $this->db->get('donations')->result();
        $data['title']      = 'Received Donations';
        $data['breadcrumb'] = 'Received Donations';
        $data['layout']     = 'donation/received_donations.php';
        $this->load->view('member/base', $data);
    }

    public function send_donation()
    {
        $file = '';
        if (trim($_FILES['files']['name']) !== "") {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|exe|xls|doc|docx|pdf|txt';
            $config['max_size']      = '8192';
            $config['remove_spaces']=TRUE;  //it will remove all spaces
            $config['encrypt_name']=TRUE;   //it wil encrypte the original file name
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('files')) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-warning">Image not uploaded.<br/>' . $this->upload->display_errors() . '</div>');
                redirect('member');
            } else {
                $image_data               = $this->upload->data();
                $file = $image_data['file_name'];
            }
        }
        $data = array(
            'status' => 'Waiting',
            'trid'   => $this->input->post('tdetail'),
            'file'   => $file,
            'tdate'  => date('Y-m-d'),
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('donations', $data);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Request accepted and sent for Receiver Approval</div>');
        redirect('member');
    }

    public function approve_donation($id)
    {

        $data = array(
            'status' => 'Accepted',
        );
        $this->db->where('id', $id);
        $this->db->update('donations', $data);

        $user_data     = $this->db_model->select_multi('sender_id, donation_pack', 'donations', array('id' => $id));
        $donation_pack = $user_data->donation_pack;
        $user_data     = $user_data->sender_id;

        $donation_qty   = $this->db_model->select('donation_qty', 'donation_package', array('id' => $donation_pack));
        $count_donation = $this->db_model->count_all('donations', array(
            'sender_id'     => $user_data,
            'donation_pack' => $donation_pack,
            'status'        => 'Accepted',
        ));
        $get_level      = $this->db_model->select('gift_level', 'member', array('id' => $user_data));

        if ($count_donation >= $donation_qty) {
            $this->load->model('help_plan');
            $this->help_plan->generate_donation($this->session->user_id);
            $data = array(
                'gift_level' => ($get_level + 1),
                'topup'      => 1,
            );

            $this->db->where('id', $user_data);
            $this->db->update('member', $data);
        }
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Donation marked as accepted.</div>');
        redirect('member');
    }

    public function accept_donation($id)
    {

        $data = array(
            'status' => 'Accepted',
        );
        $this->db->where('id', $id);
        $this->db->update('donations', $data);

        $user_data     = $this->db_model->select_multi('sender_id, donation_pack,  receiver_id', 'donations', array('id' => $id));
        $donation_pack = $user_data->donation_pack;
        $user_data     = $user_data->sender_id;

        $donation_qty   = $this->db_model->select('donation_qty', 'donation_package', array('id' => $donation_pack));
        $count_donation = $this->db_model->count_all('donations', array(
            'sender_id'     => $user_data,
            'donation_pack' => $donation_pack,
            'status'        => 'Accepted',
        ));
        $get_level      = $this->db_model->select('gift_level', 'member', array('id' => $user_data));

        if ($count_donation >= $donation_qty) {
            $this->load->model('help_plan');
            $this->help_plan->generate_donation($user_data->receiver_id);
            $data = array(
                'gift_level' => ($get_level + 1),
                'topup'      => 1,
            );

            $this->db->where('id', $user_data);
            $this->db->update('member', $data);
        }
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Donation marked as accepted.</div>');
        redirect(site_url('donation/manage_donations'));
    }
}