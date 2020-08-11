<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without
 * permission. Project Developer: Bidush Sarkar Developed for: Exolim IT Services
 * Pvt Ltd
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
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

    public function login_member($id){

        $data     = $this->db_model->select_multi("id, name, password, email, last_login_ip, last_login, status", 'member', array('id' => $id));
        $session = md5($user . time());
        $this->session->set_userdata(array(
                                         'user_id'    => $data->id,
                                         'email'      => $data->email,
                                         'name'       => $data->name,
                                         'ip'         => $data->last_login_ip,
                                         'last_login' => $data->last_login,
                                         'session'    => $session,
                                     ));
        $data2 = array(
            'last_login_ip' => $this->input->ip_address(),
            'last_login'    => time(),
            'session'       => $session,
        );
        $this->db_model->update($data2, 'member', array('id' => $data->id));
        redirect(site_url('member'));



    }

    public function view_members()
    {
        $config['base_url']   = site_url('users/view_members');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('member');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, name, phone, sponsor, topup, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member');

        $this->db->limit($config['per_page'], $page);

        $data['members'] = $this->db->get()->result_array();

        $data['title']      = 'List of Members';
        $data['breadcrumb'] = 'Manage Members';
        $data['layout']     = 'member/list_member.php';
        $this->load->view('admin/base', $data);
    }

    public function user_detail($id)
    {

        $data['data'] = $this->db_model->select_multi('id, name, email, phone, sponsor, position, signup_package, address, my_img, last_login, last_login_ip, join_time, registration_ip, rank', 'member', array('id' => $id));

        $data['title']      = 'Member Detail';
        $data['breadcrumb'] = 'Member Detail';
        $data['layout']     = 'member/view_detail.php';
        $this->load->view('admin/base', $data);


    }

    public function topup_member(){

        $this->form_validation->set_rules('userid', 'User ID', 'trim|required');
        $this->form_validation->set_rules('amt', 'Top Up Amount', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Top Up Member';
            $data['breadcrumb'] = 'Top Up Member';
            $data['layout']     = 'member/topup.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $epin_value = $this->input->post('amt');;
            $userid = $this->common_model->filter($this->input->post('userid'));
            $data   = array(
                'topup' => $epin_value,
            );
            $this->db->where('id', $userid);
            $this->db->update('member', $data);
            $this->load->model('earning');
            if (config_item('fix_income') == "Yes" && $epin_value > 0 && config_item('give_income_on_topup') == "Yes") {
                $this->earning->fix_income($userid, $this->db_model->select('sponsor', 'member', array('id' => $userid)), $epin_value);
            }
            else if (config_item('fix_income') !== "Yes" && $epin_value > 0 && config_item('give_income_on_topup') == "Yes") {
                $this->earning->reg_earning($userid, $this->db_model->select('sponsor', 'member', array('id' => $userid)), $this->db_model->select('signup_package', 'member', array('id' => $userid)));
            }

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Successfully Top-uped User account.</div>');
            redirect('users/topup-member');
        }
    }

    public function blocked_members()
    {
        $config['base_url']   = site_url('users/view_members');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('earning', array('status' => 'Block'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, name, phone, sponsor, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member')->where(array('status' => 'Block'));

        $this->db->limit($config['per_page'], $page);

        $data['members'] = $this->db->get()->result_array();

        $data['title']      = 'Blocked Members';
        $data['breadcrumb'] = 'Blocked Members';
        $data['layout']     = 'member/list_member.php';
        $this->load->view('admin/base', $data);

    }

    public function latest_members()
    {
        $config['base_url']   = site_url('users/view_members');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('earning');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, name, phone, sponsor, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member')->order_by('join_time', 'DESC');

        $this->db->limit($config['per_page'], $page);

        $data['members'] = $this->db->get()->result_array();

        $data['title']      = 'Latest Members';
        $data['breadcrumb'] = 'Latest Members';
        $data['layout']     = 'member/list_member.php';
        $this->load->view('admin/base', $data);

    }

    public function edit_user($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('join_time', 'Date of Join', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $name      = $this->input->post('name');
            $email     = $this->input->post('email');
            $phone     = $this->input->post('phone');
            $address   = $this->input->post('address');
            $join_time = $this->input->post('join_time');
            $password  = $this->input->post('password');
            $status    = $this->input->post('status');
            $array     = array(
                'name'      => $name,
                'email'     => $email,
                'phone'     => $phone,
                'address'   => $address,
                'join_time' => $join_time,
                'status'    => $status,
            );
            if (trim($password) !== "") {
                $array = $array + array('password' => password_hash($password, PASSWORD_DEFAULT));
            }
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('member', $array);

            $array = array(
                'tax_no'           => $this->input->post('tax_no'),
                'date_of_birth'    => $this->input->post('birthdate'),
                'gstin'            => $this->input->post('gstin'),
                'aadhar_no'        => $this->input->post('aadhar_no'),
                'bank_name'        => $this->input->post('bank_name'),
                'bank_ac_no'       => $this->input->post('bank_ac_no'),
                'bank_ifsc'        => $this->input->post('bank_ifsc'),
                'bank_branch'      => $this->input->post('bank_branch'),
                'btc_address'      => $this->input->post('btc_address'),
                'nominee_name'     => $this->input->post('nominee_name'),
                'nominee_add'      => $this->input->post('nominee_add'),
                'nominee_relation' => $this->input->post('nominee_relation'),
            );
            $this->db->where('userid', $this->input->post('id'));
            $this->db->update('member_profile', $array);

            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>User has been updated.</div>");
            redirect(site_url('users/view_members'));
        }
        else {
            $data['data']    = $this->db_model->select_multi('id, name, email, phone, address, join_time, status', 'member', array('id' => $id));
            $data['profile'] = $this->db_model->select_multi('*', 'member_profile', array('userid' => $id));

            $data['title']      = 'Edit Member';
            $data['breadcrumb'] = 'Edit Member';
            $data['layout']     = 'member/edit_member.php';
            $this->load->view('admin/base', $data);
        }
    }

    public function search()
    {
        $phone     = $this->input->post('phone');
        $email     = $this->input->post('email');
        $sponsor   = $this->common_model->filter($this->input->post('sponsor'));
        $userid    = $this->common_model->filter($this->input->post('userid'));
        $startdate = $this->input->post('startdate');
        $enddate   = $this->input->post('enddate');

        $this->db->select('id, name, phone, sponsor, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member')->order_by('name', 'ASC');
        if (trim($phone) !== "") {
            $this->db->where('phone', $phone);
        }
        if (trim($userid) !== "") {
            $this->db->where('id', $userid);
        }
        if (trim($startdate) !== "") {
            $this->db->where('join_time >=', $startdate);
        }
        if (trim($enddate) !== "") {
            $this->db->where('join_time <=', $enddate);
        }
        if (trim($email) !== "") {
            $this->db->where('email', $enddate);
        }
        if (trim($sponsor) !== "") {
            $this->db->where('sponsor', $sponsor);
        }

        $data['members'] = $this->db->get()->result_array();

        $data['title']      = 'Search Results';
        $data['breadcrumb'] = 'Search Results';
        $data['layout']     = 'member/list_member.php';
        $this->load->view('admin/base', $data);

    }

    public function search_user()
    {
        $data['title']      = 'Search Member';
        $data['breadcrumb'] = 'Search Member';
        $data['layout']     = 'member/search_user.php';
        $this->load->view('admin/base', $data);
    }

    public function remove_member($id)
    {
        $check_legs = $this->db_model->count_all('member', array('position' => $id));
        if ($check_legs > 0 || trim($id) == config_item('top_id')) {

            $this->session->set_flashdata("common_flash", "<div class='alert alert-danger'>User Cannot be deleted as there are other users below this user.</div>");
            redirect(site_url('users/view_members'));
        }
        else {
            $position = $this->db_model->select_multi('position, placement_leg, my_img', 'member', array('id' => $id));
            $data     = array(
                $position->placement_leg => 0,
            );
            $this->db->where('id', $position->position);
            $this->db->update('member', $data);

            $this->db->where('id', $id);
            $this->db->delete('member');

            $this->db->where('userid', $id);
            $this->db->delete('member_profile');
            $this->db->where('userid', $id);
            $this->db->delete('wallet');

            unlink(FCPATH . "uploads/" . $position->my_img);
            $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>User has been deleted from database.</div>");
            redirect(site_url('users/view_members'));
        }

    }
 /*************************************  New Edited Function Start  ***************************************/
    public function active_member($id)
    {
        $config['base_url']   = site_url('member/active_member');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('member', array('status' => 'Block'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, name, phone, sponsor, topup, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member')->where(array('status' => 'Active'));

        $this->db->limit($config['per_page'], $page);

        $data['members'] = $this->db->get()->result_array();

        $data['title']      = 'List of Active Members';
        $data['breadcrumb'] = 'Active Members';
        $data['layout']     = 'member/active_member.php';
        $this->load->view('admin/base', $data);
    }
    public function deactive_members()
    {
        $config['base_url']   = site_url('member/deactive_members');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('member', array('status' => 'Block'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, name, phone, sponsor, join_time, total_a, total_b, total_c, total_d, total_e')
                 ->from('member')->where(array('status' => 'Block'));

        $this->db->limit($config['per_page'], $page);

        $data['members'] = $this->db->get()->result_array();

        $data['title']      = 'Deactive Members';
        $data['breadcrumb'] = 'Deactive Members';
        $data['layout']     = 'member/deactive_members.php';
        $this->load->view('admin/base', $data);

    }
    /* public function deactivate_member($id)
    { 
        $s='status' => 'Block';
        $this->db->where('userid', $id);
        $this->db->update('member',$s );
        $this->session->set_flashdata("common_flash", "<div class='alert alert-success'>User has been Deactivated.</div>");
            redirect(site_url('member/active_member'));
    } */
        
    
 /*************************************  New Edited Function End  ***************************************/





}
