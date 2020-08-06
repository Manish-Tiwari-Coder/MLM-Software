<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without
 * permission. Project Developer: Bidush Sarkar Developed for: Exolim IT Services
 * Pvt Ltd
 **************************************************************************************************/

class Login extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->common_model->__session();

    }

    public function check_session()
    {
        $id = $this->session->admin_id;

        if (trim($id) == "" || trim($this->session->session) == "") {
            return FALSE;
        }
        else {

            return TRUE;
        }
    }

    public function check_member()
    {
        $id = $this->session->user_id;
        if (trim($id) == "" || trim($this->session->session) == "") {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

}
