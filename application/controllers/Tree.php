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
class Tree extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->model('plan_model');
    }

    public function user_tree()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        if (trim($top_id) == ""):
            $data['title']      = 'User Tree';
            $data['breadcrumb'] = 'Tree';
            $data['layout']     = 'tree/user_tree.php';
            $this->load->view('admin/base', $data);

        else:
            if (!($this->session->admin_id)) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">You cannot view upline tree !</div>');
                redirect('tree/user_tree/');
            }
            redirect(site_url('tree/user_tree/' . $top_id));
        endif;
    }

    public function downline_report()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }

        $top_id = $this->common_model->filter($this->input->post('top_id'));
        if (trim($top_id) == ""):
            $data['title']      = 'Downline Report';
            $data['breadcrumb'] = 'Downline Report';
            $data['layout']     = 'tree/downlinereport.php';
            $this->load->view('admin/base', $data);

        else:
            if (trim($this->session->user_id) !== "" && $top_id < $this->session->user_id) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">You cannot view upline Detail !</div>');
                redirect('tree/downline-report/');
            }
            redirect(site_url('tree/downline-report/' . $top_id));
        endif;
    }

    public function referred_list()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        if (trim($top_id) == ""):
            $data['title']      = 'Referred Member List';
            $data['breadcrumb'] = 'Referred Member List';
            $data['layout']     = 'tree/referred_list.php';
            $this->load->view('admin/base', $data);

        else:
            if (trim($this->session->user_id) !== "" && $top_id < $this->session->user_id) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">You cannot view upline Detail !</div>');
                redirect('tree/referred-list/');
            }
            redirect(site_url('tree/referred-list/' . $top_id));
        endif;
    }


    public function add_new()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">You are smelling rotten ! Go and have a bath..</h3>');
        }

        $this->load->model('plan_model');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('sponsor', 'Sponsor ID', 'trim|required');
        $this->form_validation->set_rules('address_1', 'Address Line 1', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password_2', 'Retype Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required');

        if ($this->form_validation->run() !== FALSE) {

            $name           = $this->input->post('name');
            $sponsor        = $this->common_model->filter($this->input->post('sponsor'));
            $email          = $this->input->post('email');
            $phone          = $this->input->post('phone');
            $leg            = $this->input->post('leg') ? $this->input->post('leg') : '';
            $position       = $this->common_model->filter($this->input->post('position'));
            $product        = $this->input->post('product');
            $backdate       = $this->input->post('backdate');
            $userid         = $this->input->post('userid');
            $address_1      = $this->input->post('address_1');
            $address_2      = $this->input->post('address_2');
            $username       = $userid ? $userid : time();
            $password       = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $product_detail = $this->db_model->select_multi('prod_price, gst, pv, qty, matching_income', 'product', array('id' => $product));

            $prod_price = $product_detail->prod_price;

            ###############################################################################
            #
            # Now get selected blank Leg (eg: A, B, C) of position ID
            # If Position id is blank, sponsor ID will become position ID
            # If selected leg of position is not blank, will return error.
            #
            ###############################################################################
            if (config_item('autopool_registration') !== "Yes"):
                if (trim($position) == ""):
                    $position = $sponsor;
                endif;

                if ($position == $sponsor):
                    $position = $this->plan_model->find_extreme_position($sponsor, $leg);
                else:
                    if ($this->plan_model->check_position($position, $leg) !== $position):
                        $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">The selected Position of Placement ID is not empty.</div>');
                        redirect(site_url('site/register'));
                    endif;
                endif;
            else:
                $autopool_data = $this->plan_model->find_autopool_field($sponsor);
                $position      = $autopool_data['position'];
                $leg           = $autopool_data['leg'];

            endif;

            ##############################################################################
            #
            # Everything seems fine, Now will make database entry
            #
            ##############################################################################
            $id = rand(1000000, 9999999);
            if ($this->db_model->count_all('member', array('id' => $id)) > 0) {
                $id = $id + 1;
                if ($this->db_model->count_all('member', array('id' => $id)) > 0) {
                    $id = $id + 2;
                    if ($this->db_model->count_all('member', array('id' => $id)) > 0) {
                        $id = $id + 3;
                    }

                }
            }
            if (config_item('show_join_product') == "No" && config_item('free_registration') == "No") {
                $prod_price = $this->input->post('amt_to_pay');
                $product    = 'N/A';
            }

            if (config_item('show_join_product') !== "Yes"):
                $mybusiness = $prod_price;
            endif;

            $data = array(
                'id'              => $userid ? $userid : $id,
                'name'            => $name,
                'email'           => $email,
                'phone'           => $phone,
                'username'        => $username,
                'password'        => $password,
                'sponsor'         => $sponsor,
                'position'        => $position,
                'signup_package'  => $product,
                'address'         => $address_1 . "<br/>" . $address_2,
                'join_time'       => $backdate ? $backdate : date('Y-m-d'),
                'placement_leg'   => $leg,
                'registration_ip' => $this->input->ip_address(),
                'topup'           => $prod_price,
                'my_business'     => $mybusiness,
                'mypv'            => $product_detail->pv ? $product_detail->pv : 0,
            );

            $this->db->insert('member', $data);
            $user_id = $this->db_model->select('id', 'member', array(
                'phone'           => $phone,
                'username'        => $username,
                'registration_ip' => $this->input->ip_address,
            ));
            if ($user_id):

                $data = array(
                    'userid'  => $user_id,
                    'balance' => "0.00",
                );
                $this->db->insert('wallet', $data);
                $data = array(
                    'userid'  => $user_id,
                    'balance' => "0.00",
                );
                $this->db->insert('other_wallet', $data);

                $data = array(
                    'userid' => $user_id,
                );
                $this->db->insert('member_profile', $data);

            else:
                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Some error occured while registering. please contact admin or try again.</div>');
                //  redirect(site_url('tree/add-new'));
            endif;

            $data = array(
                $leg => $user_id,
            );
            $this->db->where('id', $position);
            $this->db->update('member', $data);
            ##########################################################################
            #
            # Now will send welcome email and SMS.
            #
            ##########################################################################

            if (config_item('sms_on_join') == "Yes"):
                $sms = "Hi, " . $name . ", Thank you for registering with " . config_item('company_name') . ". Your UserID is: " . config_item('ID_EXT') . $user_id . " and Password is: " . $this->input->post('password') . "
                    -- www." . $_SERVER['HTTP_HOST'];
                $this->common_model->sms($phone, $sms);
            endif;
            $sub = "Welcome to " . config_item('company_name');
            $msg = "Hellow " . $name . "<br/> Welcome to " . config_item('company_name') . "Just now you have successfully registered with us. Hope your journey with us will remain exciting and rewarding. <hr/>  <strong>User ID :</strong> " . config_item('ID_EXT') . $user_id . "<br/>
        <strong>Password :</strong> " . $this->input->post('password') . "
      <hr/><---<br/>Regards,<br/>www." . $_SERVER['HTTP_HOST'];

            $this->load->config('email');
            if (trim(config_item('smtp_host')) !== "") {
                $this->common_model->mail($email, $sub, $msg);
            }

            ##########################################################################
            #
            # Now will Redirect to Payment Gateway (If need) or Success Page. At that
            # Page we'll generate income or rewards. Here we'll save some basic
            # important Data with session.
            #
            ##########################################################################
            $this->session->set_userdata('_user_id_', $user_id);
            $this->session->set_tempdata('_auto_user_id_', $user_id, '300');
            $this->session->set_userdata('_inv_id_', $user_id);
            $this->session->set_userdata('_type_', 'userid');
            $this->session->set_userdata('_user_name_', $name);
            $this->session->set_userdata('_sponsor_', $sponsor);
            $this->session->set_userdata('_address_', $address_1);
            $this->session->set_userdata('_email_', $email);
            $this->session->set_userdata('_phone_', $phone);
            $this->session->set_userdata('_product_', $product);
            $this->session->set_userdata('_price_', $prod_price);
            redirect(site_url('site/complete_registration'));
        } else {

            $data['title']      = 'Add New Member';
            $data['breadcrumb'] = 'New Member';
            $data['layout']     = 'tree/new_member.php';
            $this->db->select('id, prod_name, prod_price, gst')->where(array(
                'status'          => 'Selling',
                'show_on_regform' => 'Yes',
            ))->order_by('prod_name', 'ASC');
            $data['products'] = $this->db->get('product')->result_array();
            $data['leg']      = $this->plan_model->create_leg();

            $this->load->view('admin/base', $data);
        }
    }


    ################ MEMBER PART ########################
    public function my_tree()
    {
        $top_id = $this->common_model->filter($this->input->post('top_id'));
        if (trim($top_id) == ""):
            $data['title']      = 'User Tree';
            $data['breadcrumb'] = 'Tree';
            $data['layout']     = 'tree/user_tree.php';
            $this->load->view('member/base', $data);

        else:
            if (trim($this->session->user_id) !== "" && $top_id < $this->session->user_id) {
                $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">You cannot view upline tree !</div>');
                redirect('tree/my_tree/');
            }
            redirect(site_url('tree/my_tree/' . $top_id));
        endif;
    }

    public function genealogy()
    {

        $data['title']      = 'Downline Report';
        $data['breadcrumb'] = 'Downline Report';
        $data['layout']     = 'tree/downlinereport.php';
        $this->load->view('member/base', $data);

    }

    public function directlist()
    {
        $data['title']      = 'Referred Member List';
        $data['breadcrumb'] = 'Referred Member List';
        $data['layout']     = 'tree/referred_list.php';
        $this->load->view('member/base', $data);
    }

    public function new_user($position = '', $sponsor = '')
    {
        redirect(site_url('site/register/' . $position . '/' . $sponsor));
    }


    public function alldownline()
    {
        $data['title']      = 'All Downline List';
        $data['breadcrumb'] = 'All Downline List';
        $data['layout']     = 'tree/downline_list.php';
        $this->load->view('member/base', $data);

    }
}
