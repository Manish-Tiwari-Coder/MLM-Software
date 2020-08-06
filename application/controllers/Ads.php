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
class Ads extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->library('pagination');
    }

    public function manage_ads()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $config['base_url']   = site_url('ads/manage_ads');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('ads');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, ad_title, expiry_date, type')->from('ads')->order_by('id', 'DESC')
                 ->limit($config['per_page'], $page);

        $data['ads'] = $this->db->get()->result();

        $data['title']      = 'Manage Ads';
        $data['breadcrumb'] = 'Manage Ads';
        $data['layout']     = 'ad/listads.php';
        $this->load->view('admin/base', $data);
    }

    public function update()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $ad_title      = $this->input->post('ad_title');
        $ad_html       = addslashes($_POST['ad_html']);
        $level_earning = $this->input->post('level_earning');
        $expiry_date   = $this->input->post('expiry_date');
        $type          = $this->input->post('type');

        $array = array(
            'ad_title'      => $ad_title,
            'ad_html'       => $ad_html,
            'level_earning' => $level_earning,
            'expiry_date'   => $expiry_date,
            'type'          => $type,
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('ads', $array);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Ads Updated Successfully.</div>');
        redirect('ads/manage_ads');
    }

    public function create()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $ad_title      = $this->input->post('ad_title');
        $ad_html       = addslashes($_POST['ad_html']);
        $level_earning = $this->input->post('level_earning');
        $expiry_date   = $this->input->post('expiry_date');
        $type          = $this->input->post('type');

        $array = array(
            'ad_title'      => $ad_title,
            'ad_html'       => $ad_html,
            'level_earning' => $level_earning,
            'expiry_date'   => $expiry_date,
            'type'          => $type,
        );

        $this->db->insert('ads', $array);

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Ads Created Successfully.</div>');
        redirect('ads/manage_ads');
    }

    public function preview($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $data = $this->db_model->select_multi('ad_html, type', 'ads', array('id' => $id));
        if ($data->type == "url") {
            redirect(trim($data->ad_html));
        }
        else {
            echo stripslashes($data->ad_html);
        }
    }


    public function remove($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('ads');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Ad Deleted successfully.</div>');

        redirect('ads/manage_ads');
    }

    public function edit($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $data['ads'] = $this->db_model->select_multi('*', 'ads', array('id' => $id));

        $data['title']      = 'Edit Ad';
        $data['breadcrumb'] = 'Edit Ad';
        $data['layout']     = 'ad/editad.php';
        $this->load->view('admin/base', $data);
    }

    public function achievers()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        if (trim($this->input->post('userid')) !== "") {
            $where = array('userid' => $this->common_model->filter($this->input->post('userid')));
        }
        else {
            $where = 1;
        }
        $config['base_url']   = site_url('ads/achievers');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('ad_user', $where);
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, ad_id, userid, date')->from('ad_user')->order_by('id', 'DESC')
                 ->limit($config['per_page'], $page);

        if (trim($this->input->post('userid')) !== "") {
            $this->db->where(array('userid' => $this->common_model->filter($this->input->post('userid'))));
        }

        $data['ads']        = $this->db->get()->result();
        $data['title']      = 'People Who Viewed your Ads';
        $data['breadcrumb'] = 'Ad Viewers';
        $data['layout']     = 'ad/ad_viewer.php';
        $this->load->view('admin/base', $data);
    }

    ################ MEMBER #############################
    public function myads()
    {
        $config['base_url']   = site_url('ads/myads');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('ads');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, ad_title, expiry_date')->from('ads')->order_by('id', 'DESC')
                 ->limit($config['per_page'], $page);

        $data['ads']        = $this->db->get()->result();
        $data['title']      = 'My Ads';
        $data['breadcrumb'] = 'My Ads';
        $data['layout']     = 'ad/myads.php';
        $this->load->view('member/base', $data);
    }

    public function ad_view($id)
    {
        $data = $this->db_model->select_multi('ad_html, level_earning, type', 'ads', array('id' => $id));
        if (trim($data->level_earning) !== "") {
            $this->load->model('earning');
            $this->earning->advt_level($this->session->user_id, $id, $data->level_earning);
        }
        if ($data->type == "url") {
            redirect(trim($data->ad_html));
        }
        else {

            echo stripslashes($data->ad_html);
        }

    }
}
