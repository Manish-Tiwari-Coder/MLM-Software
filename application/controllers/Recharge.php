<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Recharge extends CI_Controller
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
    }

    public function records()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }

        if (trim($this->input->post('userid')) !== "") {
            $where = array(
                'userid' => $this->common_model->filter($this->input->post('userid')),
                'status' => 'Completed',
            );
        }
        else {
            $where = array(
                'status' => 'Completed',
            );

        }

        $config['base_url']   = site_url('recharge/records');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('recharge_entry', $where);
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('recharge_entry')->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $this->db->where('status', 'Completed');
        if (trim($this->input->post('userid')) !== "") {
            $this->db->where(array('userid' => $this->common_model->filter($this->input->post('userid'))));
        }

        $data['rcg']        = $this->db->get()->result();
        $data['title']      = 'Recharge Records';
        $data['breadcrumb'] = 'Recharge Records';
        $data['layout']     = 'recharge/records.php';
        $this->load->view('admin/base', $data);
    }

    public function remove_record($id)
    {

        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('recharge_entry');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Record Deleted successfully.</div>');

        redirect('recharge/records');
    }

    public function recharge($param)
    {
        switch ($param) {
            case ($param == "mobile"):
                $mno          = $this->input->post('mno');
                $operator     = $this->input->post('operator');
                $circle       = $this->input->post('circle');
                $amount       = $this->input->post('amount');
                $service_type = "Mobile";

                ## SET Your recharge URL as provided in your API doc with given parameters.
                $recharge_url = '';

                $response = $this->common_model->curl($recharge_url);
                break;
            case ($param == "dth"):
                $sub_no       = $this->input->post('sub_no');
                $operator     = $this->input->post('operator');
                $amount       = $this->input->post('amount');
                $service_type = "DTH";

                ## SET Your recharge URL as provided in your API doc with given parameters.
                $recharge_url = '';

                $response = $this->common_model->curl($recharge_url);
                break;
        }

        ## Configure Json Response or plain text response as per your API doc.
        $result = json_decode($response);
        $status = $result['status'];
        $error  = $result['error'];
        $trnid  = $result['trnid'];

        if ($status !== "Success") {

            $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">Some Error Occured while doing Recharge: ' . $error . '.</div>');
            redirect('recharge/new_recharge');
        }
        $array = array(
            'userid'       => $this->session->user_id,
            'service_type' => $service_type,
            'recharge_no'  => $mno . $sub_no,
            'amount'       => $amount,
            'time'         => time(),
            'status'       => 'Completed',
            'area'         => $circle,
            'operator'     => $operator,
            'trnid'        => $trnid,
        );
        $this->db->insert('recharge_entry', $array);
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Your Recharge is Successfull. Transaction Id: ' . $trnid . '</div>');
        redirect('recharge/new_recharge');
    }

    public function new_recharge()
    {
        $data['title']      = 'New Recharge';
        $data['breadcrumb'] = 'New Recharge';
        $data['layout']     = 'recharge/new_recharge.php';
        $this->load->view('member/base', $data);
    }

    public function old_recharges()
    {
        $where                = array(
            'userid' => $this->session->user_id,
            'status' => 'Completed',
        );
        $config['base_url']   = site_url('recharge/old-recharges');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('recharge_entry', $where);
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('recharge_entry')->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $this->db->where($where);

        $data['rcg']        = $this->db->get()->result();
        $data['title']      = 'My Recharges';
        $data['breadcrumb'] = 'My Recharges';
        $data['layout']     = 'recharge/old_recharge.php';
        $this->load->view('member/base', $data);
    }
}