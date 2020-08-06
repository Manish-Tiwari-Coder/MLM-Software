<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Investment extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->common_model->__session();
    }

    public function generate()
    {
        $this->roi_earning();
    }

    public function roi_earning()
    {
        $this->db->select('userid,pack_id,amount')->from('investments')->where(array('status'  => "Active",
                                                                                     'date !=' => date('Y-m-d'),
                                                                               ));
        $users = $this->db->get()->result();
        foreach ($users as $users):
            $userid        = $users->userid;
            $roi           = $this->db_model->select_multi('roi,roi_limit,roi_frequency,based', 'investment_pack', array('id' => $users->pack_id));
            $roi_frequency = $roi->roi_frequency;
            $roi_limit     = $roi->roi_limit;
            $based         = $roi->based;
            $roi           = $roi->roi;
            if ($based == "Percent") {
                $roi = ($users->amount * $roi) / 100;
            }
            if ($roi > 0) {
                $get_last_roi = $this->db_model->select('date', 'earning', array(
                    'userid' => $userid,
                    'type'   => 'ROI',
                    'secret' => $users->pack_id,
                ));
                $date         = date('Y-m-d', strtotime($get_last_roi) + (86400 * $roi_frequency));
                if (date('Y-m-d') >= $date) {
                    if ($this->db_model->count_all('earning', array(
                            'userid' => $userid,
                            'type'   => 'ROI',
                            'secret' => $users->pack_id,
                        )) < $roi_limit) {
                        $this->pay_earning($userid, '', 'ROI', $roi, '', $users->pack_id);
                    }
                }
            }

        endforeach;

    }

    public function pay_earning($userid, $ref_id, $income_name, $amount, $pair_match = 0, $secret = 0)
    {
        $data = array(
            'userid'     => $userid,
            'amount'     => $amount,
            'type'       => $income_name,
            'ref_id'     => $ref_id,
            'date'       => date('Y-m-d'),
            'pair_match' => $pair_match,
            'secret'     => $secret,
        );

        $this->db->insert('earning', $data);

        return true;

    }

    public function inv_earning($userid, $sponsor, $packageid, $amount = '')
    {

        ###############################################################
        #
        # Direct or Referal Income First
        #
        ##############################################################
        $packageid = $this->db_model->select('pack_id', 'investments', array('id' => $packageid));
        $data      = $this->db_model->select_multi('amount, direct_income, level_income, matching_income, based', 'investment_pack', array('id' => $packageid));
        if ($data->amount > 0) {
            $amount = $data->amount;
        }
        if ($data->matching_income > "0") {

            if ($data->based == "Fixed") {
                $my_business = $data->matching_income;
            } else {
                $my_business = $amount * $data->matching_income / 100;
            }
            $arr = array('my_business' => $my_business);
            $this->db->where('id', $userid);
            $this->db->update('member', $arr);
        }

        if ($data->direct_income > "0" && trim($sponsor) !== '') {
            if ($data->based == "Fixed") {
                $direct_income = $data->direct_income;
            } else {
                $direct_income = ($amount * $data->direct_income / 100);
            }
            $this->pay_earning($sponsor, $userid, 'Referral Income', $direct_income);
        }

        ## NOW Level Income
        if (trim($data->level_income) !== "") {
            $ex = explode(',', $data->level_income);
            $i  = 0;
            foreach ($ex as $e) {
                $e = trim($e);
                if ($i == 0) {
                    $pay_sponsor = $sponsor;
                } else {
                    $pay_sponsor = $this->find_level_sponsor($sponsor, $i);
                }
                if ($pay_sponsor > 0 && $e > 0) {
                    if ($data->based == "Fixed") {
                        $level_income = $e;
                    } else {
                        $level_income = ($amount * $e / 100);
                    }
                    $this->pay_earning($pay_sponsor, $userid, 'Level Income', $level_income);
                }
                $i++;
            }
        }


        return true;

    }

    private function find_level_sponsor($sponsor, $i)
    {
        if ($i > 0) {
            $this->db->select('sponsor')->from('member')->where(array('id' => $sponsor));
            $result = $this->db->get()->row();
            if (!$result) {
                return false;
            } else {
                $i = ($i - 1);

                return $this->find_level_sponsor($result->sponsor, $i);
            }
        } else {
            return $sponsor;
        }
    }
}