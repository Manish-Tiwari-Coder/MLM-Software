<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class Earning extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->common_model->__session();
    }

    public function roi_earning()
    {
        $this->db->select('id,signup_package')->from('member')->where(array('topup >' => "0"));
        $users = $this->db->get()->result();
        foreach ($users as $users):
            $userid        = $users->id;
            $roi           = $this->db_model->select_multi('roi,roi_limit,roi_frequency', 'product', array('id' => $users->signup_package));
            $roi_frequency = $roi->roi_frequency;
            $roi_limit     = $roi->roi_limit;
            $roi           = $roi->roi;
            if ($roi > 0) {
                $get_last_roi = $this->db_model->select('date', 'earning', array(
                    'userid' => $userid,
                    'type'   => 'ROI',
                    'secret' => $users->signup_package,
                ));
                $date         = date('Y-m-d', strtotime($get_last_roi) + (86400 * $roi_frequency));
                if (date('Y-m-d') >= $date) {
                    if ($this->db_model->count_all('earning', array(
                            'userid' => $userid,
                            'type'   => 'ROI',
                            'secret' => $users->signup_package,
                        )) < $roi_limit) {
                        $this->pay_earning($userid, '', 'ROI', $roi, '', $users->signup_package);
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

    public function process_binary($id, $data)
    {
        $min              = min(($data['total_a_matching_incm'] - $data['paid_a_matching_incm']), ($data['total_b_matching_incm'] - $data['paid_b_matching_incm']));
        $pair_match       = min(($data['total_a'] - $data['paid_a']), ($data['total_b'] - $data['paid_b']));
        $pair_max         = max(($data['total_a'] - $data['paid_a']), ($data['total_b'] - $data['paid_b']));
        $paid_pair        = min($data['paid_a'], $data['paid_b']);
        $per_user_earning = $min / $pair_match;

        $sponsor = $this->db_model->select('sponsor', 'member', array('id'=>$id));
        if ($paid_pair <= 0 && $pair_max >= config_item('binary_frst_ratio') && $pair_match >= config_item('binary_2nd_ratio')) {
            # First Binary.
           $this->pay_earning($sponsor, '', 'Referral Income', ($min*50/100), $pair_match);
            $this->pay_earning($id, '', 'Matching Income', $min, $pair_match);
            if ($data['total_a'] > 0) {
                $paid_a       = config_item('binary_frst_ratio');
                $paid_b       = 1;
                $paid_a_match = ($per_user_earning * config_item('binary_frst_ratio'));
                $paid_b_match = $per_user_earning;
            } else {
                $paid_a       = 1;
                $paid_b       = config_item('binary_frst_ratio');
                $paid_a_match = $per_user_earning;
                $paid_b_match = $per_user_earning * config_item('binary_frst_ratio');
            }
            $array = array(
                'paid_a'               => $paid_a,
                'paid_b'               => $paid_b,
                'paid_a_matching_incm' => $paid_a_match,
                'paid_b_matching_incm' => $paid_b_match,
            );
            $this->db->where('id', $id);
            $this->db->update('member', $array);

        } else if ($pair_match >= config_item('binary_2nd_ratio') && $paid_pair > 0) {
            $cappping   = $this->db_model->select('capping', 'product', array('id' => $this->db_model->select('signup_package', 'member', array('id' => $id))));
            $total_paid = $this->db_model->sum('amount', 'earning', array('userid' => $id, 'type' => 'Matching Income', 'date'=>date('Y-m-d')));
            # Second and after ward binary


            

             for ($i = 0; $i < $pair_match; $i++) {
                            $paid_pair = $paid_pair + 1;
                            if ($paid_pair == "2") {
                                $this->pay_earning($id, '', 'Matching Income', '1', '1');
                            } else {
                                $this->pay_earning($id, '', 'Matching Income', $per_user_earning, '1');
                            }
                        }



            if ($cappping <= 0 || $total_paid < $cappping) {
                $avl_cap = $cappping - $total_paid;
                if ($min > $avl_cap && $cappping > 0) {
                    $min = $min = $avl_cap;
                }
                 $this->pay_earning($sponsor, '', 'Matching Income', ($min*50/100), $pair_match);
                $this->pay_earning($id, '', 'Matching Income', $min, $pair_match);
            }
            $array = array(
                'paid_a'               => $data['paid_a'] + $pair_match,
                'paid_b'               => $data['paid_b'] + $pair_match,
                'paid_a_matching_incm' => $data['paid_a_matching_incm'] + $min,
                'paid_b_matching_incm' => $data['paid_b_matching_incm'] + $min,
            );
            $this->db->where('id', $id);
            $this->db->update('member', $array);
        } else {

        }

    }

    public function repurchase($order_id)
    {
        $this->db->select('product_id, userid, cost, qty')->from('product_sale')->where(array('id' => $order_id));
        $order_detail = $this->db->get()->row();
        $userid       = $order_detail->userid;
        $product_id   = $order_detail->product_id;
        $qty          = $order_detail->qty;

        $sponsor = $this->db_model->select('sponsor', 'member', array('id' => $userid));
        $this->repurchase_earning($userid, $sponsor, $product_id, $qty);

    }

    public function repurchase_earning($userid, $sponsor, $packageid, $qty)
    {
        if (config_item('enable_gap_commission') !== "Yes") {
            $this->reg_earning($userid, $sponsor, $packageid, false, $qty);
        } else {
            $data     = $this->db_model->select_multi('mypv, total_a_pv, total_b_pv, total_c_pv, total_d_pv, total_e_pv', 'member', array('id' => $userid));
            $total_pv = $data->total_a_pv + $data->total_b_pv + $data->total_c_pv + $data->total_d_pv + $data->total_e_pv + $data->mypv;

            $this->db->where(array(
                                 'total_pv <=' =>
                                     $total_pv,
                             ));
            $this->db->order_by('id', 'DESC');
            $result        = $this->db->get('gap_commission_setting')->row();
            $dataxs        = $this->db_model->select_multi('prod_price,pv,direct_income, level_income', 'product', array('id' => $packageid));
            $pv            = $dataxs->pv;
            $product_price = $dataxs->prod_price;
            if ($pv > "0") {
                $mypv = $data->mypv + ($pv * $qty);
                $arr  = array('mypv' => $mypv);
                $this->db->where('id', $userid);
                $this->db->update('member', $arr);
            }
            if ($dataxs->direct_income > "0" && trim($sponsor) !== '') {
                $this->pay_earning($sponsor, $userid, 'Referral Income', $dataxs->direct_income);
            }

            $earning = ($product_price * $result->amount / 100) * $qty;
            $this->pay_earning($userid, 'Self', $result->income_name, $earning);

            $this->db->select('amount, income_name');
            $this->db->where(array(
                                 'total_pv <=' =>
                                     $total_pv,
                             ));
            $this->db->order_by('id', 'DESC');
            $ex = $this->db->get('gap_commission_setting')->result();

            $i = 0;
            foreach ($ex as $e) {
                $e = trim($e);
                if ($i == 0) {
                    $pay_sponsor = $sponsor;
                } else {
                    $pay_sponsor = $this->find_level_sponsor($sponsor, $i);
                }
                if ($pay_sponsor > 0) {
                    $amt = ($product_price * ($result->amount - $e->amount) / 100) * $qty;
                    if ($amt > 0) {
                        $this->pay_earning($pay_sponsor, $userid, $e->income_name, $amt);
                    }
                }
                $i++;
            }

        }
    }

    public function reg_earning($userid, $sponsor, $packageid, $need_topup = true, $qty = 1)
    {
        $get_topup = $this->db_model->select('topup', 'member', array('id' => $userid));
        if ($get_topup > "0" or $need_topup === false):

            ###############################################################
            #
            # Direct or Referal Income First
            #
            ##############################################################
            $data = $this->db_model->select_multi('prod_price, direct_income, level_income, pv', 'product', array('id' => $packageid));
            if ($data->pv > "0") {
                $mypv = $this->db_model->select('mypv', 'member', array('id' => $userid)) + ($data->pv * $qty);
                $arr  = array('mypv' => $mypv);
                $this->db->where('id', $userid);
                $this->db->update('member', $arr);
            }
            if ($data->direct_income > "0.00" && trim($sponsor) !== '') {
                $this->pay_earning($sponsor, $userid, 'Referral Income', $data->direct_income);
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
                        $this->pay_earning($pay_sponsor, $userid, 'Level Income', $e);
                    }
                    $i++;
                }
            }

        endif;

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

    public function fix_income($userid, $sponsor, $amount)
    {
        $get_topup = $this->db_model->select('topup', 'member', array('id' => $userid));
        if ($get_topup > "0"):

            ###############################################################
            #
            # Direct or Referal Income First
            #
            ##############################################################
            $data = $this->db_model->select_multi('direct_income, level_income, binary_income', 'fix_income', array('1' => 1));
            if ($data->binary_income > "0") {
                $my_business = $amount * $data->binary_income / 100;
                $arr         = array('my_business' => $my_business);
                $this->db->where('id', $userid);
                $this->db->update('member', $arr);
            }
            if ($data->direct_income > "0") {
                $this->pay_earning($sponsor, $userid, 'Referral Income', ($amount * $data->direct_income / 100));
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
                        $this->pay_earning($pay_sponsor, $userid, 'Level Income', ($amount * $e / 100));
                    }
                    $i++;
                }
            }

        endif;

        return true;

    }

    public function advt_level($userid, $ad_id, $level_income, $need_topup = true)
    {
        $get_topup = $this->db_model->select_multi('sponsor,topup', 'member', array('id' => $userid));
        $sponsor   = $get_topup->sponsor;
        $get_topup = $get_topup->topup;
        if ($get_topup > "0.00" or $need_topup !== true):

            ###############################################################
            #
            # Direct or Referal Income For Ads. Also check whether
            # he/she has received ad income before for this ad
            #
            ##############################################################
            $data = $this->db_model->count_all('ad_user', array(
                'ad_id'  => $ad_id,
                'userid' => $userid,
            ));
            if ($data <= 0) {
                ## NOW Level Income
                $ex = explode(',', $level_income);
                $i  = 0;
                foreach ($ex as $e) {
                    $e = trim($e);
                    if ($i == 0) {
                        $pay_sponsor = $this->session->user_id;
                    } else {
                        $pay_sponsor = $this->find_level_sponsor($sponsor, $i);
                    }
                    if ($pay_sponsor > 0 && $e > 0) {
                        $this->pay_earning($pay_sponsor, $userid, 'Advt Income', $e);
                    }
                    $i++;
                }

                $array = array(
                    'ad_id'  => $ad_id,
                    'userid' => $userid,
                    'date'   => time(),
                );
                $this->db->insert('ad_user', $array);
            }

        endif;

        return true;

    }

    public function survey_level($userid, $survey_id, $level_income, $data_arr = "", $need_topup = true)
    {
        $get_topup = $this->db_model->select_multi('sponsor,topup', 'member', array('id' => $userid));
        $sponsor   = $get_topup->sponsor;
        $get_topup = $get_topup->topup;
        if ($get_topup > "0.00" or $need_topup !== true):

            ###############################################################
            #
            # Direct or Referal Income For Completed Surveys. Also check whether
            # he/she has received ad income before for this ad
            #
            ##############################################################
            $data = $this->db_model->count_all('survey_user', array(
                'survey_id' => $survey_id,
                'userid'    => $userid,
            ));
            if ($data <= 0) {
                ## NOW Level Income
                $ex = explode(',', $level_income);
                $i  = 0;
                foreach ($ex as $e) {
                    $e = trim($e);
                    if ($i == 0) {
                        $pay_sponsor = $this->session->user_id;
                    } else {
                        $pay_sponsor = $this->find_level_sponsor($sponsor, $i);
                    }
                    if ($pay_sponsor > 0 && $e > 0) {
                        $this->pay_earning($pay_sponsor, $userid, 'Survey Income', $e);
                    }
                    $i++;
                }

                $array = array(
                    'survey_id' => $survey_id,
                    'userid'    => $userid,
                    'date'      => time(),
                    'data'      => $data_arr,
                );
                $this->db->insert('survey_user', $array);
            }

        endif;

        return true;

    }

    public function reward_process()
    {
        $reward = $this->db->get('reward_setting')->result();
        foreach ($reward as $res) {
            $duration = date('Y-m-d', '-' . $res->reward_duration);
            if ($duration == date('Y-m-d')) {
                $duration = date('Y-m-d', '-10 Years');
            }
            $this->db->select('id')->from('member')->where(array(
                                                               'total_a >=' => $res->A,
                                                               'total_b >=' => $res->B,
                                                               'total_c >=' => $res->C,
                                                               'total_d >=' => $res->D,
                                                               'total_e >=' => $res->E,
                                                               'join_time >= ' . $duration,
                                                           ));
            $data = $this->db->get()->result();
            foreach ($data as $result) {
                $count = $this->db_model->count_all('rewards', array(
                    'userid'    => $result->id,
                    'reward_id' => $res->id,
                ));
                if ($count <= 0) {
                    $array = array(
                        'reward_id' => $res->id,
                        'userid'    => $result->id,
                        'date'      => date('Y-m-d'),
                    );
                    $this->db->insert('rewards', $array);
                }
            }
        }
    }

    public function rank_process()
    {
        $this->db->order_by('id', 'ASC');
        $rank = $this->db->get('rank_system')->result();
        foreach ($rank as $res) {
            $duration = date('Y-m-d', '-' . $res->rank_duration);
            if ($duration == date('Y-m-d')) {
                $duration = date('Y-m-d', '-10 Years');
            }
            if ($res->based_on == "Member"):
                $this->db->select('id')->from('member')->where(array(
                                                                   'total_a >=' => $res->A,
                                                                   'total_b >=' => $res->B,
                                                                   'total_c >=' => $res->C,
                                                                   'total_d >=' => $res->D,
                                                                   'total_e >=' => $res->E,
                                                                   'join_time >= ' . $duration,
                                                                   'topup >'    => '0',
                                                               ));
            else:
                $this->db->select('id')->from('member')->where(array(
                                                                   'total_a_pv >=' => $res->A,
                                                                   'total_b_pv >=' => $res->B,
                                                                   'total_c_pv >=' => $res->C,
                                                                   'total_d_pv >=' => $res->D,
                                                                   'total_e_pv >=' => $res->E,
                                                                   'join_time >= ' . $duration,
                                                                   'topup >'       => '0',
                                                               ));

            endif;
            $data = $this->db->get()->result();
            foreach ($data as $result) {
                $array = array(
                    'rank' => $res->rank_name,
                );
                $this->db->where('id', $result->id);
                $this->db->update('member', $array);
            }
        }
    }

    public function flexi_income()
    {
        $reward = $this->db->get('flexible_income')->result();
        foreach ($reward as $res) {
            $duration = date('Y-m-d', '-' . $res->income_duration);
            if ($duration == date('Y-m-d')) {
                $duration = date('Y-m-d', '-20 Years');
            }
            if ($res->based_on == "Member"):
                $this->db->select('id')->from('member')->where(array(
                                                                   'total_a >=' => $res->A,
                                                                   'total_b >=' => $res->B,
                                                                   'total_c >=' => $res->C,
                                                                   'total_d >=' => $res->D,
                                                                   'total_e >=' => $res->E,
                                                                   'join_time >= ' . $duration,
                                                                   'topup >'    => '0',
                                                               ));
            else:
                $this->db->select('id')->from('member')->where(array(
                                                                   'total_a_pv >=' => $res->A,
                                                                   'total_b_pv >=' => $res->B,
                                                                   'total_c_pv >=' => $res->C,
                                                                   'total_d_pv >=' => $res->D,
                                                                   'total_e_pv >=' => $res->E,
                                                                   'join_time >= ' . $duration,
                                                                   'topup >'       => '0',
                                                               ));

            endif;
            $data = $this->db->get()->result();
            foreach ($data as $result) {
                $count = $this->db_model->count_all('earning', array(
                    'userid' => $result->id,
                    'secret' => $res->id,
                    'type'   => $res->income_name,
                ));
                if ($count <= 0) {
                    $upgrade = $res->A;
                    $array   = array(
                        'userid' => $result->id,
                        'amount' => $res->amount,
                        'type'   => $res->income_name,
                        'secret' => $res->id,
                        'date'   => date('Y-m-d'),
                    );
                    $this->db->insert('earning', $array);
                }

                ########## UPGRADE IF NEEDED ###
                if (config_item('is_upgrade') === 'Yes') {
                    if ($upgrade == config_item('first_upgrade')) {
//$this->reentry($result->id);
                    }
                }
                ################################
            }
        }
    }

    public function level_wise_income()
    {
        $reward = $this->db->get('level_wise_income')->result();
        foreach ($reward as $res) {
            $duration = date('Y-m-d', '-' . $res->income_duration);
            if ($duration == date('Y-m-d')) {
                $duration = date('Y-m-d', '-20 Years');
            }
            $this->db->select('userid')->from('level')->where(array(
                                                                  'level' . $res->level_no . ' >=' => $res->total_member,
                                                                  'join_time >= ' . $duration,
                                                              ));

            $data = $this->db->get()->result();
            foreach ($data as $result) {
                $count = $this->db_model->count_all('earning', array(
                    'userid' => $result->userid,
                    'secret' => $res->id,
                    'type'   => $res->income_name,
                ));
                if ($count <= 0) {
                    $array = array(
                        'userid' => $result->userid,
                        'amount' => $res->amount,
                        'type'   => $res->income_name,
                        'secret' => $res->id,
                        'date'   => date('Y-m-d'),
                    );
                    $this->db->insert('earning', $array);
                }
            }
        }
    }
}
