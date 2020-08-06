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
class Survey extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->login->check_session() == FALSE && $this->login->check_member() == FALSE) {
            redirect(site_url('site/login'));
        }
        $this->load->library('pagination');
    }

    public function manage_survey()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }

        $config['base_url']   = site_url('survey/manage_survey');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('survey');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, survey_name, expiry_date, type')->from('survey')->order_by('id', 'DESC')
                 ->limit($config['per_page'], $page);

        $data['survey'] = $this->db->get()->result();

        $data['title']      = 'Manage Surveys';
        $data['breadcrumb'] = 'Manage Surveys';
        $data['layout']     = 'survey/manage_survey.php';
        $this->load->view('admin/base', $data);
    }

    public function create()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $survey_name   = $this->input->post('survey_name');
        $level_earning = $this->input->post('level_earning');
        $expiry_date   = $this->input->post('expiry_date');
        $type          = $this->input->post('type');
        $codes         = $this->input->post('thirdparty_url');

        $array = array();
        $no    = 0;
        foreach ($_POST['qust'] as $name) {
            if ($name !== "") {
                $qusestion = htmlentities($name);
                $ans       = $_POST['ans'][$no];

                $array += array($qusestion => $ans);
            }
            $no++;
        }
        if ($type == "Hosted Survey") {
            $codes = serialize($array);
        }

        $array = array(
            'survey_name'      => $survey_name,
            'question_answers' => $codes,
            'level_earning'    => $level_earning,
            'expiry_date'      => $expiry_date,
            'type'             => $type,
        );

        $this->db->insert('survey', $array);

        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">New Survey Added Successfully.</div>');
        redirect('survey/manage_survey');
    }

    public function remove($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $this->db->where('id', $id);
        $this->db->delete('survey');
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Survey Deleted successfully.</div>');

        redirect('survey/manage_survey');
    }


    public function preview($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $data = $this->db_model->select_multi('question_answers, type', 'survey', array('id' => $id));
        if ($data->type == "Third Party") {
            redirect(trim($data->question_answers));
        }
        else {
            echo '<link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><div class="container" 
          style="max-width: 600px"><h3 align="center">Just a Preview. Original will look much better :)</h3>';
            $data = unserialize($data->question_answers);
            foreach ($data as $e => $v) {
                echo '<div><h3 class="alert alert-info">' . $e . '</h3>';
                echo '<strong>Your Answer: </strong><br/>';
                if (trim($v) == ""):
                    echo '<input type="text" class="form-control" name="' . $e . '_ans">';
                else:
                    foreach (explode(',', $v) as $ans):
                        echo '<input type="radio" value="' . $ans . '" name="' . $e . '_ans">' . $ans . '<br/>';
                    endforeach;
                endif;
                echo '</div>';
            }
            echo '</div>';
        }
    }


    public function survey_report()
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        if (trim($this->input->post('userid')) !== "") {
            $where = array('userid' => $this->common_model->filter($this->input->post('userid')));
        }
        else {
            $where = 1;
        }

        $config['base_url']   = site_url('survey/survey_report');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('survey_user', $where);
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, survey_id, userid, date')->from('survey_user')->order_by('id', 'DESC')
                 ->limit($config['per_page'], $page);

        if (trim($this->input->post('userid')) !== "") {
            $this->db->where(array('userid' => $this->common_model->filter($this->input->post('userid'))));
        }

        $data['surveys']    = $this->db->get()->result();
        $data['title']      = 'Submitted Surveys';
        $data['breadcrumb'] = 'Submitted Surveys';
        $data['layout']     = 'survey/surveys.php';
        $this->load->view('admin/base', $data);
    }

    public function view_data($id)
    {
        if ($this->login->check_session() == FALSE) {
            exit('<h3 align="center">Yuk !! Go and have a bath..</h3>');
        }
        $datas = $this->db_model->select_multi('id, survey_name, question_answers, type', 'survey', array('id' => $id));
        if ($datas->type == "Third Party") {
            redirect(trim($datas->question_answers));
        }
        else {

            $data['data']   = $this->db_model->select_multi('data, date', 'survey_user', array(
                'survey_id' => $id,
            ));
            $data['title']  = 'View Submitted Survey';
            $data['layout'] = 'survey/view.php';
            $this->load->view('admin/base', $data);

        }
    }

    ################ MEMBER #############################
    public function mysurveys()
    {
        $config['base_url']   = site_url('survey/mysurveys');
        $config['per_page']   = 50;
        $config['total_rows'] = $this->db_model->count_all('survey');
        $page                 = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->pagination->initialize($config);

        $this->db->select('id, survey_name, expiry_date')->from('survey')->order_by('id', 'DESC')
                 ->limit($config['per_page'], $page);

        $data['survey']     = $this->db->get()->result();
        $data['title']      = 'My Surveys';
        $data['breadcrumb'] = 'My Surveys';
        $data['layout']     = 'survey/mysurveys.php';
        $this->load->view('member/base', $data);
    }

    public function survey_view($id)
    {
        $datas = $this->db_model->select_multi('id, survey_name, question_answers, level_earning, type', 'survey', array('id' => $id));
        if ($datas->type == "Third Party") {
            if (trim($datas->level_earning) !== "") {
                $this->load->model('earning');
                $this->earning->survey_level($this->session->user_id, $id, $datas->level_earning);
            }
            redirect(trim($datas->question_answers));
        }
        else {
            $data['data']       = $datas;
            $data['title']      = 'Fill the Survey';
            $data['breadcrumb'] = 'Fill the Survey';
            $data['layout']     = 'survey/fillup.php';
            $this->load->view('member/base', $data);
        }

    }

    public function submit($id)
    {
        $datas = $this->db_model->select_multi('question_answers, level_earning', 'survey', array('id' => $id));

        $array = array();
        foreach ($_POST as $name => $val) {
            if ($name !== "") {
                $questions = htmlentities($name);
                $array     += array($questions => $val);
            }
        }
        if (trim($datas->level_earning) !== "") {
            $this->load->model('earning');
            $this->earning->survey_level($this->session->user_id, $id, $datas->level_earning, serialize($array));
        }
        $this->session->set_flashdata('common_flash', '<div class="alert alert-success">Thank you for submitting the survey.</div>');

        redirect('survey/mysurveys');

    }

    public function view($id)
    {
        $datas = $this->db_model->select_multi('id, survey_name, question_answers, type', 'survey', array('id' => $id));
        if ($datas->type == "Third Party") {
            redirect(trim($datas->question_answers));
        }
        else {

            $data['data']   = $this->db_model->select_multi('data, date', 'survey_user', array(
                'survey_id' => $id,
                'userid'    => $this->session->user_id,
            ));
            $data['title']  = 'View Submitted Survey';
            $data['layout'] = 'survey/view.php';
            $this->load->view('member/base', $data);

        }
    }

}