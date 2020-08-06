<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.4
 * @ Release: 02/06/2020
 *
 * @ ZendGuard Decoder PHP 5.6
 */

defined("BASEPATH") or exit("No direct script access allowed");
class Plan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->common_model->__session();
    }
    public function create_leg()
    {
        $leg = config_item("leg");
        if ($leg == "1") {
            return array("A" => "Left");
        }
        if ($leg == "2") {
            return array("A" => "Left", "B" => "Right");
        }
        if ($leg == "3") {
            return array("A" => "A", "B" => "B", "C" => "C");
        }
        if ($leg == "4") {
            return array("A" => "A", "B" => "B", "C" => "C", "D" => "D");
        }
        if ($leg == "5") {
            return array("A" => "A", "B" => "B", "C" => "C", "D" => "D", "E" => "E");
        }
        if ($leg == "6") {
            return array("A" => "A", "B" => "B", "C" => "C", "D" => "D", "E" => "E", "F" => "F");
        }
    }
    public function find_extreme_position($id, $leg)
    {
        $this->db->select($leg)->from("member")->where(array("id" => $id));
        $result = $this->db->get()->row();
        if ($result->{$leg} == 0) {
            return $id;
        }
        return $this->find_extreme_position($result->{$leg}, $leg);
    }
    public function check_position($position, $leg)
    {
        $this->db->select($leg)->from("member")->where("id", $position);
        $result = $this->db->get()->row();
        if ($result->{$leg} == 0) {
            return $position;
        }
        return false;
    }
    public function find_autopool_field($sponsor = "")
    {
        if (config_item("leg") == "1") {
            $this->db->select("id,A")->from("member")->where("A", 0)->order_by("secret", "ASC")->limit(1);
            $result = $this->db->get()->row();
            $id = $result->id;
            if (trim($result->A) == "0") {
                $position = "A";
            }
        }
        if (config_item("leg") == "2") {
            $this->db->select("id,A,B")->from("member")->where("A", 0)->or_where("B", 0)->order_by("secret", "ASC")->limit(1);
            $result = $this->db->get()->row();
            $id = $result->id;
            if (trim($result->A) == "0") {
                $position = "A";
            } else {
                $position = "B";
            }
        }
        if (config_item("leg") == "3") {
            $this->db->select("id,A,B,C")->from("member")->where("A", 0)->or_where("B", 0)->or_where("C", 0)->order_by("secret", "ASC")->limit(1);
            $result = $this->db->get()->row();
            $id = $result->id;
            if (trim($result->A) == "0") {
                $position = "A";
            } else {
                if (trim($result->B) == "0") {
                    $position = "B";
                } else {
                    $position = "C";
                }
            }
        }
        if (config_item("leg") == "4") {
            $this->db->select("id,A,B,C,D")->from("member")->where("A", 0)->or_where("B", 0)->or_where("C", 0)->or_where("D", 0)->order_by("secret", "ASC")->limit(1);
            $result = $this->db->get()->row();
            $id = $result->id;
            if (trim($result->A) == "0") {
                $position = "A";
            } else {
                if (trim($result->B) == "0") {
                    $position = "B";
                } else {
                    if (trim($result->C) == "0") {
                        $position = "C";
                    } else {
                        $position = "D";
                    }
                }
            }
        }
        if (config_item("leg") == "5") {
            $this->db->select("id,A,B,C,D,E")->from("member")->where("A", 0)->or_where("B", 0)->or_where("C", 0)->or_where("D", 0)->or_where("E", 0)->order_by("secret", "ASC")->limit(1);
            $result = $this->db->get()->row();
            $id = $result->id;
            if (trim($result->A) == "0") {
                $position = "A";
            } else {
                if (trim($result->B) == "0") {
                    $position = "B";
                } else {
                    if (trim($result->C) == "0") {
                        $position = "C";
                    } else {
                        if (trim($result->D) == "0") {
                            $position = "D";
                        } else {
                            $position = "E";
                        }
                    }
                }
            }
        }
        return array("id" => $id, "position" => $position);
    }
    public function create_tree($id, $above_id = "", $position = "A")
    {
        $my_tree = "my_tree";
        if ($this->session->admin_id) {
            $my_tree = "user_tree";
        }
        $data = $this->db_model->select_multi("id,name,A,B,C,D,E,total_a,total_b,topup,total_c,total_d,total_e,mypv,total_a_pv,total_b_pv,my_img,total_a_investment,total_b_investment", "member", array("id" => $id));
        if ($data->topup == "0.00") {
            $color = "red";
        } else {
            $color = "green";
        }
        $myimg = $data->my_img ? base_url("uploads/" . $data->my_img) : base_url("uploads/site_img/" . $color . ".png");
        $tota_node = "";
        if (config_item("leg") == "1") {
            $tota_node = "Total Downline: " . ($data->total_a + $data->total_b + $data->total_c + $data->total_d + $data->total_e) . "";
        }
        if (config_item("leg") == "2") {
            $total_a_pv = "My Business Left: " . $data->total_a_pv;
            $total_b_pv = "My Business Right: " . $data->total_b_pv;
            if (config_item("enable_investment") == "Yes") {
                $total_a_pv = "My Investment Left: " . $data->total_a_investment;
                $total_b_pv = "My Investment Right: " . $data->total_b_investment;
            }
            $tota_node = "Total Left: " . $data->total_a . "<br/>" . "Total Right: " . $data->total_b . "<br/> " . $total_a_pv . "<br/>" . $total_b_pv . "";
        } else {
            if (config_item("leg") == "3") {
                $tota_node = "Total A: " . $data->total_a . "<br/>" . "Total B: " . $data->total_b . "<br/>Total C: " . $data->total_c . "<br/>";
            } else {
                if (config_item("leg") == "4") {
                    $tota_node = "Total A: " . $data->total_a . "<br/>" . "Total B: " . $data->total_b . "<br/>Total C: " . $data->total_c . "<br/>Total D: " . $data->total_d . "<br/>";
                } else {
                    if (config_item("leg") == "5") {
                        $tota_node = "Total A: " . $data->total_a . "<br/>" . "Total B: " . $data->total_b . "<br/>Total C: " . $data->total_c . "<br/>Total D: " . $data->total_d . "<br/>Total E: " . $data->total_e . "<br/>";
                    }
                }
            }
        }
        if ($data->id) {
            $echo = "<a href=\"" . site_url("tree/" . $my_tree . "/" . $id) . "\" title=\"" . config_item("ID_EXT") . $data->id . "\" style=\"text-decoration: none; color: " . $color . "; margin: 5px\" data-toggle=\"popover\" data-trigger=\"hover\" data-html=\"true\" data-placement=\"top\" data-content=\"\n" . $tota_node . "<br/>\nMy Business: " . $data->mypv . "\n\n\"><img class=\"img-circle\" style=\"height: 40px\" src=\"" . $myimg . "\"><br/>" . $data->name . "<br/></a>";
            return array("A" => $data->A, "B" => $data->B, "C" => $data->C, "D" => $data->D, "E" => $data->E, "data" => $echo, "id" => $data->id);
        }
        return array("data" => "<a target=\"blank\" title=\"Register New Member.\" href=\"" . site_url("tree/new_user/" . $position . "/" . $above_id) . "\"><img style=\"height: 50px\" src=\"" . base_url("uploads/site_img/new.png") . "\"></a>");
    }
    public function ref_list($id, $sn = 1)
    {
        $this->db->select("id, name, phone, join_time, total_a, sponsor, total_b, total_c, total_d, total_e")->from("member")->where(array("position" => htmlentities($id)));
        $data = $this->db->get()->result();
        foreach ($data as $e) {
            echo "<tr>\n        <td>" . $sn++ . "</td>\n        <td>" . $e->name . "</td>\n        <td>" . $e->join_time . "</td>\n        <td>" . ($e->total_a + $e->total_b + $e->total_c + $e->total_d + $e->total_e) . "</td>\n        <td>" . config_item("ID_EXT") . $e->sponsor . "</td>\n    </tr>";
            $last_id = $e->id;
        }
        if (trim($last_id) !== "") {
            $this->ref_list($last_id, $sn);
        }
    }
}

?>