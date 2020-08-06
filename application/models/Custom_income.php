<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom_income extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        //$this->custom_binary();
    }


    public function custom_binary()
    {
        $this->db->select('id,total_a,total_b,total_c,total_d,paid_a,paid_b,signup_package,mypv,total_a_matching_incm,total_b_matching_incm,total_c_matching_incm,total_d_matching_incm, total_c_matching_incm, paid_a_matching_incm, paid_b_matching_incm')
                 ->from('member')->where('topup >', '0')->where('total_a >', 0)->where('total_b >', 0)
                 ->where('paid_a <', 'total_a', FALSE)->where('paid_b <', 'total_b', FALSE);
        $result = $this->db->get()->row_array();
        foreach ($result as $data) {
            $min              = min(($data['total_a_matching_incm'] - $data['paid_a_matching_incm']), ($data['total_b_matching_incm'] - $data['paid_b_matching_incm']));
            $pair_match       = min(($data['total_a'] - $data['paid_a']), ($data['total_b'] - $data['paid_b']));
            $pair_max         = max(($data['total_a'] - $data['paid_a']), ($data['total_b'] - $data['paid_b']));
            $paid_pair        = min($data['paid_a'], $data['paid_b']);
            $per_user_earning = $min / $pair_match;

            if ($paid_pair <= 0 && $pair_max >= config_item('binary_frst_ratio') && $pair_match >= config_item('binary_2nd_ratio')) {
                # First Binary.
                $this->pay_earning($data['id'], '', 'Matching Income', $min, $pair_match);
                if ($data['total_a'] > 0) {
                    $paid_a       = config_item('binary_frst_ratio');
                    $paid_b       = 1;
                    $paid_a_match = ($per_user_earning * config_item('binary_frst_ratio'));
                    $paid_b_match = $per_user_earning;
                }
                else {
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
                $this->db->where('id', $data['id']);
                $this->db->update('member', $array);

            }
            else if ($pair_match >= config_item('binary_2nd_ratio') && $paid_pair > 0) {
                # Second and after ward binary


                /* ******************* For Conditional Binary ********************

                 for ($i = 0; $i < $pair_match; $i++) {
                                $paid_pair = $paid_pair + 1;
                                if ($paid_pair == "4") {
                                    $this->pay_earning($id, '', 'Matching Income', '1', '1');
                                } else {
                                    $this->pay_earning($id, '', 'Matching Income', $per_user_earning, '1');
                                }
                            }


                  ****************************************************************/


                $this->pay_earning($data['id'], '', 'Matching Income', $min, $pair_match);
                $array = array(
                    'paid_a'               => $data['paid_a'] + $pair_match,
                    'paid_b'               => $data['paid_b'] + $pair_match,
                    'paid_a_matching_incm' => $data['paid_a_matching_incm'] + $min,
                    'paid_b_matching_incm' => $data['paid_b_matching_incm'] + $min,
                );
                $this->db->where('id', $data['id']);
                $this->db->update('member', $array);
            }
            else {

            }
        }

    }

}
