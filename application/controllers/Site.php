<?php

/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without
 * permission. Project Developer: Bidush Sarkar Developed for: Exolim IT Services
 * Pvt Ltd
 **************************************************************************************************/

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Site
 */
class Site extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->output->enable_profiler(TRUE);
    }

    public function index()
    {
        $layout['layout'] = "home.php";
        $this->load->view('theme/default/base', $layout);
    }
    
     public function about()
    {
        $layout['layout'] = "about.php";
        $this->load->view('theme/default/base', $layout);
    }
    
    public function bank()
    {
        $layout['layout'] = "bank.php";
        $this->load->view('theme/default/base', $layout);
    }
    
    public function tc()
    {
        $layout['layout'] = "tandc.php";
        $this->load->view('theme/default/base', $layout);
    }

    public function register()
    {
        $this->load->model('plan_model');
        /*************************************************************
         * We'll register user here using epin or payment gateway
         *
         * 1) First we'll check if form submitted or not. if not, then will
         * display registration form.
         * 2) After submiting form, will check for validation error and unique
         * field error.
         * 3) If everything fine, will find placement location and register user below
         * the placement ID.
         * 4) if epin selected as payment method, will check valid epin or not and will finalize the
         * registration else will show epin error.
         * 5) Else will redirect use to payment gateway. till user make payment ID will
         *  be in block state and after successful payment ID will get activated.
         * 6) Commissions will generate after successful registration and will show success message.
         */

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('sponsor', 'Sponsor ID', 'trim|required');
        $this->form_validation->set_rules('address_1', 'Address Line 1', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password_2', 'Retype Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required');

        if ($this->form_validation->run() !== FALSE) {

            $name = $this->input->post('name');
            $sponsor = $this->common_model->filter($this->input->post('sponsor'));
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $leg = $this->input->post('leg') ? $this->input->post('leg') : 'A';
            $position = $this->input->post('position') ? $this->common_model->filter($this->input->post('position')) : $sponsor;
            $product = $this->input->post('product');
            $epin = $this->input->post('epin');
            $pg = $this->input->post('pg');
            $address_1 = $this->input->post('address_1');
            $address_2 = $this->input->post('address_2');
            $username = time();
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $divert_pg = FALSE;

            ##############################################################
            #
            # Check Product Price the validate against epin (If epin
            # is selected and not Payment Gateway.
            # Here e-PIN amount or PG Amount is Product price + GST/TAX
            #
            ##############################################################
            if (trim($epin) !== "") {
                $epin_value = $this->db_model->select_multi('amount, type', 'epin', array(
                    'epin' => $epin,
                    'status' => 'Un-used',
                ));
                $epin_type = $epin_value->type;
                $epin_value = $epin_value->amount;
            }
            if (config_item('show_join_product') == "Yes") :
                $product_detail = $this->db_model->select_multi('prod_price, gst, pv, qty, matching_income', 'product', array('id' => $product));

                $mybusiness = $product_detail->matching_income;
                if ($product_detail->qty == "0") {
                    $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">The selected product/service is out of stock. Please contact admin.</div>');
                    redirect(site_url('site/register'));
                }
            endif;

            #####################################################################
            #
            # Check if either epin or payment gateway field is selected or not.
            #
            #####################################################################

            if (trim($epin) == "" && trim($pg) == "" && config_item('free_registration') == "No") {

                if (config_item('enable_epin') == "Yes" && config_item('enable_pg') == "Yes") {
                    $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Please enter correct e-PIN or Choose Payment Gateway Option</div>');
                } else {
                    if (config_item('enable_epin') == "Yes" && config_item('enable_pg') == "No") {
                        $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Please enter correct e-PIN.</div>');
                    } else {
                        if (config_item('enable_epin') == "No" && config_item('enable_pg') == "Yes") {
                            $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Please choose Payment Gateway option.</div>');
                        }
                    }
                }
                redirect(site_url('site/register'));
            }
            ########################################################
            #
            # check if e-pin value is matched with product or no
            #
            ########################################################
            $prod_price = 0;
            if (config_item('free_registration') == "No") {
                if ((trim($epin) !== "" || trim($pg) !== "")) {
                    if (trim($epin) !== "") {
                        if (config_item('show_join_product') == "Yes") {
                            $prod_price = $product_detail->prod_price + ($product_detail->prod_price * $product_detail->gst / 100);
                            if (trim($prod_price) > trim($epin_value)) {
                                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">e-PIN value is less then product price + GST/Tax. Minimum e-PIN value must be: ' . config_item('currency') . ' ' . $prod_price . ' and you entered e-pin value of: ' . config_item('currency') . ' ' . $epin_value . '</div>');
                                redirect(site_url('site/register'));
                            }
                        }
                    } else {
                        $prod_price = $product_detail->prod_price + ($product_detail->prod_price * $product_detail->gst / 100);
                        $divert_pg = TRUE;
                    }
                }
            }

            if (config_item('show_join_product') == "No" && config_item('free_registration') == "No" && trim($pg) == "") {
                $prod_price = $this->input->post('amt_to_pay');
                $product = 'N/A';
                if ($epin_value < $prod_price) {
                    $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Please enter correct e-PIN of worth: ' . config_item('currency') . $prod_price . ' or more.</div>');
                    redirect(site_url('site/register'));
                }
            }

            ###############################################################################
            #
            # Now get selected blank Leg (eg: A, B, C) of position ID
            # If Position id is blank, sponsor ID will become position ID
            # If selected leg of position is not blank, will return error.
            #
            ###############################################################################
            if (config_item('autopool_registration') !== "Yes") :
                if (trim($position) == "") :
                    $position = $sponsor;
                endif;

                if ($position == $sponsor) :
                    $position = $this->plan_model->find_extreme_position($sponsor, $leg);
                else :
                    if ($this->plan_model->check_position($position, $leg) !== $position) :
                        $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">The selected Position of Placement ID is not empty.</div>');
                        redirect(site_url('site/register'));
                    endif;
                endif;
            else :
                $autopool_data = $this->plan_model->find_autopool_field($sponsor);
                $position = $autopool_data['id'];
                $leg = $autopool_data['position'];

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


            if (config_item('show_join_product') !== "Yes") :
                $mybusiness = $prod_price;
            endif;

            $data = array(
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'username' => $username,
                'password' => $password,
                'sponsor' => $sponsor,
                'position' => $position,
                'signup_package' => $product,
                'epin' => $epin,
                'address' => $address_1 . "<br/>" . $address_2,
                'join_time' => date('Y-m-d'),
                'placement_leg' => $leg,
                'registration_ip' => $this->input->ip_address(),
                'topup' => $prod_price,
                'my_business' => $mybusiness,
                'mypv' => $product_detail->pv ? $product_detail->pv : 0,
                'status' => 'Suspend',
            );

            $this->db->insert('member', $data);
            $user_id = $this->db_model->select('id', 'member', array(
                'phone' => $phone,
                'username' => $username,
                'registration_ip' => $this->input->ip_address,
                'epin' => $epin,
            ));
            if ($user_id) :

                $data = array(
                    'userid' => $user_id,
                    'balance' => "0",
                );
                $this->db->insert('wallet', $data);
                $data = array(
                    'userid' => $user_id,
                    'balance' => "0.00",
                );
                $this->db->insert('other_wallet', $data);

                $data = array(
                    'userid' => $user_id,
                );
                $this->db->insert('member_profile', $data);

                $data = array(
                    'userid' => $user_id,
                );
                $this->db->insert('level', $data);
                $this->update_level($user_id);

            else :
                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Some error occured while registering. please contact admin or try again.</div>');
                redirect(site_url('site/register'));
            endif;

            $data = array(
                $leg => $user_id,
            );
            $this->db->where('id', $position);
            $this->db->update('member', $data);

            //FIX
            //FIX
            $dataz = array(
                'total_' . strtolower($leg) => 1,
            );

            $this->db->where('id', $position);
            $this->db->update('member', $dataz);
            //FIX
            //FIX

            $zdata = $this->db_model->select_multi("id,name,sponsor", "member", array("id" => $position));
            $zsponsor = $zdata->sponsor;

            $this->db->where('id', $zsponsor);
            $this->db->set('total_' . strtolower($leg), 'total_' . strtolower($leg) . '+1', FALSE);
            $this->db->update('member');

            //FIX
            //FIX

            while ($zsponsor !== NULL) {
            $zdata2 = $this->db_model->select_multi("id,name,sponsor", "member", array("id" => $zsponsor));
            $zsponsor2 = $zdata2->sponsor;

            $this->db->where('id', $zsponsor2);
            $this->db->set('total_' . strtolower($leg), 'total_' . strtolower($leg) . '+1', FALSE);
            $this->db->update('member');
            $zsponsor = $zsponsor2;
           }
           
            //FIX
            //FIX


            if (trim($epin) !== '' && $epin_type == "Multi Use") :
                $amount = $epin_value - $prod_price;
                if ($amount <= 0) :
                    $data = array(
                        'status' => 'Used',
                        'used_by' => $user_id,
                        'used_time' => date('Y-m-d'),
                    );
                else :
                    $data = array(
                        'amount' => $amount,
                        'used_by' => $user_id,
                        'used_time' => date('Y-m-d'),
                    );
                endif;
                $this->db->where('epin', $epin);
                $this->db->update('epin', $data);
            else :
                $data = array(
                    'status' => 'Used',
                    'used_by' => $user_id,
                    'used_time' => date('Y-m-d'),
                );
                $this->db->where('epin', $epin);
                $this->db->update('epin', $data);
            endif;

            ##########################################################################
            #
            # Now will send welcome email and SMS.
            #
            ##########################################################################

            if (config_item('sms_on_join') == "Yes") :
                $sms = "Hi, " . $name . ", Thank you for registering with " . config_item('company_name') . ". Your UserID is: " . config_item('ID_EXT') . $user_id . " and Password is: " . $this->input->post('password') . "
                    -- www." . $_SERVER['HTTP_HOST'];
                $this->sms($phone, urlencode($sms));
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
            $this->session->set_tempdata('_inv_id_', $user_id);
            $this->session->set_tempdata('_type_', 'userid');
            $this->session->set_userdata('_user_name_', $name);
            $this->session->set_userdata('_sponsor_', $sponsor);
            $this->session->set_userdata('_position_', $position);
            $this->session->set_userdata('_address_', $address_1);
            $this->session->set_userdata('_email_', $email);
            $this->session->set_userdata('_phone_', $phone);
            $this->session->set_userdata('_product_', $product);
            $this->session->set_userdata('_price_', $prod_price);
            if ($divert_pg == TRUE) :
                redirect(site_url('gateway/registration_form'));
            else :
                redirect(site_url('site/complete_registration'));
            endif;
        } else {
            ####################################################
            #
            # If form is not submitted then, will show the
            # default registration form.
            #
            ####################################################
            $this->db->select('id, prod_name, prod_price, gst')->where(array(
                'status' => 'Selling',
                'show_on_regform' => 'Yes',
            ))->order_by('prod_name', 'ASC');
            $layout['products'] = $this->db->get('product')->result_array();
            $layout['leg'] = $this->plan_model->create_leg();
            $layout['layout'] = "register.php";
            $this->load->view('theme/default/base', $layout);
        }
    }

    public function sms($number, $msg, $post = "")
    {
        $url = str_ireplace(array(
            '{{phone}}',
            '{{msg}}',
        ), array(
            $number,
            $msg,
        ), config_item('sms_api'));
        return file_get_contents($url);
    }

    public function complete_registration()
    {
        if ($this->session->_user_id_ > 0) {
            $layout['layout'] = "success.php";
            $this->load->view('theme/default/base', $layout);

            $this->db->where('id', $this->session->_user_id_);
            $this->db->update('member', array('status' => 'Active'));

            /*****************************************************************
             *
             *  This part is important here.
             *  When a person makes payment, He'll be eligible to earn set of
             *  income as stated in plan or joining package.
             *  Lets say direct income or level income.
             *
             *****************************************************************/
            if (config_item('enable_help_plan') == "Yes") {
                $this->load->model('help_plan');
                $this->help_plan->first_help($this->session->_user_id_, $this->session->_sponsor_, $this->session->_position_);
            }

            /*****************************************************************
             *
             *  Now we'll update product as sold and update sold qty and
             * vice versa.. :) u know what I mean..
             *
             *****************************************************************/
            if (config_item('show_join_product') == "Yes") :
                $product_detail = $this->db_model->select_multi('qty, sold_qty', 'product', array('id' => $this->session->userdata('_product_')));
                if ($product_detail->qty !== "-1") {
                    $array = array('qty' => ($product_detail->qty - 1));
                    $this->db->where('id', $this->session->userdata('_product_'));
                    $this->db->update('product', $array);
                } else {
                }

                $array = array('sold_qty' => ($product_detail->sold_qty + 1));
                $this->db->where('id', $this->session->userdata('_product_'));
                $this->db->update('product', $array);
                if (config_item('prevent_join_product_entry') == "No") {
                    $array = array(
                        'product_id' => $this->session->userdata('_product_'),
                        'userid' => $this->session->userdata('_user_id_'),
                        'cost' => $this->session->userdata('_price_'),
                        'date' => date('Y-m-d'),
                    );
                    $this->db->insert('product_sale', $array);
                }
            endif;
            $this->load->model('earning');
            if (config_item('fix_income') == "Yes" && $this->session->userdata('_price_') > 0) {
                $status = $this->earning->fix_income($this->session->userdata('_user_id_'), $this->session->userdata('_sponsor_'), $this->session->userdata('_price_'));
            } else {
                $status = $this->earning->reg_earning($this->session->userdata('_user_id_'), $this->session->userdata('_sponsor_'), $this->session->userdata('_product_'), $need_topup = TRUE);
            }
            if ($status == TRUE) {
                ######## UNSET SOME PREVIOUS VALUES  #########

                $this->session->unset_userdata('_user_id_');
                $this->session->unset_userdata('_user_name_');
                $this->session->unset_userdata('_sponsor_');
                $this->session->unset_userdata('_position_');
                $this->session->unset_userdata('_address_');
                $this->session->unset_userdata('_email_');
                $this->session->unset_userdata('_phone_');
                $this->session->unset_userdata('_product_');
                $this->session->unset_userdata('_price_');

                ##############################################

            }
        } else {
            redirect(site_url('site/login'));
        }
    }

    public function failed_registration()
    {
        if ($this->session->_user_id_ > 0) {
            $layout['layout'] = "fail.php";
            $this->load->view('theme/default/base', $layout);
            /*****************************************************************
             *
             * Registration Complete but Payment Failed. Hence ID is deleted.
             *
             *****************************************************************/

            $id = $this->session->_user_id_;

            $check_legs = $this->db_model->count_all('member', array('position' => $id));
            if ($check_legs > 0 || trim($id) == config_item('top_id')) {
            } else {
                $position = $this->db_model->select_multi('position, placement_leg, my_img', 'member', array('id' => $id));
                $data = array(
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
            }
        } else {
            redirect(site_url('site/login'));
        }
    }

    private function update_level($user_id, $i = 20, $e = 1)
    {
        if ($i > 0) {
            $lvl_position_id = $this->db_model->select('position', 'member', array('id' => $user_id));
            if (strlen($lvl_position_id) > 2) {
                $get_level = $this->db_model->select('level' . $e, 'level', array('userid' => $lvl_position_id));
                $this->db->set('level' . $e, $get_level + 1);
                $this->db->where('userid', $lvl_position_id);
                $this->db->update('level');
                $this->update_level($lvl_position_id, $i - 1, $e + 1);
            }
        }
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $layout['layout'] = "login.php";
            $this->load->view('theme/default/base', $layout);
        } else {
            $user = $this->common_model->filter($this->input->post('username'));
            $password = $this->input->post('password');
            $data = $this->db_model->select_multi("id, name, password, email, last_login_ip, last_login, status", 'member', array('id' => $user));

            if ($data->status !== "Active") {
                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Login is invalid or Your account is not active. Account status is: ' . ($data->status ? $data->status : 'N/A') . '.</div>');
                redirect(site_url('site/login'));
            }

            if (password_verify($password, $data->password)) {
                session_unset();
                $session = md5($user . time());
                $this->session->set_userdata(array(
                    'user_id' => $data->id,
                    'email' => $data->email,
                    'name' => $data->name,
                    'ip' => $data->last_login_ip,
                    'last_login' => $data->last_login,
                    'session' => $session,
                ));
                $data2 = array(
                    'last_login_ip' => $this->input->ip_address(),
                    'last_login' => time(),
                    'session' => $session,
                );
                $this->db_model->update($data2, 'member', array('id' => $data->id));
                redirect(site_url('member'));
            } else {
                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Invalid Username or Password.</div>');
                redirect(site_url('site/login'));
            }
        }
    }

    public function franchisee()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $layout['layout'] = "franchisee_login.php";
            $this->load->view('theme/default/base', $layout);
        } else {
            $user = $this->input->post('username');
            $password = $this->input->post('password');
            $data = $this->db_model->select_multi("id, name, password, business_name, last_login, address, status", 'franchisee', array('username' => $user));
            if ($data->status !== "Active") {
                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Login is invalid or account is blocked. Your account status is ' . $data->status . '.</div>');
                redirect(site_url('site/franchisee'));
            }
            if ($data->password == $password && trim($password) !== "") {
                session_unset();
                $session = md5($user . time());
                $this->session->set_userdata(array(
                    'fran_id' => $data->id,
                    'business_name' => $data->business_name,
                    'name' => $data->name,
                    'last_login' => $data->last_login,
                    'session' => $session,
                ));
                $data2 = array(
                    'last_login_ip' => $this->input->ip_address(),
                    'last_login' => date('Y-m-d'),
                    'session' => $session,
                );
                $this->db_model->update($data2, 'franchisee', array('id' => $data->id));
                redirect(site_url('franchisee'));
            } else {
                $this->session->set_flashdata('site_flash', '<div class="alert alert-danger">Invalid Username or Password.</div>');
                redirect(site_url('site/franchisee'));
            }
        }
    }

    public function forgotpw()
    {
        $layout['layout'] = "forgot.php";
        $this->load->view('theme/default/base', $layout);
    }

    public function staff()
    {
        $this->form_validation->set_rules('username', 'Staff Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/staff');
        } else {
            $user = $this->input->post('username');
            $password = $this->input->post('password');
            $data = $this->db_model->select_multi("id, name, password, email, ip, last_login, designtion", 'staffs', array('username' => $user));

            if ($password == $data->password) {
                session_unset();
                $session = md5($user . time());
                $this->session->set_userdata(array(
                    'admin_id' => $data->id,
                    'email' => $data->email,
                    'name' => $data->name,
                    'ip' => $data->ip,
                    'last_login' => $data->last_login,
                    'session' => $session,
                    'staff' => TRUE,
                    'designation' => unserialize($this->db_model->select('des_permission', 'staff_designation', array('id' => $data->designtion))),
                ));

                $data2 = array(
                    'ip' => $this->input->ip_address(),
                    'last_login' => date('Y-m-d'),
                    'session' => $session,
                );
                $this->db_model->update($data2, 'staffs', array('id' => $data->id));
                redirect(site_url('admin'));
            } else {
                $this->session->set_flashdata('admin_flash', '<div class="alert alert-danger">Invalid Username or Password.</div>');
                redirect(site_url('site/staff'));
            }
        }
    }

    public function admin()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login');
        } else {
            $user = $this->input->post('username');
            $password = $this->input->post('password');
            $data = $this->db_model->select_multi("id, name, password, email, ip, last_login", 'admin', array('username' => $user));

            if (password_verify($password, $data->password)) {
                session_unset();
                $session = md5($user . time());
                $this->session->set_userdata(array(
                    'admin_id' => $data->id,
                    'email' => $data->email,
                    'name' => $data->name,
                    'ip' => $data->ip,
                    'last_login' => $data->last_login,
                    'session' => $session,
                ));
                $data2 = array(
                    'ip' => $this->input->ip_address(),
                    'last_login' => time(),
                    'session' => $session,
                );
                $this->db_model->update($data2, 'admin', array('id' => $data->id));
                redirect(site_url('admin'));
            } else {
                $this->session->set_flashdata('admin_flash', '<div class="alert alert-danger">Invalid Username or Password.</div>');
                redirect(site_url('site/admin'));
            }
        }
    }

    public function admin_forget()
    {
        $this->load->view('admin/forget');
    }

    public function auto_login()
    {
        if (isset($this->session->_auto_user_id_)) {
            $data = $this->db_model->select_multi("id, name, password, email, last_login_ip, last_login", 'member', array('id' => $this->session->_auto_user_id_));
            $session = md5($this->session->_auto_user_id_ . time());
            $this->session->set_userdata(array(
                'user_id' => $data->id,
                'email' => $data->email,
                'name' => $data->name,
                'ip' => $data->last_login_ip,
                'last_login' => $data->last_login,
                'session' => $session,
            ));
            $data2 = array(
                'last_login_ip' => $this->input->ip_address(),
                'last_login' => time(),
                'session' => $session,
            );
            $this->db_model->update($data2, 'member', array('id' => $data->id));
            redirect(site_url('member'));
        } else {
            redirect(site_url('site/login'));
        }
    }

    public function _404()
    {

        $this->output->set_status_header('404');
        $this->load->view('404'); //loading in custom error view
    }

    public function get_user_name()
    {
        echo $this->db_model->select('name', 'member', array('id' => $this->uri->segment(3)));
    }
}
