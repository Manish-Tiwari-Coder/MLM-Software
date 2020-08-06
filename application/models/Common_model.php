<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.4
 * @ Release: 14/05/2020
 *
 * @ ZendGuard Decoder PHP 5.6
 */

defined("BASEPATH") or exit("No direct script access allowed");
class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->__session();
    }
    public function __session()
    {
        if ($_SESSION["gehfgejh"] !== true) {
            $status = "Ok";
            if (trim($status) == "" && $_SERVER["HTTP_HOST"] !== "localhost") {
                echo "<div align=\"center\" style=\"background-color: #ffb549; color: #fff; padding: 13px; font-size: 12px\">Unable to load remote URL using PHP CURL. See if CURL is disabled or Port is blocked.<br/>" . $status . "</div>";
                exit;
            }
            if (trim($status) !== "Ok" && !isset($_SESSION["gehfgejh"]) && $_SERVER["HTTP_HOST"] !== "localhost") {
                echo $status;
                exit("!");
            }
            $_SESSION["gehfgejh"] = true;
        }
    }
    public function curl($url, $post = "")
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        if (trim($post) !== "") {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($curl);
        curl_close($curl);
        if (trim($result) == "") {
            return file_get_contents($url);
        }
        return $result;
    }
    public function mail($to, $subject, $msg)
    {
        $this->load->library("email");
        $this->email->from(config_item("smtp_user"), config_item("company_name"));
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);
        $this->email->send();
    }
    public function sms($number, $msg, $post = "")
    {
        $number = $this->filter($number, "number");
        $url = str_ireplace(array("{{phone}}", "{{msg}}"), array($number, $msg), config_item("sms_api"));
        $this->curl($url, $post);
    }
    public function filter($data, $type = "userid")
    {
        switch ($type) {
            case $type == "float":
                return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case $type == "userid":
                return htmlentities(strip_tags(str_ireplace(config_item("ID_EXT"), "", $data)));
            case $type == "number":
                return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
            case $type == "decimal":
                return number_format($data, 2, ".", ",");
        }
        return htmlentities($data);
    }
}

?>