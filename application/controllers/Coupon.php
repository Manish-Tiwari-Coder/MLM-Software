<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Site
 */
class Coupon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->model('plan_model');
        $this->load->library('pagination');
    }

    public function search()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }

        $category = $this->input->post('coupon_cat');
        $status   = $this->input->post('status');
        $userid   = $this->input->post('userid');

        $this->db->select('id, coupon, userid, coupon_amt, status');

        if ($category !== "All") {
            $this->db->where('coupon_cat', $category);
        }
        if ($status !== "All") {
            $this->db->where('status', $status);
        }
        if (trim($userid) !== "") {
            $this->db->where('userid', $userid);
        }
        $data['result']     = $this->db->get('coupon')->result();
        $data['title']      = 'Coupons';
        $data['breadcrumb'] = 'Coupons';
        $data['layout']     = 'coupon/list_coupons.php';
        $this->load->view('admin/base', $data);
    }

    public function manage_coupons()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('coupon/manage_coupons');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('coupon');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
        $data['cats'] = $this->db->get('coupon_categories')->result();

        $this->db->select('id, coupon, userid, coupon_amt, status');
        $this->db->limit($config['per_page'], $page);

        $data['result']     = $this->db->get('coupon')->result();
        $data['title']      = 'Coupons';
        $data['breadcrumb'] = 'Coupons';
        $data['layout']     = 'coupon/list_coupons.php';
        $this->load->view('admin/base', $data);
    }

    public function use_requests()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('coupon/use_requests');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('coupon', array('status' => 'Use Request'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
        $data['cats'] = $this->db->get('coupon_categories')->result();

        $this->db->select('id, coupon, userid, coupon_amt, status')->where(array('status' => 'Use Request'));
        $this->db->limit($config['per_page'], $page);

        $data['result']     = $this->db->get('coupon')->result();
        $data['title']      = 'Use Requested Coupons';
        $data['breadcrumb'] = 'Use Requested Coupons';
        $data['layout']     = 'coupon/list_coupons.php';
        $this->load->view('admin/base', $data);
    }

    public function manage_cat()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
            $data['result']     = $this->db->get('coupon_categories')->result();
            $data['title']      = 'Coupon Categories';
            $data['breadcrumb'] = 'Coupon Categories';
            $data['layout']     = 'coupon/manage_cat.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $cat_name = $this->input->post('cat_name');
            $cat_desc = $this->input->post('cat_desc');

            $array = array(
                'cat_name'        => $cat_name,
                'cat_description' => $cat_desc,
            );
            $this->db->insert('coupon_categories', $array);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon Category created successfully.</div>");
            redirect(site_url('coupon/manage-cat'));
        }
    }

    public function create_coupon()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->form_validation->set_rules('userid', 'User ID', 'trim|required');
        $this->form_validation->set_rules('coupon_cat', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('coupon_amt', 'Coupon Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
            $data['result']     = $this->db->get('coupon_categories')->result();
            $data['title']      = 'Generate Coupons';
            $data['breadcrumb'] = 'Generate Coupons';
            $data['layout']     = 'coupon/create_coupon.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $userid      = $this->common_model->filter($this->input->post('userid'));
            $coupon_cat  = $this->input->post('coupon_cat');
            $coupon_amt  = $this->input->post('coupon_amt');
            $coupon_code = $this->input->post('coupon_code');

            $array = array(
                'coupon'     => $coupon_code,
                'userid'     => $userid,
                'coupon_cat' => $coupon_cat,
                'coupon_amt' => $coupon_amt,
            );
            $this->db->insert('coupon', $array);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon created successfully.</div>");
            redirect(site_url('coupon/manage-coupons'));
        }
    }

    public function remove_coupon($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('coupon');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon Deleted successfully.</div>");
        redirect(site_url('coupon/manage-coupons'));
    }

    public function mark_use($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $array = array('status' => 'Used');
        $this->db->where('id', $id);
        $this->db->update('coupon', $array);
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon Marked as Used.</div>");
        redirect(site_url('coupon/manage-coupons'));
    }

    public function edit_cat($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('id, cat_name, cat_description', 'coupon_categories', array('id' => $id));
            $data['title']      = 'Edit Coupon Categories';
            $data['breadcrumb'] = 'Edit Coupon Categories';
            $data['layout']     = 'coupon/edit_cat.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $cat_name = $this->input->post('cat_name');
            $cat_desc = $this->input->post('cat_desc');

            $array = array(
                'cat_name'        => $cat_name,
                'cat_description' => $cat_desc,
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('coupon_categories', $array);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon Category updated successfully.</div>");
            redirect(site_url('coupon/manage-cat'));
        }
    }

    public function remove_cat($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('coupon_categories');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon Category Deleted successfully.</div>");
        redirect(site_url('coupon/manage-cat'));
    }

    public function unused()
    {
        if ($this->login->check_member() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('coupon/unused');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('coupon', array(
            'status' => 'Un-Used',
            'userid' => $this->session->user_id,
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, coupon, coupon_amt, coupon_cat, status');
        $this->db->where('userid', $this->session->user_id);
        $this->db->where('status', 'Un-Used');
        $this->db->limit($config['per_page'], $page);

        $data['result'] = $this->db->get('coupon')->result();
        $data['title']  = 'My Un-Used Coupons';
        $data['layout'] = 'misc/coupons.php';
        $this->load->view('member/base', $data);
    }

    public function used()
    {
        if ($this->login->check_member() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('coupon/unused');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('coupon', array(
            'status !=' => 'Un-Used',
            'userid'    => $this->session->user_id,
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, coupon, coupon_amt, coupon_cat, status');
        $this->db->where('userid', $this->session->user_id);
        $this->db->where('status !=', 'Un-Used');
        $this->db->limit($config['per_page'], $page);

        $data['result'] = $this->db->get('coupon')->result();
        $data['title']  = 'My Used Coupons';
        $data['layout'] = 'misc/coupons.php';
        $this->load->view('member/base', $data);
    }

    public function use_it()
    {
        $array = array(
            'status' => 'Use Request',
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('coupon', $array);
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Coupon requested for use. Support Team will update you soon.</div>");
        redirect(site_url('coupon/unused'));
    }

}
