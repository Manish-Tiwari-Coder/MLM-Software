<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $this->session->name ?> | <?php echo config_item('company_name') ?></title>
    <!-- BOOTSTRAP STYLES-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo base_url('axxets/franchisee/theme.css') ?>" rel="stylesheet" id="rt_style_components"
          type="text/css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/eggplant/jquery-ui.css">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('uploads/favicon.ico') ?>"/>
    <!-- GOOGLE FONTS-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?php echo site_url('member') ?>" class="navbar-brand" style="background-color: #4D4D4D">
                <span class="logo"><img style="max-width: 100px; max-height: 36px"
                                        src="<?php echo base_url('uploads/logo.png') ?>" alt="Logo"/></span>
            </a>
        </div>
        <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Last access : <?php echo $this->session->last_login ?> &nbsp; <a
                    href="<?php echo site_url('franchisee/logout') ?>"
                    class="btn btn-danger square-btn-adjust">Logout</a>
        </div>
    </nav>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    <a class="active-menu" href="<?php echo site_url('franchisee') ?>"><i
                                class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                </li>
                <li>
                    <a class="active-menu" href="<?php echo site_url('franchisee/profile') ?>"><i
                                class="fa fa-user fa-3x"></i> My Profile</a>
                </li>
                <li>
                    <a class="active-menu" href="<?php echo site_url('franchisee/my_invoices') ?>"><i
                                class="fa fa-print fa-3x"></i> My Own Invoices</a>
                </li>
                <li class="active">
                    <a href="#"><i class="fa fa-shopping-cart fa-3x"></i> Products</a>
                    <ul class="nav nav-second-level open">
                        <li>
                            <a href="<?php echo site_url('franchisee/sale-product') ?>">Sale New Product</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('franchisee/sale-history') ?>">Sale History</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-codepen" fa-3x"></i> My e-PINs</a>
                    <ul class="nav nav-second-level open">
                        <li>
                            <a href="<?php echo site_url('franchisee/used-epin') ?>">Used e-PINs</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('franchisee/unused-epin') ?>">Un-Used e-PINs</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <br/>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <?php
            echo validation_errors('<div class="alert alert-danger">', '</div>');
            echo $this->session->flashdata('common_flash');
            if (trim($layout) !== "") {
                require_once($layout);
            }
            else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Franchisee ID: <?php echo $this->session->fran_id; ?></h2>
                        <h5>Welcome <?php echo $this->session->name ?> , Love to see you back. </h5>
                    </div>
                </div><!-- /. ROW  -->
                <hr/>
                <hr/>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Latest Sales
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <td>S.N.</td>
                                        <td>Product Name</td>
                                        <td>Member ID</td>
                                        <td>Qty</td>
                                        <td>Total Cost</td>
                                        <td>Delivery Date</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sn = 1;
                                    $this->db->select('product_id, userid, cost, qty, deliver_date')
                                             ->where('franchisee_id', $this->session->fran_id)->order_by('id', 'DESC')
                                             ->limit(10);
                                    foreach ($this->db->get()->result as $data):
                                        ?>
                                        <tr>
                                            <td><?php echo $sn++ ?></td>
                                            <td><?php echo $this->db_model->select('prod_name', 'product', array('id' => $data->product_id)) ?></td>
                                            <td><?php echo $data->userid ?></td>
                                            <td><?php echo $data->qty ?></td>
                                            <td><?php echo config_item('currency') . $data->cost ?></td>
                                            <td><?php echo $data->deliver_date ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div><!-- /. ROW  -->
            <?php } ?>
        </div>
        Copyright &copy; All right reserved by <?php echo config_item('company_name') ?>
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
<!-- METISMENU SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.0/metisMenu.min.js"></script>
<!-- MORRIS CHART SCRIPTS -->
<script src="<?php echo base_url('axxets/franchisee/theme.js') ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
