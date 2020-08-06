<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages']  = array();
$autoload['libraries'] = array('database', 'session', 'form_validation', 'cart');
$autoload['drivers']   = array();
$autoload['helper']    = array('url', 'form');
$autoload['config']    = array('global', 'payout');
$autoload['language']  = array();
$autoload['model']     = array('common_model', 'db_model', 'login');
