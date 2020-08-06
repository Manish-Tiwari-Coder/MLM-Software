<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Help_plan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->common_model->__session();
    }

    public function first_help($user_id, $sponsor_id, $position_id)
    {
        $this->db->select('id, donation_level, sponsor_income, position_income, donation_amount, donation_qty, expiry_duration')
                 ->from('donation_package')
                 ->order_by('donation_level', 'ASC')
                 ->limit(1);
        $data            = $this->db->get()->row();
        $donation_pack   = $data->id;
        $donation_level  = $data->donation_level;
        $sponsor_income  = $data->sponsor_income;
        $position_income = $data->position_income;
        $donation_amount = $data->donation_amount;
        $expiry_duration = date('Y-m-d', strtotime('+' . $data->expiry_duration . ' days'));

        $donation_sponsor = $this->get_sponsor($user_id, $donation_level);

        if ($sponsor_income > 0) {
            $this->send_donation($user_id, $sponsor_id, $sponsor_income, $donation_pack, $expiry_duration);
        }
        if ($position_income > 0) {
            $this->send_donation($user_id, $position_id, $position_income, $donation_pack, $expiry_duration);
        }
        if ($donation_amount > 0) {
            $this->send_donation($user_id, $donation_sponsor, $donation_amount, $donation_pack, $expiry_duration);
        }
    }

    private function get_sponsor($user_id, $donation_level)
    {
        $result = $this->db_model->select_multi('id, sponsor, gift_level', 'member', array('id' => $user_id));
        if ($result->gift_level == $donation_level || $result->id == config_item('top_id')) {
            $id = $result->id;
        }
        else {
            $id = $this->get_sponsor($result->sponsor, $donation_level);
        }

        return $id;
    }

    private function send_donation($sender_id, $receiver_id, $amount, $donation_pack, $expiry_date)
    {
        $array = array(
            'sender_id'       => $sender_id,
            'donation_amount' => $amount,
            'receiver_id'     => $receiver_id,
            'time'            => time(),
            'donation_pack'   => $donation_pack,
            'expiry_date'     => $expiry_date,
        );

        $this->db->insert('donations', $array);

    }

    public function generate_donation($user_id)
    {
        $level       = $this->db_model->select_multi('sponsor, position, gift_level', 'member', array('id' => $user_id));
        $sponsor_id  = $level->sponsor;
        $position_id = $level->position;
        $level       = $level->gift_level + 1;
        $this->db->select('id, donation_level, sponsor_income, position_income, donation_amount, donation_qty, expiry_duration')
                 ->from('donation_package')
                 ->where('donation_level', $level)
                 ->limit(1);
        $data            = $this->db->get()->row();
        $donation_pack   = $data->id;
        $donation_level  = $data->donation_level;
        $sponsor_income  = $data->sponsor_income;
        $position_income = $data->position_income;
        $donation_amount = $data->donation_amount;
        $expiry_duration = date('Y-m-d', strtotime('+' . $data->expiry_duration . ' days'));

        $donation_sponsor = $this->get_sponsor($user_id, $level);

        if ($sponsor_income > 0) {
            $this->send_donation($user_id, $sponsor_id, $sponsor_income, $donation_pack, $expiry_duration);
        }
        if ($position_income > 0) {
            $this->send_donation($user_id, $position_id, $position_income, $donation_pack, $expiry_duration);
        }
        if ($donation_amount > 0) {
            $this->send_donation($user_id, $donation_sponsor, $donation_amount, $donation_pack, $expiry_duration);
        }
    }

}
