<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller
{
    /**
     * Check Valid Login or display login page.
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE) {
            redirect(site_url('site/admin'));
        }
        $this->load->library('pagination');
    }

    public function edit_des($id)
    {
        $this->form_validation->set_rules('des_name', 'Designation Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $config['base_url']   = site_url('staff/designations');
            $config['per_page']   = 10;
            $config['total_rows'] = $this->db_model->count_all('staff_designation');
            $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);

            $this->db->select('id, des_title, payscale');
            $this->db->limit($config['per_page'], $page);
            $data['result']     = $this->db->get('staff_designation')->result();
            $data['data']       = $this->db_model->select_multi('id, des_title, payscale, des_permission', 'staff_designation', array('id' => $id));
            $data['title']      = 'Edit Designation';
            $data['breadcrumb'] = 'Edit Designation';
            $data['layout']     = 'staff/edit_designation.php';
            $this->load->view('admin/base', $data);
        }
        else {

            $perm = array(
                'b_setting'      => $this->input->post('b_setting') ? $this->input->post('b_setting') : '0',
                'user_manage'    => $this->input->post('user_manage') ? $this->input->post('user_manage') : '0',
                'tree_view'      => $this->input->post('tree_view') ? $this->input->post('tree_view') : '0',
                'epin'           => $this->input->post('epin') ? $this->input->post('epin') : '0',
                'earning_manage' => $this->input->post('earning_manage') ? $this->input->post('earning_manage') : '0',
                'manage_poducts' => $this->input->post('manage_poducts') ? $this->input->post('manage_poducts') : '0',
                'view_orders'    => $this->input->post('view_orders') ? $this->input->post('view_orders') : '0',
                'coupon'         => $this->input->post('coupon') ? $this->input->post('coupon') : '0',
                'staff'          => $this->input->post('staff') ? $this->input->post('staff') : '0',
                'franchisee'     => $this->input->post('franchisee') ? $this->input->post('franchisee') : '0',
                'support'        => $this->input->post('support') ? $this->input->post('support') : '0',
                'expense'        => $this->input->post('expense') ? $this->input->post('expense') : '0',
                'invoice'        => $this->input->post('invoice') ? $this->input->post('invoice') : '0',
            );

            $array = array(
                'des_title'      => $this->input->post('des_name'),
                'payscale'       => $this->common_model->filter($this->input->post('payscale'), 'float'),
                'des_permission' => serialize($perm),
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('staff_designation', $array);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Designation Updated Successfully.</div>');
            redirect('staff/designations');

        }
    }

    public function designations()
    {
        $this->form_validation->set_rules('des_name', 'Designation Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $config['base_url']   = site_url('staff/designations');
            $config['per_page']   = 10;
            $config['total_rows'] = $this->db_model->count_all('staff_designation');
            $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);

            $this->db->select('id, des_title, payscale');
            $this->db->limit($config['per_page'], $page);
            $data['result']     = $this->db->get('staff_designation')->result();
            $data['title']      = 'Manage Designations';
            $data['breadcrumb'] = 'Manage Designations';
            $data['layout']     = 'staff/designations.php';
            $this->load->view('admin/base', $data);
        }
        else {

            $perm = array(
                'b_setting'      => $this->input->post('b_setting') ? $this->input->post('b_setting') : '0',
                'user_manage'    => $this->input->post('user_manage') ? $this->input->post('user_manage') : '0',
                'tree_view'      => $this->input->post('tree_view') ? $this->input->post('tree_view') : '0',
                'epin'           => $this->input->post('epin') ? $this->input->post('epin') : '0',
                'wallet'         => $this->input->post('wallet') ? $this->input->post('wallet') : '0',
                'earning_manage' => $this->input->post('earning_manage') ? $this->input->post('earning_manage') : '0',
                'manage_poducts' => $this->input->post('manage_poducts') ? $this->input->post('manage_poducts') : '0',
                'view_orders'    => $this->input->post('view_orders') ? $this->input->post('view_orders') : '0',
                'coupon'         => $this->input->post('coupon') ? $this->input->post('coupon') : '0',
                'staff'          => $this->input->post('staff') ? $this->input->post('staff') : '0',
                'franchisee'     => $this->input->post('franchisee') ? $this->input->post('franchisee') : '0',
                'support'        => $this->input->post('support') ? $this->input->post('support') : '0',
                'expense'        => $this->input->post('expense') ? $this->input->post('expense') : '0',
                'invoice'        => $this->input->post('invoice') ? $this->input->post('invoice') : '0',
            );

            $array = array(
                'des_title'      => $this->input->post('des_name'),
                'payscale'       => $this->common_model->filter($this->input->post('payscale'), 'float'),
                'des_permission' => serialize($perm),
            );

            $this->db->insert('staff_designation', $array);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Designation Created Successfully.</div>');
            redirect('staff/designations');

        }
    }

    public function remove_des($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('staff_designation');
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Designation Deleted successfully.</div>");
        redirect(site_url('staff/designations'));
    }

    function new_staff()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[staffs.username]');
        $this->form_validation->set_rules('designation', 'Designation', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'required');

        if ($this->form_validation->run()) {
            $params = array(
                'designtion'  => $this->input->post('designation'),
                'password'    => $this->input->post('password'),
                'username'    => $this->input->post('username'),
                'name'        => $this->input->post('name'),
                'email'       => $this->input->post('email'),
                'phone'       => $this->input->post('phone'),
                'pan'         => $this->input->post('pan'),
                'aadhar'      => $this->input->post('aadhar'),
                'address'     => $this->input->post('address'),
                'bank_detail' => $this->input->post('bank_detail'),
            );

            $this->db->insert('staffs', $params);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Staff Added Successfully.</div>');
            redirect('staff/list-staffs');
        }
        else {
            $this->db->select('id, des_title')->from('staff_designation');
            $data['data']       = $this->db->get()->result();
            $data['title']      = 'Add New Staff';
            $data['breadcrumb'] = 'Add New Staff';
            $data['layout']     = 'staff/new_staff.php';
            $this->load->view('admin/base', $data);
        }
    }

    public function list_staffs()
    {
        $this->db->from('staffs');
        $data['data']       = $this->db->get()->result_array();
        $data['title']      = 'All Staffs';
        $data['breadcrumb'] = 'All Staffs';
        $data['layout']     = 'staff/list_staffs.php';
        $this->load->view('admin/base', $data);
    }

    function edit($id)
    {
        $data['staff'] = $this->db->get_where('staffs', array('id' => $id))->row_array();

        if (isset($data['staff']['id'])) {
            $this->form_validation->set_rules('designation', 'Designation', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'required');

            if ($this->form_validation->run()) {
                $params = array(
                    'designtion'  => $this->input->post('designation'),
                    'password'    => $this->input->post('password'),
                    'name'        => $this->input->post('name'),
                    'email'       => $this->input->post('email'),
                    'phone'       => $this->input->post('phone'),
                    'pan'         => $this->input->post('pan'),
                    'aadhar'      => $this->input->post('aadhar'),
                    'address'     => $this->input->post('address'),
                    'bank_detail' => $this->input->post('bank_detail'),
                );
                $this->db->where('id', $id);
                $this->db->update('staffs', $params);
                $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Staff Updated Successfully.</div>');
                redirect('staff/list-staffs');
            }
            else {
                $this->db->select('id, des_title')->from('staff_designation');
                $data['data']       = $this->db->get()->result();
                $data['title']      = 'Edit Staff';
                $data['breadcrumb'] = 'Edit Staff';
                $data['layout']     = 'staff/edit_staff.php';
                $this->load->view('admin/base', $data);
            }
        }
    }

    public function remove($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('staffs');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Staff Deleted Successfully.</div>');
        redirect('staff/list-staffs');
    }

    public function pay_salary()
    {
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required');
        $this->form_validation->set_rules('paydate', 'Pay Date', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->db->select('id, name, phone')->from('staffs');
            $data['staff']      = $this->db->get()->result();
            $data['title']      = 'Pay Salary';
            $data['breadcrumb'] = 'Pay Salary';
            $data['layout']     = 'staff/pay_salary.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $array = array(
                'staff_id' => $this->input->post('staff_id'),
                'salary'   => $this->common_model->filter($this->input->post('salary'), 'float'),
                'month'    => $this->input->post('month'),
                'year'     => $this->input->post('year'),
                'paydate'  => $this->input->post('paydate'),
            );

            $this->db->insert('salary', $array);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Salary Paid Successfully.</div>');
            redirect('staff/pay-salary');
        }

    }

    public function edit_salary($id)
    {
        $this->form_validation->set_rules('salary', 'Salary', 'trim|required');
        $this->form_validation->set_rules('paydate', 'Pay Date', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['salary']     = $this->db_model->select_multi('*', 'salary', array('id' => $id));
            $data['title']      = 'Edit Salary';
            $data['breadcrumb'] = 'Edit Salary';
            $data['layout']     = 'staff/edit_salary.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $array = array(
                'salary'  => $this->common_model->filter($this->input->post('salary'), 'float'),
                'month'   => $this->input->post('month'),
                'year'    => $this->input->post('year'),
                'paydate' => $this->input->post('paydate'),
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('salary', $array);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Salary Updated Successfully.</div>');
            redirect('staff/salary-report');
        }

    }

    public function salary_report()
    {
        $config['base_url']   = site_url('staff/salary_report');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('salary');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('salary')->order_by('id', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['salary']     = $this->db->get()->result();
        $data['title']      = 'Salary Report';
        $data['breadcrumb'] = 'Salary Report';
        $data['layout']     = 'staff/salary_report.php';
        $this->load->view('admin/base', $data);

    }

    public function remove_salary($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('salary');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Salary Removed Successfully.</div>');
        redirect('staff/salary-report');
    }

}