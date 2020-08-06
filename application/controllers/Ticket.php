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
class Ticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->model('plan_model');
    }


    public function new_ticket()
    {
        $this->form_validation->set_rules('ticket_title', 'Ticket Title', 'trim|required');
        $this->form_validation->set_rules('ticket_data', 'Ticket Data', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['title']  = 'New Support Request';
            $data['layout'] = 'support/new.php';
            $this->load->view('member/base', $data);
        }
        else {
            $array = array(
                'ticket_title'  => $this->input->post('ticket_title'),
                'ticket_detail' => $this->input->post('ticket_data'),
                'userid'        => $this->session->user_id,
                'date'          => date('Y-m-d'),
            );
            $this->db->insert('ticket', $array);

            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">A New Ticket has been opened.</div>');
            redirect('ticket/old-Supports');
        }
    }

    public function old_Supports()
    {
        $this->load->library('pagination');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('ticket', array('userid' => $this->session->user_id));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->select('id, ticket_title, date, status');
        $this->db->where(array('userid' => $this->session->user_id));
        $this->db->order_by('id', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['data']   = $this->db->get('ticket')->result();
        $data['layout'] = 'support/all_ticket.php';
        $this->load->view('member/base', $data);
    }

    public function view($id)
    {
        $this->form_validation->set_rules('ticket_reply', 'Ticket Reply Message', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $data['detail'] = $this->db_model->select_multi('id, ticket_title, ticket_detail, status, date', 'ticket', array('id' => $id));
            $data['layout'] = 'support/ticket_view.php';
            $folder         = $this->session->user_id ? 'member' : 'admin';
            $this->load->view($folder . '/base', $data);
        }
        else {
            $array = array(
                'ticket_id' => $this->input->post('ticket_id'),
                'msg_from'  => $this->session->user_id ? $this->session->user_id : 'Admin',
                'msg'       => $this->input->post('ticket_reply'),
            );

            $this->db->insert('ticket_reply', $array);

            $array = array(
                'status' => $this->session->user_id ? 'Customer Reply' : 'Waiting User Reply',
            );
            $this->db->where('id', $this->input->post('ticket_id'));
            $this->db->update('ticket', $array);
            $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Message sent.</div>');
            redirect('ticket/view/' . $this->input->post('ticket_id'));
        }

    }

    public function close($id)
    {
        $array = array(
            'status' => 'Closed',
        );
        $this->db->where('id', $id);
        $this->db->update('ticket', $array);

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Ticket Marked as solved and closed..</div>');
        $this->session->user_id ? redirect('ticket/old-Supports') : redirect('ticket/resolved');
    }

    ################# ADMIN WORKS #########################

    public function unsolved()
    {
        $this->load->library('pagination');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('ticket', array('status !=' => 'Closed'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->select('id, ticket_title, date, status');
        $this->db->where(array('status !=' => 'Closed'));
        $this->db->order_by('id', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['data']   = $this->db->get('ticket')->result();
        $data['layout'] = 'support/all_ticket.php';
        $this->load->view('admin/base', $data);

    }

    public function resolved()
    {
        $this->load->library('pagination');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('ticket', array('status' => 'Closed'));
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);
        $this->db->select('id, ticket_title, date, status');
        $this->db->where(array('status' => 'Closed'));
        $this->db->order_by('id', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['data']   = $this->db->get('ticket')->result();
        $data['layout'] = 'support/all_ticket.php';
        $this->load->view('admin/base', $data);

    }

}
