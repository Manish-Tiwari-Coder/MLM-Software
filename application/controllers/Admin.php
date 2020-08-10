<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
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
        if (config_item('install_date') !== FALSE) {
            if (strtotime(config_item('install_date')) + 864000 < time()) {
                redirect(site_url('cron/a_e'));
            }
        }
        $this->load->library('pagination');
    }

    public function index()
    {
        $this->db->select('id, name, phone, sponsor, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member')->order_by('join_time', 'DESC')->limit(10);

        $data['members']    = $this->db->get()->result_array();
        $data['title']      = 'Dashboard';
        $data['breadcrumb'] = 'dashboard';
        $this->load->view('admin/base', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('site/admin'));
    }

    // CORE ADMIN PARTS HERE NOW ############################################################ STARTS :

    public function setting()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email ID', 'valid_email');
        $this->form_validation->set_rules('password', 'Old Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('name, email', 'admin', array('id' => $this->session->admin_id));
            $data['title']      = 'Account Setting';
            $data['breadcrumb'] = 'Account Setting';
            $data['layout']     = 'setting/account.php';
            $this->load->view('admin/base', $data);
        } else {
            $name          = $this->input->post('name');
            $email         = $this->input->post('email');
            $old_password  = $this->input->post('password');
            $new_password  = $this->input->post('newpass');
            $original_pass = $this->db_model->select('password', 'admin', array('id' => $this->session->admin_id));
            if (trim($new_password) == "") {
                $new_password = $original_pass;
            } else {
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            }

            if (password_verify($old_password, $original_pass) == FALSE) {
                $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>Entered Current Password is wrong.</div>");
                redirect(site_url('admin/setting'));
            }

            $array = array(
                'name'     => $name,
                'email'    => $email,
                'password' => $new_password,
            );

            $this->db->where('id', $this->session->admin_id);
            $this->db->update('admin', $array);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Detail updated successfully.</div>");
            redirect(site_url('admin/setting'));
        }
    }
    public function change_password()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email ID', 'valid_email');
        $this->form_validation->set_rules('password', 'Old Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('name, email', 'admin', array('id' => $this->session->admin_id));
            $data['title']      = 'Account Setting';
            $data['breadcrumb'] = 'Account Setting';
            $data['layout']     = 'setting/change_password.php';
            $this->load->view('admin/base', $data);
        } else {
            $name          = $this->input->post('name');
            $email         = $this->input->post('email');
            $old_password  = $this->input->post('password');
            $new_password  = $this->input->post('newpass');
            $original_pass = $this->db_model->select('password', 'admin', array('id' => $this->session->admin_id));
            if (trim($new_password) == "") {
                $new_password = $original_pass;
            } else {
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            }

            if (password_verify($old_password, $original_pass) == FALSE) {
                $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>Entered Current Password is wrong.</div>");
                redirect(site_url('admin/change_password'));
            }

            $array = array(
                'name'     => $name,
                'email'    => $email,
                'password' => $new_password,
            );

            $this->db->where('id', $this->session->admin_id);
            $this->db->update('admin', $array);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Detail updated successfully.</div>");
            redirect(site_url('admin/change_password'));
        }
    }

    public function add_expense()
    {
        $ename   = $this->input->post('ename');
        $eamount = $this->input->post('eamount');
        $edetail = $this->input->post('edetail');
        $edate   = $this->input->post('edate');

        $data = array(
            'expense_name' => $ename,
            'amount'       => $eamount,
            'detail'       => $edetail,
            'date'         => $edate,
        );

        $this->db->insert('admin_expense', $data);
        $this->session->set_flashdata("other_flash", "<div class='alert alert-success'>Expense Added</div>");
        redirect(site_url('admin#expense'));
    }

    public function generate_epin()
    {
        $this->form_validation->set_rules('amount', 'e-PIN Amount', 'trim|required');
        $this->form_validation->set_rules('userid', 'Issue to ID', 'trim|required');
        $this->form_validation->set_rules('number', 'Number of e-PINs', 'trim|required|max_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Generate e-PIN';
            $data['breadcrumb'] = 'e-pin';
            $data['layout']     = 'epin/generate.php';
            $this->load->view('admin/base', $data);
        } else {
            $amount = $this->common_model->filter($this->input->post('amount'), 'float');
            $userid = $this->common_model->filter($this->input->post('userid'));
            $qty    = $this->common_model->filter($this->input->post('number'), 'number');

            $data = array();
            for ($i = 0; $i < $qty; $i++) {
                $rand = mt_rand(10000000, 99999999);
                $epin = $this->db_model->select("id", "epin", array("epin" => $rand));
                if ($rand == $epin) {
                    $rand = $rand + 1;
                }
                $array = array(
                    'epin'          => $rand,
                    'amount'        => $amount,
                    'issue_to'      => $userid,
                    'generate_time' => date('Y-m-d'),
                    'type'          => $this->input->post('type'),
                );
                array_push($data, $array);
            }
            $this->db->insert_batch('epin', $data);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>$qty e-PIN created successfully.</div>");
            $this->common_model->mail($this->db_model->select('email', 'member', array('id' => $userid)), 'e-PIN Issued', 'Dear Sir, <br/> e-PIN of Qty ' . $qty . ', has been issued to your account from us.<br/><br/>---<br/>Regards,<br/>' . config_item('company_name'));
            redirect('admin/unused_epin');

        }

    }

    public function epin()
    {
        $type = $this->uri->segment(3);
        $id   = $this->uri->segment(4);

        switch ($type) {
            case $type == "edit":
                redirect('admin/epin_edit/' . $id);
                break;
            case $type == "remove":
                $this->db->where('id', $id);
                $this->db->delete('epin');
                $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>e-PIN deleted successfully.</div>");
                redirect($_SERVER['HTTP_REFERER']);

        }

    }

    public function epin_edit()
    {
        $this->form_validation->set_rules('amount', 'e-PIN Amount', 'trim|required');
        $this->form_validation->set_rules('userid', 'User ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Edit e-PIN';
            $data['breadcrumb'] = 'Edit e-pin';
            $data['layout']     = 'epin/edit.php';
            $data['data']       = $this->db_model->select_multi('id, epin, amount, issue_to, status', 'epin', array('id' => $this->uri->segment(3)));
            $this->load->view('admin/base', $data);
        } else {
            $amount = $this->input->post('amount');
            $userid = $this->common_model->filter($this->input->post('userid'));
            $status = $this->input->post('status');
            $id     = $this->input->post('id');

            $data = array(
                'amount'   => $amount,
                'issue_to' => $userid,
                'status'   => $status,
            );

            $this->db->where('id', $id);
            $this->db->update('epin', $data);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>e-PIN Updated successfully.</div>");
            redirect('admin/epin_edit/' . $id);
        }

    }

    public function unused_epin()
    {

        $config['base_url']   = site_url('admin/unused_epin');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('epin', array('status' => 'Un-used'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, issue_to, generate_time, generate_time, type')->from('epin')
                 ->where('status', 'Un-used')->limit($config['per_page'], $page);

        $data['epin'] = $this->db->get()->result_array();

        $data['title']      = 'Unused e-PINs';
        $data['breadcrumb'] = 'Un-used e-pin';
        $data['layout']     = 'epin/unused.php';
        $this->load->view('admin/base', $data);
    }

    public function used_epin()
    {

        $config['base_url']   = site_url('admin/used_epin');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('epin', array('status' => 'Used'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, used_by, used_time, type')->from('epin')->where('status', 'Used')
                 ->limit($config['per_page'], $page);

        $data['epin'] = $this->db->get()->result_array();

        $data['title']      = 'Used e-PINs';
        $data['breadcrumb'] = 'Used e-pin';
        $data['layout']     = 'epin/used.php';
        $this->load->view('admin/base', $data);
    }


    public function search_epin()
    {
        $config['base_url'] = site_url('admin/search_epin');
        $config['per_page'] = 30;

        if (isset($_POST['uid'])) {
            $this->session->set_userdata('_uid', $this->common_model->filter($this->input->post('uid')));
        }
        if (isset($_POST['epin'])) {
            $this->session->set_userdata('_epin', $this->input->post('epin'));
        }

        if (!isset($_POST['uid']) && !isset($_POST['epin']) && $this->uri->segment(3) == "" && ($_SERVER['HTTP_REFERER'] !== $config['base_url'] . "/2")) {
            $this->session->unset_userdata('_epin');
            $this->session->unset_userdata('_uid');
        }

        $this->db->select('id')->from('epin');
        $this->session->userdata('_uid') ? $this->db->where('issue_to', $this->session->userdata('_uid')) : '';
        $this->session->userdata('_epin') ? $this->db->where('epin', $this->session->userdata('_epin')) : '';

        $config['total_rows'] = $this->db->count_all_results();

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, issue_to, transfer_by, used_by, used_time')->from('epin')
                 ->limit($config['per_page'], $page);
        $this->session->userdata('_uid') ? $this->db->where('issue_to', $this->session->userdata('_uid')) : '';
        $this->session->userdata('_epin') ? $this->db->where('epin', $this->session->userdata('_epin')) : '';

        $data['epin'] = $this->db->get()->result_array();


        $data['title']      = 'Search e-PINs';
        $data['breadcrumb'] = 'Search e-pin';
        $data['layout']     = 'epin/search_epin.php';
        $this->load->view('admin/base', $data);
    }

    public function transfer_epin()
    {

        $this->form_validation->set_rules('amount', 'e-PIN Amount', 'trim|required');
        $this->form_validation->set_rules('to', 'To User ID', 'trim|required');
        $this->form_validation->set_rules('from', 'From User ID', 'trim|required');
        $this->form_validation->set_rules('qty', 'Number of e-PINs', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Transfer e-PIN';
            $data['breadcrumb'] = 'Transfer e-pin';
            $data['layout']     = 'epin/transfer_epin.php';
            $this->load->view('admin/base', $data);
        } else {
            $amount = $this->common_model->filter($this->input->post('amount'), 'float');
            $to     = $this->common_model->filter($this->input->post('to'));
            $from   = $this->common_model->filter($this->input->post('from'));
            $qty    = $this->common_model->filter($this->input->post('qty'), 'number');

            $avl_qty = $this->db_model->count_all('epin', array(
                'issue_to' => $from,
                'amount'   => $amount,
                'status'   => 'Un-used',
            ));
            if ($avl_qty < $qty) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">The User ID have only ' . $avl_qty . ' Un-used epin of ' . config_item('currency') . ' ' . $amount . '.</div>');
                $data['title']      = 'Transfer e-PIN';
                $data['breadcrumb'] = 'Transfer e-pin';
                $data['layout']     = 'epin/transfer_epin.php';
                $this->load->view('admin/base', $data);
            } else {
                $this->db->where(array(
                    'issue_to' => $from,
                    'amount'   => $amount,
                    'status'   => 'Un-used',
                ));
                $vals = array(
                    'issue_to'      => $to,
                    'transfer_by'   => $from,
                    'transfer_time' => date('Y-m-d'),
                );
                $this->db->limit($qty);
                $this->db->update('epin', $vals);

                $this->session->set_flashdata('common_flash', '<div class="alert alert-success">' . $qty . ' e-PIN transferred from  ' . $this->input->post('to') . ' to ' . $this->input->post('from') . ' of ' . config_item('currency') . ' ' . $amount . '.</div>');
                redirect('admin/transfer_epin');
            }
        }
    }

    public function manage_cat()
    {
        $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');

        if ($this->form_validation->run() !== FALSE) {
            $data = array(
                'cat_name'    => $this->input->post('cat_name'),
                'parent_cat'  => $this->input->post('parent_cat'),
                'description' => $this->input->post('description'),
            );
            $this->db->insert('product_categories', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Category Created Successfully.</div>');
            redirect('admin/manage_cat');
        } else {
            $config['base_url']   = site_url('admin/manage_cat');
            $config['per_page']   = 50;
            $config['total_rows'] = $this->db_model->count_all('product_categories');
            $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $this->pagination->initialize($config);

            $this->db->select('id, cat_name, parent_cat, description')->from('product_categories')
                     ->order_by('cat_name', 'DESC')->limit($config['per_page'], $page);

            $data['cat'] = $this->db->get()->result_array();
            $this->db->select('id, cat_name');
            $data['parents'] = $this->db->get('product_categories')->result_array();

            $data['title']      = 'Manage Product Categories';
            $data['breadcrumb'] = 'Product Categories';
            $data['layout']     = 'product/categories.php';
            $this->load->view('admin/base', $data);

        }
    }

    public function category()
    {
        $type = $this->uri->segment(3);
        $id   = $this->uri->segment(4);

        switch ($type) {
            case $type == "edit":
                redirect('admin/category_edit/' . $id);
                break;
            case $type == "remove":
                $this->db->where('id', $id);
                $this->db->delete('product_categories');
                $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>Category deleted successfully.</div>");
                redirect('admin/manage_cat');

        }

    }

    public function category_edit()
    {
        $this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Edit Category';
            $data['breadcrumb'] = 'Edit Category';
            $data['layout']     = 'product/edit_category.php';
            $data['data']       = $this->db_model->select_multi('id, cat_name, parent_cat, description', 'product_categories', array('id' => $this->uri->segment(3)));
            $this->db->select('id, cat_name');
            $data['parents'] = $this->db->get('product_categories')->result_array();
            $this->load->view('admin/base', $data);
        } else {
            $this->db->where('id', $this->input->post('id'));
            $data = array(
                'cat_name'    => $this->input->post('cat_name'),
                'parent_cat'  => $this->input->post('parent_cat'),
                'description' => $this->input->post('description'),
            );
            $this->db->update('product_categories', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Category Updated Successfully.</div>');
            redirect('admin/manage_cat');
        }

    }

    public function expense()
    {
        $config['base_url']   = site_url('admin/expense');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('admin_expense');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->order_by('id', 'DESC');
        $this->db->limit($config['per_page'], $page);

        $data['expense']    = $this->db->get('admin_expense')->result();
        $data['title']      = 'Manage Expenses';
        $data['breadcrumb'] = 'Manage Expenses';
        $data['layout']     = 'misc/expenses.php';
        $this->load->view('admin/base', $data);
    }

    public function expense_remove($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('admin_expense');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Expense Entry Deleted Successfully.</div>');
        redirect('admin/expense');
    }
}
