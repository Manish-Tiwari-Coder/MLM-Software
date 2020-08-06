<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_franchisee extends CI_Controller
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

    public function index()
    {
        $data['title']      = 'Dashboard';
        $data['breadcrumb'] = 'dashboard';
        $this->load->view('admin/base', $data);
    }


    public function add_fran()
    {
        $this->form_validation->set_rules('name', 'Franchisee Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[franchisee.username]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']      = 'Add Franchisee';
            $data['breadcrumb'] = 'Add Franchisee';
            $data['layout']     = 'franchisee/add_fran.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $name          = $this->input->post('name');
            $username      = $this->input->post('username');
            $business_name = $this->input->post('business_name');
            $email         = $this->input->post('email');
            $phone         = $this->input->post('phone');
            $country       = $this->input->post('country');
            $state         = $this->input->post('state');
            $address       = $this->input->post('address');
            $password      = str_rot13($username);

            $data = array(
                'name'          => $name,
                'username'      => $username,
                'business_name' => $business_name,
                'country'       => $country,
                'state'         => $state,
                'password'      => $password,
                'email'         => $email,
                'phone'         => $phone,
                'address'       => $address,
            );
            $this->db->insert('franchisee', $data);
            $fran_id = $this->db->insert_id();
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Franchisee Added successfully. Franchisee ID: <strong>' . $fran_id . '
</strong>Franchisee 
Username: <strong>' . $username . '</strong>. Password is: <strong>' . $password . '</strong></div>');

            $sub = "Franchisee Login Detail";
            $msg = "Hellow " . $name . "<br/> Welcome to " . config_item('company_name') . "Just now you have successfully registered with us as a franchisee. Below is your login detail. <hr/>  <strong>User Name :</strong> " . $username . "<br/>
Franchisee ID: <strong>' . $fran_id . '</strong><br/>
        <strong>Password :</strong> " . $password . "
      <hr/><---<br/>Regards,<br/>www." . $_SERVER['HTTP_HOST'];
            $this->common_model->mail($email, $sub, $msg);
            redirect('adm-franchisee/add-fran');

        }
    }

    public function edit_fran($id)
    {
        $this->form_validation->set_rules('name', 'Franchisee Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['data']       = $this->db_model->select_multi('*', 'franchisee', array('id' => $id));
            $data['title']      = 'Edit Franchisee';
            $data['breadcrumb'] = 'Edit Franchisee';
            $data['layout']     = 'franchisee/edit_fran.php';
            $this->load->view('admin/base', $data);
        }
        else {
            $name          = $this->input->post('name');
            $business_name = $this->input->post('business_name');
            $email         = $this->input->post('email');
            $phone         = $this->input->post('phone');
            $country       = $this->input->post('country');
            $state         = $this->input->post('state');
            $address       = $this->input->post('address');
            $password      = $this->input->post('password');
            $status        = $this->input->post('status');

            $data = array(
                'name'          => $name,
                'business_name' => $business_name,
                'country'       => $country,
                'state'         => $state,
                'password'      => $password,
                'email'         => $email,
                'phone'         => $phone,
                'address'       => $address,
                'status'        => $status,
            );
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('franchisee', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Franchisee Updated successfully.</div>');

            redirect('adm-franchisee/manage_fran');

        }
    }

    public function update_stock()
    {
        $fran_id = $this->input->post('fname');

        $no     = 0;
        $array  = array();
        $array2 = array();
        foreach ($_POST['prod_name'] as $name) {
            if ($name !== "") {
                $prod_name    = htmlentities($name);
                $qty          = $_POST['qty'][$no];
                $prodid       = $this->db_model->select_multi('id, dealer_price', 'product', array('prod_name' => $prod_name));
                $dealer_price = $prodid->dealer_price;
                $prodid       = $prodid->id;
                $data         = $this->db_model->select_multi('id, available_qty', 'franchisee_stock', array(
                    'franchisee_id' => $fran_id,
                    'product_id'    => $prodid,
                ));

                $array    += array($prod_name => $_POST['qty'][$no]);
                $array2   += array($prod_name => $dealer_price);
                $stock_id = $data->id;
                if ($data->available_qty == "") {
                    $array = array(
                        'franchisee_id' => $fran_id,
                        'product_id'    => $prodid,
                    );
                    $this->db->insert('franchisee_stock', $array);
                    $stock_id = $this->db->insert_id();
                }

                $update_qty = $data->available_qty + $qty;
                $update     = array(
                    'available_qty' => $update_qty,
                );
                $this->db->where('id', $stock_id);
                $this->db->update('franchisee_stock', $update);

            }
            $no++;
        }
        ################ INVOICE ENTRY ############################


        $fran_data    = $this->db_model->select_multi('name, business_name, address, state, phone', 'franchisee', array('id' => $fran_id));
        $invoice_name = "Franchisee Stock Transfer Bill";
        $user_id      = $fran_id;
        $invoice_date = date('Y-m-d');
        $user_type    = 'Franchisee';
        $company_add  = config_item('company_address');
        $bill_add     = $fran_data->name . "<br/>" . $fran_data->business_name . "<br/>" . $fran_data->address . "<br/>" . $fran_data->state . "<br/>" . $fran_data->phone . "<br/>";
        $total_amt    = $this->input->post('total_amt');
        $paid_amt     = $this->input->post('paid_amt');

        $no     = 0;
        $array  = array();
        $array2 = array();
        $array3 = array();
        foreach ($_POST['prod_name'] as $name) {
            if ($name !== "") {
                $prodid       = $this->db_model->select_multi('id, dealer_price, gst', 'product', array('prod_name' => $name));
                $dealer_price = $prodid->dealer_price;
                $tax          = ($prodid->dealer_price * $prodid->gst) / 100;

                $item_name = htmlentities($name);
                $price     = $dealer_price;
                $tax       = $tax;
                $qty       = $_POST['qty'][$no];

                $array  += array($item_name => $price);
                $array2 += array($item_name => $tax);
                $array3 += array($item_name => $qty);
            }
            $no++;
        }

        $array  = serialize($array);
        $array2 = serialize($array2);
        $array3 = serialize($array3);
        $params = array(
            'invoice_name'     => $invoice_name,
            'userid'           => $user_id,
            'invoice_data'     => $array,
            'invoice_data_tax' => $array2,
            'invoice_data_qty' => $array3,
            'company_address'  => $company_add,
            'bill_to_address'  => $bill_add,
            'total_amt'        => $total_amt,
            'paid_amt'         => $paid_amt,
            'date'             => $invoice_date,
            'user_type'        => $user_type,
        );
        $this->db->insert('invoice', $params);


        ################ END ENTRY ################################
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Franchisee Stock Updated successfully. Please print invoice from below:</div>');

        redirect('accounting/invoices/');
    }

    public function remove_fran($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('franchisee');
        $this->db->where('franchisee_id', $id);
        $this->db->delete('franchisee_stock');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Franchisee Deleted successfully.</div>');

        redirect('adm-franchisee/manage_fran');
    }

    public function manage_fran()
    {
        $config['base_url']   = site_url('admin/manage_fran');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('franchisee');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, name, username, business_name, country, state, email, phone, address, status')
                 ->from('franchisee')->limit($config['per_page'], $page);

        $data['fran'] = $this->db->get()->result_array();

        $data['title']      = 'Manage Franchisee';
        $data['breadcrumb'] = 'List all Franchisee';
        $data['layout']     = 'franchisee/listfran.php';
        $this->load->view('admin/base', $data);
    }

    public function stock_management()
    {
        $this->db->select('id, name, username, business_name')->from('franchisee')->where('status', 'Active');
        $data['fran']       = $this->db->get()->result();
        $data['title']      = 'Franchisee Stock Management';
        $data['breadcrumb'] = 'Franchisee Stock Management';
        $data['layout']     = 'franchisee/managestock.php';
        $this->load->view('admin/base', $data);

    }


}
