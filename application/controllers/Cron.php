<?php


defined("BASEPATH") or exit("No direct script access allowed");
class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->update_legs();
        $this->custom_income();
        $this->flexi_income();
        $this->level_wise_income();
        $this->binary_payout();
        $this->roi();
        $this->reward();
        $this->rank_update();
        $this->investment();
        $this->payout();
        echo "<div align=\"center\">Nothing is here so pack your bag and go home little baby..</div>";
    }
    private function update_legs()
    {
        $this->db->select("id,A,B,C,D,E")->from("member")->where("topup >", "0");
        $data = $this->db->get()->result();
        foreach ($data as $result) {
            if ($result->A !== "0") {
                $count_a = $this->count_node($result->A);
                $total_a_pv = $this->count_pv($result->A) + $this->db_model->select("mypv", "member", array("id" => $result->A));
                $total_a_matching = $this->count_matching($result->A) + $this->db_model->select("my_business", "member", array("id" => $result->A));
                $total_a_investment = $this->count_investment($result->A) + $this->db_model->select("topup", "member", array("id" => $result->A));
            } else {
                $count_a = 0;
                $total_a_pv = 0;
                $total_a_matching = 0;
                $total_a_investment = 0;
            }
            if ($result->B !== "0") {
                $count_b = $this->count_node($result->B);
                $total_b_pv = $this->count_pv($result->B) + $this->db_model->select("mypv", "member", array("id" => $result->B));
                $total_b_matching = $this->count_matching($result->B) + $this->db_model->select("my_business", "member", array("id" => $result->B));
                $total_b_investment = $this->count_investment($result->B) + $this->db_model->select("topup", "member", array("id" => $result->B));
            } else {
                $count_b = 0;
                $total_b_pv = 0;
                $total_b_matching = 0;
                $total_b_investment = 0;
            }
            if ($result->C !== "0") {
                $count_c = $this->count_node($result->C);
                $total_c_pv = $this->count_pv($result->C) + $this->db_model->select("mypv", "member", array("id" => $result->C));
                $total_c_matching = $this->count_matching($result->C) + $this->db_model->select("my_business", "member", array("id" => $result->C));
            } else {
                $count_c = 0;
            }
            if ($result->D !== "0") {
                $count_d = $this->count_node($result->D);
                $total_d_pv = $this->count_pv($result->D) + $this->db_model->select("mypv", "member", array("id" => $result->D));
                $total_d_matching = $this->count_matching($result->D) + $this->db_model->select("my_business", "member", array("id" => $result->D));
            } else {
                $count_d = 0;
            }
            if ($result->E !== "0") {
                $count_e = $this->count_node($result->E);
                $total_e_pv = $this->count_pv($result->E) + $this->db_model->select("mypv", "member", array("id" => $result->E));
                $total_e_matching = $this->count_matching($result->E) + $this->db_model->select("my_business", "member", array("id" => $result->E));
            } else {
                $count_e = 0;
            }
            $data = array("total_a" => $count_a, "total_b" => $count_b, "total_c" => $count_c, "total_d" => $count_d, "total_e" => $count_e, "total_a_pv" => $total_a_pv, "total_b_pv" => $total_b_pv, "total_c_pv" => $total_c_pv, "total_d_pv" => $total_d_pv, "total_e_pv" => $total_e_pv, "total_a_matching_incm" => $total_a_matching, "total_b_matching_incm" => $total_b_matching, "total_c_matching_incm" => $total_c_matching, "total_d_matching_incm" => $total_d_matching, "total_e_matching_incm" => $total_e_matching, "total_a_investment" => $total_a_investment, "total_b_investment" => $total_b_investment);
            $this->db->where("id", $result->id);
            $this->db->update("member", $data);
        }
    }
    private function count_node($id, $i = 0)
    {
        if ($i == 0) {
            $top_up = $this->db_model->select("topup", "member", array("id" => $id));
            if (0 < $top_up) {
                $i = $i + 1;
            }
        }
        $this->db->select("id,topup")->where("position", $id);
        $data = $this->db->get("member")->result();
        $countdata = $this->db_model->count_all("member", array("position" => $id, "topup >" => "0"));
        $i = $i + $countdata;
        foreach ($data as $result) {
            if ($result->id) {
                $i = $this->count_node($result->id, $i);
            }
        }
        return $i;
    }
    private function count_pv($id, $i = 0)
    {
        $this->db->select("id,mypv")->where("position", $id);
        $data = $this->db->get("member")->result();
        $countdata = $this->db_model->sum("mypv", "member", array("position" => $id, "mypv !=" => "0"));
        $i = $i + $countdata;
        foreach ($data as $result) {
            if ($result->id) {
                $i = $this->count_pv($result->id, $i);
            }
        }
        return $i;
    }
    private function count_investment($id, $i = 0)
    {
        $this->db->select("id,topup")->where("position", $id);
        $data = $this->db->get("member")->result();
        $countdata = $this->db_model->sum("topup", "member", array("position" => $id, "topup >" => "0"));
        $i = $i + $countdata;
        foreach ($data as $result) {
            if ($result->id) {
                $i = $this->count_investment($result->id, $i);
            }
        }
        return $i;
    }
    private function count_matching($id, $i = 0)
    {
        $this->db->select("id,my_business")->where("position", $id);
        $data = $this->db->get("member")->result();
        $countdata = $this->db_model->sum("my_business", "member", array("position" => $id, "my_business !=" => "0"));
        $i = $i + $countdata;
        foreach ($data as $result) {
            if ($result->id) {
                $i = $this->count_matching($result->id, $i);
            }
        }
        return $i;
    }
    public function custom_income()
    {
        $this->load->model("custom_income");
        $this->custom_income->index();
    }
    public function flexi_income()
    {
        $this->load->model("earning");
        $this->earning->flexi_income();
    }
    public function level_wise_income()
    {
        $this->load->model("earning");
        $this->earning->level_wise_income();
    }
    private function binary_payout()
    {
        $count_product_binary = $this->db_model->count_all("product", array("matching_income >" => 0));
        $count_fix_binary = $this->db_model->select("binary_income", "fix_income", array("1 >" => 0));
        $count_invst_binary = $this->db_model->select("matching_income", "investment_pack", array(0));
        if (0 < $count_product_binary || 0 < $count_fix_binary || 0 < $count_invst_binary) {
            $this->db->select("id,total_a,total_b,paid_a,paid_b,signup_package,mypv,total_a_matching_incm,total_b_matching_incm, total_c_matching_incm, paid_a_matching_incm, paid_b_matching_incm")->from("member")->where("topup >", "0")->where("total_a >", 0)->where("total_b >", 0)->where("paid_a <", "total_a", false)->where("paid_b <", "total_b", false);
            $data = $this->db->get()->result();
            foreach ($data as $result) {
                $this->load->model("earning");
                $data2 = array("total_a" => $result->total_a, "total_b" => $result->total_b, "paid_a" => $result->paid_a, "paid_b" => $result->paid_b, "signup_package" => $result->signup_package, "mypv" => $result->mypv, "total_a_matching_incm" => $result->total_a_matching_incm, "total_b_matching_incm" => $result->total_b_matching_incm, "total_c_matching_incm" => $result->total_c_matching_incm, "paid_a_matching_incm" => $result->paid_a_matching_incm, "paid_b_matching_incm" => $result->paid_b_matching_incm);
                $this->earning->process_binary($result->id, $data2);
            }
        }
    }
    public function roi()
    {
        $count_product_roi = $this->db_model->count_all("product", array("roi >" => 0));
        if (0 < $count_product_roi) {
            $this->load->model("earning");
            $this->earning->roi_earning();
        }
    }
    public function reward()
    {
        $this->load->model("earning");
        $this->earning->reward_process();
    }
    public function rank_update()
    {
        $this->load->model("earning");
        $this->earning->rank_process();
    }
    public function investment()
    {
        $this->load->model("investment");
        $this->investment->generate();
    }
    public function payout()
    {
        $this->db->select("id, userid, amount")->where("status", "Pending");
        $data = $this->db->get("earning")->result();
        foreach ($data as $e) {
            $cur_balance = $this->db_model->select("balance", "wallet", array("userid" => $e->userid));
            $data = array("balance" => $e->amount + $cur_balance);
            $this->db->where("userid", $e->userid);
            $this->db->update("wallet", $data);
            $data = array("status" => "Paid");
            $this->db->where("id", $e->id);
            $this->db->update("earning", $data);
        }
    }
    public function admin_topup()
    {
        redirect("users/topup-member");
    }
    public function member()
    {
        redirect("member");
    }
    public function generate_payout()
    {
        redirect("wallet/generate-payout");
    }
    public function complete_registration()
    {
        $this->load->dbutil();
        $this->dbutil->optimize_database();
        redirect("site/complete_registration");
    }
    public function check_user()
    {
        $user = trim($this->input->post("user"));
        if (0 < $this->db_model->count_all("franchisee", array("username" => $user))) {
            echo "<span style=\"color: red; background-color: moccasin\">The Username is Taken !</span>";
        } else {
            echo "<span style=\"color: green; background-color: #d6e9c6\">The Username is Available !</span>";
        }
    }
    public function get_stock_qty()
    {
        $fran_id = $this->input->post("fran_id");
        $prod_name = $this->input->post("prod");
        $prodid = $this->db_model->select("id", "product", array("prod_name" => $prod_name));
        $qty = $this->db_model->select("available_qty", "franchisee_stock", array("franchisee_id" => $fran_id, "product_id" => $prodid));
        if ($qty == "") {
            $qty = 0;
        }
        echo $qty;
    }
    public function get_products()
    {
        $data = trim($this->input->get("term"));
        $this->db->select("prod_name")->from("product")->where("status", "Selling")->where("qty !=", "0")->like("prod_name", $data, "BOTH");
        $data = $this->db->get()->result();
        foreach ($data as $val) {
            $res[] = $val->prod_name;
        }
        echo json_encode($res);
    }
    public function get_own_products()
    {
        $data = trim($this->input->get("term"));
        $this->db->select("id")->from("product")->like("prod_name", $data, "BOTH");
        $data = $this->db->get()->result();
        foreach ($data as $val) {
            $res[] = $val->prod_name;
        }
        echo json_encode($res);
    }
    public function get_wallet_balance($uid)
    {
        $uid = $this->common_model->filter($uid);
        $balance = $this->db_model->select("balance", "wallet", array("userid" => $uid));
        echo $balance;
    }
    public function a_e()
    {
    }
}

?>