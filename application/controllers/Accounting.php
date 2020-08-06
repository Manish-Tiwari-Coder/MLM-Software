<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounting extends CI_Controller
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


    public function add_invoice()
    {
        $invoice_name = $this->input->post('invoice_name');
        $user_id      = $this->input->post('user_id');
        $invoice_date = $this->input->post('invoice_date');
        $user_type    = $this->input->post('user_type');
        $company_add  = $this->input->post('company_add');
        $bill_add     = $this->input->post('bill_add');
        $total_amt    = $this->input->post('total_amt');
        $paid_amt     = $this->input->post('paid_amt');

        $no     = 0;
        $array  = array();
        $array2 = array();
        $array3 = array();
        foreach ($_POST['item_name'] as $name) {
            if ($name !== "") {
                $item_name = htmlentities($name);
                $price     = $_POST['item_price'][$no];
                $tax       = $_POST['item_tax'][$no];
                $qty       = $_POST['item_qty'][$no] ? $_POST['item_qty'][$no] : 1;

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

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Invoice Created successfully.</div>');

        redirect('accounting/invoices');
    }

    public function add_purchase()
    {
        $bill_no   = $this->input->post('bill_no');
        $date      = $this->input->post('date');
        $supplier  = $this->input->post('supplier');
        $bill_amt  = $this->input->post('bill_amt');
        $paid_amt  = $this->input->post('paid_amt');
        $bill_copy = "";

        if (trim($_FILES['copy']['name']) !== "") {
            $bill_copy = time() . "+" . $_FILES['copy']['name'];
            move_uploaded_file($_FILES['copy']['tmp_name'], FCPATH . "uploads/" . $bill_copy);
        }
        $no    = 0;
        $array = array();
        foreach ($_POST['item_name'] as $name) {
            if ($name !== "") {
                $item_name = htmlentities($name);
                $price     = $_POST['item_price'][$no];

                $array += array($item_name => $price);
            }
            $no++;
        }
        $array  = serialize($array);
        $params = array(
            'bill_no'        => $bill_no,
            'date'           => $date,
            'supplier'       => $supplier,
            'bill_amt'       => $bill_amt,
            'paid_amt'       => $paid_amt,
            'purchased_data' => $array,
            'bill_copy'      => $bill_copy,
        );
        $this->db->insert('purchase', $params);

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Purchase Entry Created successfully.</div>');

        redirect('accounting/purchase');
    }

    public function invoice_view($id)
    {
        $data['result'] = $this->db_model->select_multi('*', 'invoice', array('id' => $id));
        $this->load->view('admin/accounting/print_invoice.php', $data);
    }


    public function purchase_view($id)
    {
        $data['result']     = $this->db_model->select_multi('*', 'purchase', array('id' => $id));
        $data['title']      = 'Purchase Detail';
        $data['breadcrumb'] = 'Purchase Detail';
        $data['layout']     = 'accounting/purchase_view.php';
        $this->load->view('admin/base', $data);
    }

    public function transactionlogs()
    {
        $config['base_url']   = site_url('accounting/transactionlogs');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('transaction');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('transaction')->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $data['result']     = $this->db->get()->result();
        $data['title']      = 'Transaction Logs';
        $data['breadcrumb'] = 'Transaction Logs';
        $data['layout']     = 'accounting/transactionlogs.php';
        $this->load->view('admin/base', $data);
    }


    public function remove_tlog($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('transaction');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Record Deleted successfully.</div>');

        redirect('accounting/transactionlogs');
    }

    public function remove_invoice($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('invoice');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Invoice Deleted successfully.</div>');

        redirect('accounting/invoices');
    }

    public function remove_purchase($id)
    {
        $bill_copy = $this->db_model->select('bill_copy', 'purchase', array('id' => $id));
        unlink(FCPATH . "uploads/" . $bill_copy);
        $this->db->where('id', $id);
        $this->db->delete('purchase');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Purchase Record/Bill Deleted successfully.</div>');

        redirect('accounting/purchase');
    }


    public function invoices()
    {
        $config['base_url']   = site_url('accounting/invoices');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('invoice');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('invoice')->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $data['invoice']    = $this->db->get()->result();
        $data['title']      = 'Invoices';
        $data['breadcrumb'] = 'Invoices';
        $data['layout']     = 'accounting/invoices.php';
        $this->load->view('admin/base', $data);

    }

    public function invoice_add_fund()
    {
        $array = array(
            'paid_amt' => $this->input->post('paid_amt') + $this->db_model->select('paid_amt', 'invoice', array('id' => $this->input->post('id'))),
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('invoice', $array);

        $data = array(
            'userid'         => $this->input->post('id'),
            'amount'         => $this->input->post('paid_amt'),
            'gateway'        => 'Invoice',
            'time'           => time(),
            'transaction_id' => 'Manual Entry',
        );
        $this->db->insert('transaction', $data);

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Fund added to invoice successfully.</div>');

        redirect('accounting/invoices');
    }

    public function bill_add_fund()
    {
        $array = array(
            'paid_amt' => $this->input->post('paid_amt') + $this->db_model->select('paid_amt', 'purchase', array('id' => $this->input->post('id'))),
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('purchase', $array);

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Balance Paid against bill successfully.</div>');

        redirect('accounting/purchase');
    }

    public function search_invoice()
    {

        if (trim($this->input->post('userid')) !== "") {
            $this->db->where('userid', $this->input->post('userid'));
        }
        if (trim($this->input->post('sdate')) !== "") {
            $this->db->where('date >=', $this->input->post('sdate'));
        }
        if (trim($this->input->post('edate')) !== "") {
            $this->db->where('date <=', $this->input->post('edate'));
        }

        $this->db->from('invoice')->order_by('id', 'DESC');
        $data['invoice']    = $this->db->get()->result();
        $data['title']      = 'Invoices';
        $data['breadcrumb'] = 'Invoices';
        $data['layout']     = 'accounting/invoices.php';
        $this->load->view('admin/base', $data);
    }

    public function search_purchase()
    {

        if (trim($this->input->post('billno')) !== "") {
            $this->db->where('bill_no', $this->input->post('billno'));
        }
        if (trim($this->input->post('sdate')) !== "") {
            $this->db->where('date >=', $this->input->post('sdate'));
        }
        if (trim($this->input->post('edate')) !== "") {
            $this->db->where('date <=', $this->input->post('edate'));
        }

        $this->db->from('purchase')->order_by('id', 'DESC');
        $data['bills']      = $this->db->get()->result();
        $data['title']      = 'Purchase Records';
        $data['breadcrumb'] = 'Purchases';
        $data['layout']     = 'accounting/purchase.php';
        $this->load->view('admin/base', $data);
    }

    public function accounting()
    {

        $data['title']      = 'Accounting';
        $data['breadcrumb'] = 'Accounting';
        $data['layout']     = 'accounting/accounting_dash.php';
        $this->load->view('admin/base', $data);
    }


    public function purchase()
    {
        $config['base_url']   = site_url('accounting/purchase');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('purchase');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->from('purchase')->order_by('id', 'DESC')->limit($config['per_page'], $page);
        $data['bills']      = $this->db->get()->result();
        $data['title']      = 'Purchase Records';
        $data['breadcrumb'] = 'Purchases';
        $data['layout']     = 'accounting/purchase.php';
        $this->load->view('admin/base', $data);

    }

}
