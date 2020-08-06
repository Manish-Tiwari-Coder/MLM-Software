<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Franchisee extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->fran_id == "") {
            redirect(site_url('site/franchisee'));
        }
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['title']      = 'Dashboard';
        $data['breadcrumb'] = 'dashboard';
        $this->load->view('franchisee/base', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('site_flash', '<div class="alert alert-info">You have been logged out !</div>');
        redirect(site_url('site/franchisee'));
    }

    // CORE MEMBER PARTS HERE NOW ############################################################ STARTS :


    public function sale_product()
    {
        $this->form_validation->set_rules('pname', 'Product', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']  = 'Sale Product';
            $data['layout'] = 'product/sale.php';
            $this->load->view('franchisee/base', $data);
        }
        else {
            $user_id      = $this->common_model->filter($this->input->post('userid'));
            $no           = 0;
            $total_amount = 0;
            $array        = array();
            $array2       = array();
            foreach ($_POST['prod_name'] as $name) {
                if ($name !== "") {
                    $prodid       = htmlentities($name);
                    $qty          = $_POST['qty'][$no];
                    $dealer_price = $this->db_model->select('prod_price', 'product', array('id' => $prodid));
                    $data         = $this->db_model->select_multi('id, available_qty', 'franchisee_stock', array(
                        'franchisee_id' => $this->session->fran_id,
                        'product_id'    => $prodid,
                    ));
                    $total_amount += $dealer_price;
                    $array        += array($prodid => $_POST['qty'][$no]);
                    $array2       += array($prodid => $dealer_price);

                    if ($_POST['qty'][$no] > $data->available_qty) {
                        $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">Your Stock has lower unit available the entered.</div>');

                        redirect('franchisee/sale_product/');
                    }

                    $update_qty = $data->available_qty - $qty;
                    $update     = array(
                        'available_qty' => $update_qty,
                    );
                    $this->db->where('id', $data->id);
                    $this->db->update('franchisee_stock', $update);
                    $data = array(
                        'product_id'    => $prodid,
                        'userid'        => $user_id,
                        'cost'          => $dealer_price,
                        'franchisee_id' => $this->session->fran_id,
                        'date'          => date('Y-m-d'),
                        'deliver_date'  => date('Y-m-d'),
                        'status'        => 'Completed',
                        'qty'           => $qty,
                    );
                    $this->db->insert('product_sale', $data);
                    $this->load->model('earning');
                    $this->earning->repurchase($this->db->insert_id());
                }
                $no++;
            }
            $array  = serialize($array);
            $array2 = serialize($array2);
            $params = array(
                'stock_data'       => $array,
                'stock_data_price' => $array2,
                'fran_id'          => $this->session->fran_id,
                'date'             => date('Y-m-d'),
                'userid'           => $user_id,
            );
            $this->db->insert('franchisee_stock_sale_bill', $params);
            $invid = $this->db->insert_id();


            ################ INVOICE ENTRY ############################


            $fran_data    = $this->db_model->select_multi('name, business_name, address, state, phone', 'franchisee', array('id' => $this->session->fran_id));
            $invoice_name = "Purchase Bill";
            $user_id      = $this->session->fran_id;
            $invoice_date = date('Y-m-d');
            $user_type    = 'Member';
            $company_add  = config_item('company_address');
            $bill_add     = $fran_data->name . "<br/>" . $fran_data->business_name . "<br/>" . $fran_data->address . "<br/>" . $fran_data->state . "<br/>" . $fran_data->phone . "<br/>";
            $total_amt    = $total_amount;
            $paid_amt     = $total_amount;

            $no     = 0;
            $array  = array();
            $array2 = array();
            $array3 = array();
            foreach ($_POST['prod_name'] as $name) {
                if ($name !== "") {
                    $prodid       = $this->db_model->select_multi('id, prod_name, prod_price, gst', 'product', array('id' => $name));
                    $dealer_price = $prodid->prod_price;
                    $tax          = ($prodid->prod_price * $prodid->gst) / 100;

                    $item_name = $prodid->prod_name;
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


            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Sale made successfully.</div>');

             redirect('franchisee/invoice/' . $invid);

        }

    }

    public function invoice($id)
    {
        $data['result']     = $this->db_model->select_multi('fran_id, stock_data, stock_data_price, userid, date', 'franchisee_stock_sale_bill', array('id' => $id));
        $data['title']      = 'Invoice : #' . $id;
        $data['breadcrumb'] = 'Invoice';
        $data['layout']     = 'product/invoice.php';
        $this->load->view('franchisee/base', $data);
    }

    public function my_invoices()
    {
        $config['base_url']   = site_url('franchisee/my_invoices');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('invoice', array(
            'userid'    => $this->session->fran_id,
            'user_type' => 'Franchisee',
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('invoice')->where(array(
                                              'userid'    => $this->session->fran_id,
                                              'user_type' => 'Franchisee',
                                          ))->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $data['invoice']    = $this->db->get()->result();
        $data['title']      = 'My Invoices';
        $data['breadcrumb'] = 'My Invoices';
        $data['layout']     = 'invoice/my_invoices.php';
        $this->load->view('franchisee/base', $data);
    }

    public function invoice_view($id)
    {
        $data['result'] = $this->db_model->select_multi('*', 'invoice', array('id' => $id));
        $this->load->view('franchisee/invoice/print_invoice.php', $data);
    }


    public function print_fran_invoice($id)
    {
        $data['result'] = $this->db_model->select_multi('fran_id, stock_data, stock_data_price, userid, date', 'franchisee_stock_sale_bill', array('id' => $id));
        $this->load->view('franchisee/product/invoice_print', $data);
    }

    public function sale_history()
    {
        $this->load->library('pagination');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('product_sale', array('franchisee_id' => $this->session->fran_id));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->select('product_id, userid, cost, qty, deliver_date');
        $this->db->where(array('franchisee_id' => $this->session->fran_id));
        $this->db->order_by('id', 'DESC');
        $this->db->limit($config['per_page'], $page);

        $data['data'] = $this->db->get('product_sale')->result();

        $data['title']  = 'Sale History';
        $data['layout'] = 'product/sale_history.php';
        $this->load->view('franchisee/base', $data);
    }

    public function profile()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['result']     = $this->db_model->select_multi('name, email, phone', 'franchisee', array('id' => $this->session->fran_id));
            $data['title']      = 'My Profile';
            $data['breadcrumb'] = 'Profile';
            $data['layout']     = 'misc/profile.php';
            $this->load->view('franchisee/base', $data);
        }
        else {

            $array = array(
                'name'  => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
            );
            if (trim($this->input->post('newpass')) !== "") {
                $array = $array + array("password" => $this->input->post('newpass'));
            }
            $this->db->where('id', $this->session->fran_id);
            $this->db->update('franchisee', $array);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Profile updated successfully.</div>');

            redirect('franchisee/profile/');
        }
    }

    public function unused_epin()
    {

        $config['base_url']   = site_url('franchisee/unused_epin');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('epin', array(
            'status'   => 'Un-used',
            'issue_to' => $this->session->fran_id,
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, issue_to, generate_time, generate_time, type')->from('epin')->where(array(
                                                                                                                     'status'   => 'Un-used',
                                                                                                                     'issue_to' => $this->session->fran_id,
                                                                                                                 ))
                 ->limit($config['per_page'], $page);

        $data['epin'] = $this->db->get()->result_array();

        $data['title']      = 'Unused e-PINs';
        $data['breadcrumb'] = 'Un-used e-pin';
        $data['layout']     = 'epin/unused.php';
        $this->load->view('franchisee/base', $data);
    }

    public function used_epin()
    {

        $config['base_url']   = site_url('franchisee/used_epin');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('epin', array(
            'status'   => 'Used',
            'issue_to' => $this->session->fran_id,
        ));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, epin, amount, used_by, used_time, type')->from('epin')->where(array(
                                                                                                 'status'   => 'Used',
                                                                                                 'issue_to' => $this->session->fran_id,
                                                                                             ))
                 ->limit($config['per_page'], $page);

        $data['epin'] = $this->db->get()->result_array();

        $data['title']      = 'Used e-PINs';
        $data['breadcrumb'] = 'Used e-pin';
        $data['layout']     = 'epin/used.php';
        $this->load->view('franchisee/base', $data);
    }


}