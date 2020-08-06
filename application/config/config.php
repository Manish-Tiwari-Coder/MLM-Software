<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['base_url'] = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}" . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

###############################################
#                                             #
# Income Types. here we'll set income types   #
#                                             #
###############################################

$config['is_upgrade'] = "No";
$config['first_upgrade'] = "700";
$config['binary_frst_ratio'] = "2";
$config['binary_2nd_ratio']  = "1";
$config['income_name']       = array("Matching Income" => "Matching Income", "Referral Income" => "Referral Income", "Level Income" => "Level Income");
#  	Level Income, Referral Income, Matching Income, ROI, Advt Income, Survey Income

$config['is_demo']                 = FALSE;
$config['install_date']            = FALSE;
$config['dev_pass']                = "adminadmin";
$config['index_page']              = '';
$config['uri_protocol']            = 'REQUEST_URI';
$config['url_suffix']              = '';
$config['language']                = 'english';
$config['charset']                 = 'UTF-8';
$config['enable_hooks']            = FALSE;
$config['subclass_prefix']         = 'MY_';
$config['composer_autoload']       = TRUE;
$config['permitted_uri_chars']     = 'a-z 0-9~%.:_\-%()@';
$config['enable_query_strings']    = FALSE;
$config['controller_trigger']      = 'c';
$config['function_trigger']        = 'm';
$config['directory_trigger']       = 'd';
$config['allow_get_array']         = TRUE;
$config['log_threshold']           = 0;
$config['log_path']                = '';
$config['log_file_extension']      = 'txt';
$config['log_file_permissions']    = 0644;
$config['log_date_format']         = 'Y-m-d H:i:s';
$config['error_views_path']        = '';
$config['cache_path']              = '';
$config['cache_query_string']      = FALSE;
$config['encryption_key']          = '';
$config['sess_driver']             = 'files';
$config['sess_cookie_name']        = 'ci_session';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = NULL;
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 300;
$config['sess_regenerate_destroy'] = TRUE;
$config['cookie_prefix']           = '';
$config['cookie_domain']           = '';
$config['cookie_path']             = '/';
$config['cookie_secure']           = FALSE;
$config['cookie_httponly']         = FALSE;
$config['standardize_newlines']    = FALSE;
$config['global_xss_filtering']    = TRUE;

// CSRF

$config['csrf_protection']    = FALSE;
$config['csrf_token_name']    = 'branch_is_id';
$config['csrf_cookie_name']   = 'branch_is_id';
$config['csrf_expire']        = 7200;
$config['csrf_regenerate']    = TRUE;
$config['csrf_exclude_uris']  = array();
$config['compress_output']    = FALSE;
$config['time_reference']     = 'Asia/Kolkata';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips']          = '';
