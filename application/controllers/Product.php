<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{
    /**
     * Check Valid Login or display login page.
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == false) {
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

    public function add_product()
    {
        $this->form_validation->set_rules('prod_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('category', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('prod_price', 'Product Price', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title']      = 'Add Product';
            $data['breadcrumb'] = 'Add Product';
            $data['layout']     = 'product/add_product.php';
            $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
            $data['parents'] = $this->db->get('product_categories')->result_array();
            $this->load->view('admin/base', $data);
        } else {
            $prod_name        = $this->input->post('prod_name');
            $category         = $this->input->post('category');
            $prod_price       = $this->common_model->filter($this->input->post('prod_price'), 'float');
            $dealer_price     = $this->common_model->filter($this->input->post('dealer_price'), 'float');
            $prod_desc        = $this->input->post('prod_desc');
            $pv               = $this->input->post('pv');
            $qty              = $this->input->post('qty');
            $gst              = $this->common_model->filter($this->input->post('gst'), 'float');
            $image            = 'default.jpg';
            $show_on_reg_form = $this->input->post('join_form');
            if ($show_on_reg_form !== "Yes") {
                $show_on_reg_form = "No";
            }
            $direct_income   = $this->common_model->filter($this->input->post('direct_income'), 'float');
            $level_income    = $this->input->post('level_income');
            $matching_income = $this->common_model->filter($this->input->post('matching_income'), 'float');
            $capping         = $this->common_model->filter($this->input->post('capping'), 'float');
            $roi             = $this->common_model->filter($this->input->post('roi'), 'float');
            $roi_frequency   = $this->input->post('roi_frequency');
            $roi_limit       = $this->input->post('roi_limit');

            if (trim($_FILES['img']['name']) !== "") {

                $this->load->library('upload');

                if (!$this->upload->do_upload('img')) {
                    $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">Image not uploaded. Also select category.<br/>' . $this->upload->display_errors() . '</div>');
                    redirect('product/add_product');
                } else {
                    $image_data               = $this->upload->data();
                    $config['image_library']  = 'gd2';
                    $config['source_image']   = $image_data['full_path']; //get original image
                    $config['maintain_ratio'] = true;
                    $config['width']          = 600;
                    $config['height']         = 500;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $image = $image_data['file_name'];
                }
            }
            $data = array(
                'prod_name'       => $prod_name,
                'category'        => $category,
                'prod_price'      => $prod_price,
                'dealer_price'    => $dealer_price,
                'prod_desc'       => $prod_desc,
                'pv'              => $pv,
                'qty'             => $qty,
                'gst'             => $gst,
                'image'           => $image,
                'show_on_regform' => $show_on_reg_form,
                'direct_income'   => $direct_income,
                'level_income'    => $level_income,
                'matching_income' => $matching_income,
                'capping'         => $capping,
                'roi'             => $roi,
                'roi_frequency'   => $roi_frequency,
                'roi_limit'       => $roi_limit,
                'status'          => 'Selling',
            );

            $this->db->insert('product', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Product Added successfully.</div>');
            redirect('product/manage_products');
        }
    }

    public function manage_products()
    {
        $data['title']      = 'Manage Products';
        $data['breadcrumb'] = 'Manage Products';
        $data['layout']     = 'product/manage_products.php';
        $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
        $data['parents'] = $this->db->get('product_categories')->result_array();
        $this->db->select('id, prod_name, prod_price, gst, image, qty, sold_qty, show_on_regform')
            ->order_by('prod_name', 'ASC');
        $data['prod'] = $this->db->get('product')->result_array();
        $this->load->view('admin/base', $data);

    }

    public function view($id)
    {
        $product_data = $this->db_model->select_multi('*', 'product', array('id' => $id));

        $data['title']      = 'Product Detail';
        $data['breadcrumb'] = 'Manage Products';
        $data['layout']     = 'product/view_product.php';
        $data['data']       = $product_data;
        $this->load->view('admin/base', $data);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('prod_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('category', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('prod_price', 'Product Price', 'trim|required');
        if ($this->form_validation->run() == false) {
            $product_data       = $this->db_model->select_multi('*', 'product', array('id' => $id . $this->input->post('id')));
            $data['title']      = 'Edit Product';
            $data['breadcrumb'] = 'Manage Products';
            $data['layout']     = 'product/edit_product.php';
            $data['data']       = $product_data;
            $data['parents']    = $this->db->get('product_categories')->result_array();
            $this->load->view('admin/base', $data);
        } else {
            $prod_name        = $this->input->post('prod_name');
            $category         = $this->input->post('category');
            $prod_price       = $this->common_model->filter($this->input->post('prod_price'), 'float');
            $dealer_price     = $this->common_model->filter($this->input->post('dealer_price'), 'float');
            $prod_desc        = $this->input->post('prod_desc');
            $pv               = $this->input->post('pv');
            $qty              = $this->input->post('qty');
            $status           = $this->input->post('status');
            $gst              = $this->common_model->filter($this->input->post('gst'), 'float');
            $image            = $old_img = $this->input->post('image');
            $show_on_reg_form = $this->input->post('join_form');
            if ($show_on_reg_form !== "Yes") {
                $show_on_reg_form = "No";
            }
            $direct_income   = $this->common_model->filter($this->input->post('direct_income'), 'float');
            $level_income    = $this->input->post('level_income');
            $matching_income = $this->common_model->filter($this->input->post('matching_income'), 'float');
            $capping         = $this->common_model->filter($this->input->post('capping'), 'float');
            $roi             = $this->common_model->filter($this->input->post('roi'), 'float');
            $roi_frequency   = $this->input->post('roi_frequency');
            $roi_limit       = $this->input->post('roi_limit');

            if (trim($_FILES['img']['name'] !== "")) {

                $this->load->library('upload');

                if (!$this->upload->do_upload('img')) {
                    $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">Image not uploaded. Also select category.<br/>' . $this->upload->display_errors() . '</div>');
                    redirect('product/edit_product/' . $id . $this->input->post('id'));
                } else {
                    $image_data               = $this->upload->data();
                    $config['image_library']  = 'gd2';
                    $config['source_image']   = $image_data['full_path']; //get original image
                    $config['maintain_ratio'] = true;
                    $config['width']          = 600;
                    $config['height']         = 500;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $image = $image_data['file_name'];
                    if (trim($image_data['file_name']) !== "") {
                        unlink(FCPATH . '/uploads/' . $old_img);
                    }
                }
            }
            $data = array(
                'prod_name'       => $prod_name,
                'category'        => $category,
                'prod_price'      => $prod_price,
                'dealer_price'    => $dealer_price,
                'prod_desc'       => $prod_desc,
                'pv'              => $pv,
                'qty'             => $qty,
                'gst'             => $gst,
                'image'           => $image,
                'show_on_regform' => $show_on_reg_form,
                'direct_income'   => $direct_income,
                'level_income'    => $level_income,
                'matching_income' => $matching_income,
                'capping'         => $capping,
                'roi'             => $roi,
                'roi_frequency'   => $roi_frequency,
                'roi_limit'       => $roi_limit,
                'status'          => $status,
            );

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('product', $data);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Product Updated successfully.</div>');
            redirect('product/manage_products');
        }
    }

    public function remove($id)
    {
        $count = $this->db_model->count_all('product_sale', array(
            'product_id' => $id,
            'status'     => 'Processing',
        ));
        if ($count > 0) {
            $this->session->set_flashdata('common_flash', '<div class="alert alert-danger">Product Cannot be deleted as there are ' . $count . ' Un-Delivered Orders.</div>');
            redirect('product/manage_products');
        } else {
            $img = $this->db_model->select('image', 'product', array('id' => $id));
            $this->db->where('id', $id);
            $this->db->delete('product');
            unlink(FCPATH . '/uploads/' . $img);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Product Deleted successfully.</div>');
            redirect('product/manage_products');
        }
    }

    public function search_product()
    {
        $data['title']      = 'Search Product';
        $data['breadcrumb'] = 'Search Product';
        $data['layout']     = 'product/search_product.php';
        $this->db->select('id, cat_name')->order_by('cat_name', 'ASC');
        $data['parents'] = $this->db->get('product_categories')->result_array();
        $this->load->view('admin/base', $data);
    }

    public function search()
    {
        $category   = $this->input->post('category');
        $pname      = $this->input->post('pname');
        $status     = $this->input->post('status');
        $is_sign_up = $this->input->post('is_sign_up');

        $this->db->select('id, prod_name, prod_price, gst, image, qty, sold_qty, show_on_regform')
            ->order_by('prod_name', 'ASC');
        if ($category !== "All") {
            $this->db->where('category', $category);
        }
        if (trim($pname) !== "") {
            $this->db->like('prod_name', $pname);
        }
        if ($status !== "All") {
            $this->db->where('status', $status);
        }
        if ($is_sign_up !== "All") {
            $this->db->where('show_on_regform', $is_sign_up);
        }
        $data['prod']       = $this->db->get('product')->result_array();
        $data['title']      = 'Search Results';
        $data['breadcrumb'] = 'Search Products';
        $data['layout']     = 'product/manage_products.php';
        $this->load->view('admin/base', $data);
    }

    public function pending_orders()
    {
        $config['base_url']   = site_url('product/pending-orders');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('product_sale', array('status' => 'Processing'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $data['title']      = 'Pending Orders';
        $data['breadcrumb'] = 'Pending Orders';
        $data['layout']     = 'product/orders.php';
        $this->db->where('status', 'Processing')->order_by('date', 'ASC')->limit($config['per_page'], $page);
        $data['orders'] = $this->db->get('product_sale')->result();
        $this->load->view('admin/base', $data);
    }

    public function completed_orders()
    {

        $config['base_url']   = site_url('product/pending-orders');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('product_sale', array('status' => 'Processing'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $data['title']      = 'Completed Orders';
        $data['breadcrumb'] = 'Completed Orders';
        $data['layout']     = 'product/orders.php';
        $this->db->where('status', 'Completed')->order_by('date', 'ASC')->limit($config['per_page'], $page);
        $data['orders'] = $this->db->get('product_sale')->result();
        $this->load->view('admin/base', $data);
    }

    public function all_orders()
    {

        $config['base_url']   = site_url('product/all-orders');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('product_sale');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $data['title']      = 'All Orders';
        $data['breadcrumb'] = 'List All Orders';
        $data['layout']     = 'product/orders.php';
        $this->db->order_by('date', 'ASC')->limit($config['per_page'], $page);
        $data['orders'] = $this->db->get('product_sale')->result();
        $this->load->view('admin/base', $data);
    }

    public function view_order($id)
    {

        $data['layout'] = 'product/view_order.php';
        $data['orders'] = $this->db_model->select_multi('*', 'product_sale', array('id' => $id));
        $this->load->view('admin/base', $data);
    }

    public function deliver()
    {
        $orderid = $this->input->post('deliverid');
        $tdetail = $this->input->post('tdetail');

        $data = array(
            'status'       => 'Completed',
            'deliver_date' => date('Y-m-d'),
            'tid'          => $tdetail,
        );
        $this->db->where('id', $orderid);
        $this->db->update('product_sale', $data);
        $this->load->model('earning');
        $this->earning->repurchase($orderid);

        ############ INVOICE ENTRY #################################

        $order_detail  = $this->db_model->select_multi('product_id, userid, cost, qty', 'product_sale', array('id' => $orderid));
        $member_detail = $this->db_model->select_multi('name, address, phone, topup', 'member', array('id' => $order_detail->userid));

        $gettop = $member_detail->topup + $order_detail->cost;
        $topup  = array(
            'topup' => $gettop,
        );
        $this->db->where('id', $order_detail->userid);
        $this->db->update('member', $topup);
        $invoice_name = 'Sale Invoice';
        $user_id      = $order_detail->userid;
        $invoice_date = date('Y-m-d');
        $user_type    = 'Member';
        $company_add  = config_item('company_address');
        $bill_add     = $member_detail->name . "<br/>" . $member_detail->address . "<br/>" . $member_detail->phone;
        $total_amt    = $order_detail->cost;
        $paid_amt     = $order_detail->cost;
        $prod_detail  = $this->db_model->select_multi('prod_name, prod_price, gst', 'product', array('id' => $order_detail->product_id));
        $item_name    = $prod_detail->prod_name;
        $price        = $prod_detail->prod_price;
        $tax          = $prod_detail->gst;
        $qty          = $order_detail->qty;

        $array  = array($item_name => $price);
        $array2 = array($item_name => $tax);
        $array3 = array($item_name => $qty);

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


        ########## END ENTRY #######################################
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Order Marked as Delivered successfully.</div>');
        redirect('product/pending_orders');
    }

    public function remove_order($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('product_sale');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Order Deleted successfully.</div>');
        redirect('product/all_orders');
    }
}
