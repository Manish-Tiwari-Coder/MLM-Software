<?php
if ($this->login->check_session() == FALSE) {
    header('HTTP/1.0 404 Not Found', TRUE, 404);
    exit('Page Not Found !');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="author" content="Exolim"/>
    <meta name="robots" content="noindex, nofollow">
    <title>Management Dashboard | <?php echo config_item('company_name') ?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"
          rel="stylesheet"
          type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap2/bootstrap-switch.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('axxets/admin/theme.css') ?>"
          rel="stylesheet" id="rt_style_components"
          type="text/css"/>
    <link rel="stylesheet"
          href="//code.jquery.com/ui/1.12.1/themes/eggplant/jquery-ui.css">
    <link rel="shortcut icon"
          href="<?php echo base_url('uploads/favicon.ico') ?>"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
            type="text/javascript"></script>
    <script type="text/javascript"
            src="https://www.gstatic.com/charts/loader.js"></script>
    <?php
    if (!isset($this->session->designation)) {
        $payout      = $this->db_model->sum('amount', 'earning');
        $paid_payout = $this->db_model->sum('amount', 'withdraw_request', array('status' => 'Paid'));
        if ($paid_payout == "") {
            $paid_payout = 0;
        }
        $pending_payout = $this->db_model->sum('amount', 'withdraw_request', array('status' => 'Pending'));
        if ($pending_payout == "") {
            $pending_payout = 0;
        }
        $earnnings = $this->db_model->sum('topup', 'member');
    }
    ?>
    <script type="text/javascript">
        google.charts.load("current", {packages: ["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Income Name', 'Amount'],
                ['Earned', <?php echo $earnnings ?>],
                ['Paid Payout', <?php echo $paid_payout ?>],
                ['Pending Payout', <?php echo $pending_payout ?>],
            ]);

            var options = {
                title: 'Total Business Activity',
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

</head>
<body class="page-header-fixed sidemenu-closed-hidelogo page-container-bg-solid page-content-white page-md">
<div class="page-wrapper">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="<?php echo site_url('admin') ?>">
                    <img src="<?php echo base_url('uploads/logo.png') ?>"
                         alt="logo" class="logo-default"/> </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <?php if (!isset($this->session->designation) || $this->session->designation['user_manage'] == "1") { ?>

                <form class="search-form-opened" action="<?php echo site_url('users/search') ?>" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control"
                               placeholder="Search User" name="userid">
                        <span class="input-group-btn">
                          <a href="javascript:;" class="btn submit">
                             <i class="icon-magnifier"></i>
                           </a>
                        </span>
                    </div>
                </form>
            <?php } ?>
            <a href="javascript:;" class="menu-toggler responsive-toggler"
               data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown language-switch">
                        <div id="google_translate_element"></div>
                        <script type="text/javascript">
                            function googleTranslateElementInit() {
                                new google.translate.TranslateElement({
                                    pageLanguage: 'en',
                                    includedLanguages: 'ar,bn,en,gu,hi,kn,mr,ms,pa,ta,te',
                                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                    autoDisplay: false
                                }, 'google_translate_element');
                            }
                        </script>
                        <script type="text/javascript"
                                src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    </li>
                    <?php if (!isset($this->session->designation) || $this->session->designation['manage_poducts'] == "1") { ?>
                        <li class="dropdown dropdown-extended dropdown-inbox"
                            id="header_inbox_bar">
                            <a href="<?php echo site_url('product/pending-orders') ?>" class="dropdown-toggle">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="badge cyan-bgcolor">
                                <?php echo $this->db_model->count_all('product_sale', array('status' => 'Processing')) ?>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle"
                           data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <span class="username username-hide-on-mobile"> <?php echo $this->session->name ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?php echo site_url('admin/setting') ?>">
                                    <i class="fa fa-gears"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a target="_blank"
                                   href="<?php echo site_url('site/documentation') ?>">
                                    <i class="fa fa-question"></i> Help
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo site_url('admin/logout') ?>">
                                    <i class="fa fa-sign-out"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="page-container">
        <div class="sidebar-container">
            <div class="sidemenu-container navbar-collapse collapse fixed-menu">
                <div id="remove-scroll">
                    <ul class="sidemenu  page-header-fixed"
                        data-keep-expanded="false" data-auto-scroll="true"
                        data-slide-speed="200" style="padding-top: 20px">
                        <li class="sidebar-toggler-wrapper hide">
                            <div class="sidebar-toggler">
                                <span></span>
                            </div>
                        </li>
                        <li class="sidebar-user-panel">
                            <div class="user-panel">
                                <div class="pull-left info">
                                    <p> Hi, <?php echo $this->session->name ?></p>
                                    <i
                                            class="fa fa-circle user-online"></i><span
                                            class="txtOnline"> <strong>Last Login</strong><br/><?php echo date('d/m/y h:i A', $this->session->last_login) ?></span>


                                </div>
                            </div>
                        </li>
                        <li class="nav-item start active open">
                            <a href="<?php echo site_url('admin') ?>"
                               class="nav-link ">
                                <i class="fa fa-tachometer"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <!-- <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-briefcase"></i>
                                    <span class="title">Business Settings</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('setting/common-setting') ?>"
                                           class="nav-link ">
                                            <span class="title">Common Settings</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('setting/advance-setting') ?>"
                                           class="nav-link ">
                                            <span class="title">Advance Settings</span>
                                        </a>
                                    </li>
                                    <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('setting/payout-setting') ?>"
                                               class="nav-link ">
                                                <span class="title">Payout Setting</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/flexible-income') ?>"
                                               class="nav-link ">
                                                <span class="title">Flexible Income Setting</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/set-level-wise') ?>"
                                               class="nav-link ">
                                                <span class="title">Level Wise Income Setting</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('setting/rank-setting') ?>"
                                           class="nav-link ">
                                            <span class="title">Rank Setting</span>
                                        </a>
                                    </li>
                                    <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                                        <?php if (config_item('fix_income') == 'Yes') { ?>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('income/income-setting') ?>"
                                                   class="nav-link ">
                                                    <span class="title">Fix Income Setting</span>
                                                </a>
                                            </li>
                                        <?php }
                                        if (config_item('enable_repurchase') == "Yes") { ?>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('income/gap-commission-setting') ?>"
                                                   class="nav-link ">
                                                    <span class="title">Repurchase Gap Commission Setting</span>
                                                </a>
                                            </li>
                                        <?php }
                                    } ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('setting/payment-gateway') ?>"
                                           class="nav-link ">
                                            <span class="title">Payment Gateways</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('setting/welcome-letter') ?>"
                                           class="nav-link ">
                                            <span class="title">Design Welcome Letter</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="_blank"
                                           onclick="return confirm('Username is : master and Password is: admin@## . Please change it soon. Ignore if changed.')"
                                           href="<?php echo site_url('setting/cms') ?>"
                                           class="nav-link ">
                                            <span class="title">CMS - Design Your Site</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('setting/clear-database') ?>"
                                           class="nav-link ">
                                            <span class="title">Clear/Reset Database</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['user_manage'] == "1") { ?>

                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-users"></i>
                                    <span class="title">Members</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/view-members') ?>"
                                           class="nav-link ">
                                            <span class="title">View/Manage Members</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/search_user') ?>"
                                           class="nav-link ">
                                            <span class="title">Search Members</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/blocked-members') ?>"
                                           class="nav-link ">
                                            <span class="title">Blocked Members</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/latest-members') ?>"
                                           class="nav-link ">
                                            <span class="title">Latest Members</span>
                                        </a>
                                    </li>
                                    <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                                        <?php if (config_item('enable_topup') == "Yes") { ?>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('users/topup-member') ?>"
                                                   class="nav-link ">
                                                    <span class="title">TopUp Member</span>
                                                </a>
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['tree_view'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-sitemap"></i>
                                    <span class="title">User Tree</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a target="_blank" href="<?php echo site_url('tree/add-new') ?>"
                                           class="nav-link ">
                                            <span class="title">Add New Member</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('tree/user-tree') ?>"
                                           class="nav-link ">
                                            <span class="title">User Tree</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('tree/downline-report') ?>"
                                           class="nav-link ">
                                            <span class="title">Downline Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('tree/referred-list') ?>"
                                           class="nav-link ">
                                            <span class="title">Referred Members</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                            <?php if (!isset($this->session->designation) || $this->session->designation['wallet'] == "1") { ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-cc-visa"></i>
                                        <span class="title">E-Wallet</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('wallet/manage-wallet-fund') ?>"
                                               class="nav-link ">
                                                <span class="title">Manage Wallet Fund</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('wallet/transfer-fund') ?>"
                                               class="nav-link ">
                                                <span class="title">Transfer Fund</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('wallet/wallet-transactions') ?>"
                                               class="nav-link ">
                                                <span class="title">Wallet Transactions</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('wallet/withdraw-fund') ?>"
                                               class="nav-link ">
                                                <span class="title">Withdraw Fund</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('wallet/withdrawl-report') ?>"
                                               class="nav-link ">
                                                <span class="title">Withdrawal Report</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        <?php if ((!isset($this->session->designation) || $this->session->designation['epin'] == "1") && config_item('enable_epin') == "Yes") { ?>

                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-xing-square"></i>
                                    <span class="title">e-PIN</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/generate_epin') ?>"
                                           class="nav-link ">
                                            <span class="title">Generate e-PIN</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/unused_epin') ?>"
                                           class="nav-link ">
                                            <span class="title">Un-Used e-PINs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/used_epin') ?>"
                                           class="nav-link ">
                                            <span class="title">Used e-PINs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/search_epin') ?>"
                                           class="nav-link ">
                                            <span class="title">Search e-PIN</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/transfer_epin') ?>"
                                           class="nav-link ">
                                            <span class="title">Transfer e-PINs</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                            <?php if (!isset($this->session->designation) || $this->session->designation['earning_manage'] == "1") { ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Earning & Payout</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/view-earning') ?>"
                                               class="nav-link ">
                                                <span class="title">View Earnings</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/search-earning') ?>"
                                               class="nav-link ">
                                                <span class="title">Search Earnings</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/make-payment') ?>"
                                               class="nav-link ">
                                                <span class="title">Make Payment</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/hold-payments') ?>"
                                               class="nav-link ">
                                                <span class="title">Hold Payments</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/search-payout') ?>"
                                               class="nav-link ">
                                                <span class="title">Search Payout</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('income/tax-report') ?>"
                                               class="nav-link ">
                                                <span class="title">Tax Report</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('cron/generate_payout') ?>"
                                               class="nav-link ">
                                                <span class="title">Generate Payout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <?php if (config_item('enable_reward') == "Yes") { ?>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-gift"></i>
                                            <span class="title">Rewards</span>
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('income/pay-rewards') ?>"
                                                   class="nav-link ">
                                                    <span class="title">Pay Rewards</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('income/reward-search-form') ?>"
                                                   class="nav-link ">
                                                    <span class="title">Search Rewards</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo site_url('setting/reward-setting') ?>"
                                                   class="nav-link ">
                                                    <span class="title">Reward Setting</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php }
                            }
                        } ?>

                        <?php if (config_item('enable_investment') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-bitcoin"></i>
                                    <span class="title">Investments</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('investments/create_pack') ?>"
                                           class="nav-link ">
                                            <span class="title">Create a New Pack</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('investments/manage_packs') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Packages</span>
                                        </a>
                                    </li>
                                    <?php if (config_item('investment_mode') == "MANUAL") { ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('investments/approve_investments') ?>"
                                               class="nav-link ">
                                                <span class="title">Approve Investments</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('investments/manage_investments') ?>"
                                           class="nav-link ">
                                            <span class="title">Recent Investments</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('investments/search_investments') ?>"
                                           class="nav-link ">
                                            <span class="title">Search Investments</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (config_item('enable_help_plan') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-gift"></i>
                                    <span class="title">Manage Donations</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('donation/create_pack') ?>"
                                           class="nav-link ">
                                            <span class="title">Create a New Pack</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('donation/manage_packs') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Packages</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('donation/manage_donations') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Donations</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('donation/upgrade_level') ?>"
                                           class="nav-link ">
                                            <span class="title">Upgrade Levels</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('donation/search_donations') ?>"
                                           class="nav-link ">
                                            <span class="title">Search Donations</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ((!isset($this->session->designation) || $this->session->designation['manage_poducts'] == "1") && config_item('enable_product') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="title">Products & Services</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <?php if (!isset($this->session->designation) || $this->session->designation['manage_poducts'] == "1" || $this->session->designation['view_orders'] == "1") { ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('admin/manage_cat') ?>"
                                               class="nav-link ">
                                                <span class="title">Manage Categories</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('product/add_product') ?>"
                                               class="nav-link ">
                                                <span class="title">Add Product/Service</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('product/manage_products') ?>"
                                               class="nav-link ">
                                                <span class="title">Manage Products/Services</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('product/search-product') ?>"
                                               class="nav-link ">
                                                <span class="title">Search Product/Services</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (!isset($this->session->designation) || $this->session->designation['view_orders'] == "1") { ?>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('product/pending-orders') ?>"
                                               class="nav-link ">
                                                <span class="title">Pending Orders</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('product/completed-orders') ?>"
                                               class="nav-link ">
                                                <span class="title">Completed Orders</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('product/all-orders') ?>"
                                               class="nav-link ">
                                                <span class="title">All Orders</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ((!isset($this->session->designation) || $this->session->designation['coupon'] == "1") && config_item('enable_coupon') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-tag"></i>
                                    <span class="title">Coupon Management</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('coupon/manage-cat') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Categories</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('coupon/create-coupon') ?>"
                                           class="nav-link ">
                                            <span class="title">Generate Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('coupon/manage-coupons') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Coupons</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('coupon/use-requests') ?>"
                                           class="nav-link ">
                                            <span class="title">Coupon Use Requests</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['staff'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-user-secret"></i>
                                    <span class="title">Manage Staff</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('staff/designations') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Designations</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('staff/new-staff') ?>"
                                           class="nav-link ">
                                            <span class="title">Add New Staff</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('staff/list-staffs') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Staffs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('staff/pay-salary') ?>"
                                           class="nav-link ">
                                            <span class="title">Pay Salary</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('staff/salary-report') ?>"
                                           class="nav-link ">
                                            <span class="title">Salary Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                            <?php if (!isset($this->session->designation) || $this->session->designation['franchisee'] == "1") { ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-wpbeginner"></i>
                                        <span class="title">Manage Franchisee</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('adm-franchisee/add-fran') ?>"
                                               class="nav-link ">
                                                <span class="title">New Franchisee</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('adm-franchisee/stock-management') ?>"
                                               class="nav-link ">
                                                <span class="title">Franchisee Stock Management</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('adm-franchisee/manage-fran') ?>"
                                               class="nav-link ">
                                                <span class="title">Manage Franchisee</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php }
                        } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['support'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-envelope"></i>
                                    <span class="title">Support Tickets</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('ticket/unsolved') ?>"
                                           class="nav-link ">
                                            <span class="title">Unsolved Tickets</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('ticket/resolved') ?>"
                                           class="nav-link ">
                                            <span class="title">Resolved Tickets</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) && config_item('enable_ad_incm') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-bullhorn"></i>
                                    <span class="title">Advt Income</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('ads/manage_ads') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Ads</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('ads/achievers') ?>"
                                           class="nav-link ">
                                            <span class="title">Ad Browsers</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) && config_item('enable_survey') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-list"></i>
                                    <span class="title">Survey Master</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('survey/manage_survey') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Surveys</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('survey/survey_report') ?>"
                                           class="nav-link ">
                                            <span class="title">Survey Reports</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (!isset($this->session->designation) && config_item('enable_recharge') == "Yes") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-mobile-phone"></i>
                                    <span class="title">Recharge Portal</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('recharge/records') ?>"
                                           class="nav-link ">
                                            <span class="title">Recharge Records</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (config_item('enable_help_plan') !== "Yes") { ?>
                            <?php if (!isset($this->session->designation) || $this->session->designation['invoice'] == "1") { ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link nav-toggle">
                                        <i class="fa fa-print"></i>
                                        <span class="title">Accounting & Invoice</span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('accounting/invoices') ?>"
                                               class="nav-link ">
                                                <span class="title">Invoices</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('accounting/purchase') ?>"
                                               class="nav-link ">
                                                <span class="title">Purchases</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('accounting/accounting') ?>"
                                               class="nav-link ">
                                                <span class="title">P/L Sheet</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo site_url('accounting/transactionlogs') ?>"
                                               class="nav-link ">
                                                <span class="title">Transaction Logs</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php }
                        } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['expense'] == "1") { ?>

                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-rupee"></i>
                                    <span class="title">Manage Expenses</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('admin/expense') ?>"
                                           class="nav-link ">
                                            <span class="title">Manage Expenses</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="heading">
                            <h3 class="uppercase">Important Tools</h3>
                        </li>
                        <?php if (!isset($this->session->designation)) { ?>
                            <li class="nav-item">
                                <a target="_blank" href="<?php echo site_url('site/documentation') ?>"
                                   class="nav-link ">
                                    <i class="fa fa-book"></i>
                                    <span class="title">Documentations</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo site_url('setting/export') ?>"
                                   class="nav-link ">
                                    <i class="fa fa-database"></i>
                                    <span class="title">Export & Import</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo site_url('setting/marketing') ?>"
                                   class="nav-link ">
                                    <i class="fa fa-life-ring"></i>
                                    <span class="title">Marketing Tools</span>
                                </a>
                            </li>
                        <?php } ?> -->
        <!-------------------------------- New Edited Menu Begining ------------------------------------>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-cogs"></i>
                                    <span class="title">Settings</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-cog" style="color:#6b7b10;"></i>
                                            <span class="title">Admin Settings</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('admin/setting') ?>" class="nav-link ">
                                                        <span class="title">Update Admin</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('admin/setting') ?>" class="nav-link ">
                                                        <span class="title">Change Password</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-user-secret" style="color:#6b7b10;"></i>
                                            <span class="title">Staff Manager</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('staff/designations') ?>" class="nav-link ">
                                                        <span class="title">Add Staff Designation</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('staff/designations') ?>" class="nav-link ">
                                                        <span class="title">View Staff Designation</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('staff/new-staff') ?>" class="nav-link ">
                                                        <span class="title">Add Staff</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('staff/list-staffs') ?>" class="nav-link ">
                                                        <span class="title">View Staff</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-eye" style="color:#6b7b10;"></i>
                                            <span class="title">Surveillance</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('setting/user_rights') ?>" class="nav-link ">
                                                        <span class="title">Admin User Rights</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li> -->
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-briefcase"></i>
                                    <span class="title">Distributor Profile</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-user-plus" style="color:#6b7b10;"></i>
                                            <span class="title">Admin Registration</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('Distributor/create_registration') ?>" class="nav-link ">
                                                        <span class="title">Create Registration</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('Distributor/view_registration') ?>" class="nav-link ">
                                                        <span class="title">View Registration</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-user-plus" style="color:#6b7b10;"></i>
                                            <span class="title">Member Registration</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('staff/designations') ?>" class="nav-link ">
                                                        <span class="title">Activated Member</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('blocked-members') ?>" class="nav-link ">
                                                        <span class="title">Deactivated Member</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('users/view-members') ?>" class="nav-link ">
                                                        <span class="title">Change Password</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('users/view-members') ?>" class="nav-link ">
                                                        <span class="title">View Profile</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('users/view-members') ?>" class="nav-link ">
                                                        <span class="title">Edit Profile</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-puzzle-piece"></i>
                                    <span class="title">E-Pin Manager</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Epin/epin_login') ?>" class="nav-link ">
                                            <span class="title">Login</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-money"></i>
                                    <span class="title">Payouts</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('wallet/generate-payout') ?>" class="nav-link ">
                                            <span class="title">Create Level Income</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('income/tax-report') ?>" class="nav-link ">
                                            <span class="title">TDS Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-file-text"></i>
                                    <span class="title">Reports Manager</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/view-members') ?>" class="nav-link ">
                                            <span class="title">Direct Members</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/view-members') ?>" class="nav-link ">
                                            <span class="title">Member Level Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/latest-members') ?>" class="nav-link ">
                                            <span class="title">Topup Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('users/search_user') ?>" class="nav-link ">
                                            <span class="title">Member Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('income/search-payout') ?>" class="nav-link ">
                                            <span class="title">Member Total Payout Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('tree/downline-report') ?>" class="nav-link ">
                                            <span class="title">Max Business Downline Memebers</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('income/make-payment') ?>" class="nav-link ">
                                            <span class="title">Package Wise Payot Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Reports/profit_loss') ?>" class="nav-link ">
                                            <span class="title">Profit Loss Report</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('income/make-payment') ?>" class="nav-link ">
                                            <span class="title">Total Payout Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-cubes"></i>
                                    <span class="title">Products Manager</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-th-large" style="color:#6b7b10;"></i>
                                            <span class="title">Category</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('admin/manage_cat') ?>" class="nav-link ">
                                                        <span class="title">Add Category</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('admin/manage_cat') ?>" class="nav-link ">
                                                        <span class="title">View Category</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-gift" style="color:#6b7b10;"></i>
                                            <span class="title">Products</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('product/add_product') ?>" class="nav-link ">
                                                        <span class="title">Add Products</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('product/manage_products') ?>" class="nav-link ">
                                                        <span class="title">View Products</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-link"></i>
                                    <span class="title">More Link</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-newspaper-o" style="color:#6b7b10;"></i>
                                            <span class="title">News Manager</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('Links/news_update') ?>" class="nav-link ">
                                                        <span class="title">News Update</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('Links/view_news') ?>" class="nav-link ">
                                                        <span class="title">View News</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-clock-o" style="color:#6b7b10;"></i>
                                            <span class="title">Schedules</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link ">
                                                        <span class="title">Create Schedules</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#" class="nav-link ">
                                                        <span class="title">View Schedules</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="#" class="nav-link nav-toggle">
                                            <i class="fa fa-envelope-o" style="color:#6b7b10;"></i>
                                            <span class="title">Support Center</span>
                                            <span class="arrow"></span>
                                            <ul class="sub-menu">
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('setting/email_marketing') ?>" class="nav-link ">
                                                        <span class="title">Compose</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('Links/inbox') ?>" class="nav-link ">
                                                        <span class="title">Inbox</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo site_url('Links/outbox') ?>" class="nav-link ">
                                                        <span class="title">Outbox</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-picture-o"></i>
                                    <span class="title">Gallery</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Gallery/add_category') ?>" class="nav-link ">
                                            <span class="title">Add Category</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Gallery/view_category') ?>" class="nav-link ">
                                            <span class="title">View Category</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Gallery/add_photo') ?>" class="nav-link ">
                                            <span class="title">Add Photos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('Gallery/view_photo') ?>" class="nav-link ">
                                            <span class="title">View Photos</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if (!isset($this->session->designation) || $this->session->designation['b_setting'] == "1") { ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link nav-toggle">
                                    <i class="fa fa-check-square-o"></i>
                                    <span class="title">Agent KYC</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('KYC/confirm_agent') ?>" class="nav-link ">
                                            <span class="title">Confirm Agent KYC</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo site_url('KYC/approved_reject') ?>" class="nav-link ">
                                            <span class="title">Approved/Reject Agent KYC</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
    <!------------------------------------- New Edited Menu End ------------------------------------>
                        <li class="nav-item">
                            <a href="<?php echo site_url('admin/logout') ?>"
                               class="nav-link ">
                                <i class="fa fa-power-off"></i>
                                <span class="title">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-bar">
                    <div class="page-title-breadcrumb">
                        <div class=" pull-left">
                            <div class="page-title"><?php echo $title; ?></div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <li><i class="fa fa-home"></i>&nbsp;<a
                                        class="parent-item"
                                        href="<?php echo site_url('admin') ?>">Home</a>&nbsp;<i
                                        class="fa fa-angle-right"></i>
                            </li>
                            <li class="active"><?php echo $breadcrumb; ?></li>
                        </ol>
                    </div>
                </div>
                <?php
                echo validation_errors('<div class="alert alert-danger">', '</div>');
                echo $this->session->flashdata('common_flash');
                if (trim($layout) !== "") {
                    require_once($layout);
                } else if (isset($this->session->designation)) {

                    echo '<h1 align="center"> Welcome Again ' . $this->session->name . '</h1>';
                } else { ?>
                    <?php if (config_item('is_demo') == TRUE) {
                        echo '<div class="alert alert-danger">Please Pay your software development remaining balance to remove this banner !<br/> इस बैनर को हटाने के
 लिए कृपया अपनी शेष राशि का भुगतान करें !</div>';
                    } ?>
                    <div class="row">
                        <div class="state-overview">
                            <div class="col-lg-3 col-sm-6">
                                <div class="overview-panel purple">
                                    <div class="symbol">
                                        <i class="fa fa-users usr-clr"></i>
                                    </div>
                                    <div class="value white">
                                        <p class="sbold addr-font-h1"
                                           data-counter="counterup"
                                           data-value="23"><?php echo $this->db_model->count_all('member') ?></p>
                                        <p>Total Users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="overview-panel green-bgcolor">
                                    <div class="symbol">
                                        <i class="fa fa-rupee"></i>
                                    </div>
                                    <div class="value white">
                                        <p class="sbold addr-font-h1"
                                           data-counter="counterup"
                                           data-value="48"><?php if ($earnnings == "") {
                                                $earnnings = 0;
                                            }
                                            echo $earnnings ?></p>
                                        <p>Earnings</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="overview-panel orange">
                                    <div class="symbol">
                                        <i class="fa fa-rupee"></i>
                                    </div>
                                    <div class="value white">
                                        <p class="sbold addr-font-h1"
                                           data-counter="counterup"
                                           data-value="14"><?php if ($payout == "") {
                                                $payout = 0;
                                            }
                                            echo $payout ?></p>
                                        <p>Member Income</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="overview-panel blue-bgcolor">
                                    <div class="symbol">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <div class="value white">
                                        <p class="sbold addr-font-h1"
                                           data-counter="counterup"
                                           data-value="3421"><?php $data = $this->db_model->sum('topup', 'member', array('join_time' => date('Y-m-d')));
                                            if ($data == "") {
                                                $data = 0;
                                            }
                                            echo $data ?></p>
                                        <span>$</span>
                                        <p>Today's Earning</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-topline-aqua">

                                <div class="card-body no-padding height-9">
                                    <div class="row">
                                        <div id="donutchart"
                                             style="width: auto; height: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="expense">
                            <div class="card card-topline-aqua">
                                <div class="card-head">
                                    <header>Add Expense</header>
                                    <div class="tools">
                                        <a class="t-close btn-color fa fa-times"
                                           href="javascript:;"></a>
                                    </div>
                                </div>
                                <div class="card-body no-padding height-9">
                                    <div class="row">
                                        <?php echo $this->session->flashdata('other_flash') ?>
                                        <?php echo form_open('admin/add_expense') ?>
                                        <label>Expense Name</label>
                                        <input type="text" required name="ename"
                                               class="form-control">
                                        <label>Expense Amount</label>
                                        <input type="text" required
                                               name="eamount"
                                               class="form-control">
                                        <label>Expense Detail</label>
                                        <input type="text" name="edetail"
                                               class="form-control">
                                        <label>Expense Date</label>
                                        <input type="text" required readonly
                                               name="edate"
                                               class="form-control datepicker">
                                        <button type="submit"
                                                class="btn btn-success btn-lg pull-right glyphicon glyphicon-plus-sign"></button>
                                        <?php echo form_close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card  card-topline-yellow">
                                <div class="card-head">
                                    <header>Latest Joinings</header>
                                    <div class="tools">
                                        <a class="t-close btn-color fa fa-times"
                                           href="javascript:;"></a>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table display product-overview mb-30"
                                                   id="support_table">
                                                <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Sponsor ID</th>
                                                    <th>Phone</th>
                                                    <th>Join Date</th>
                                                    <th>Total Downline</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <?php
                                                $sn = 1;
                                                foreach ($members as $e) { ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td>
                                                            <a href="<?php echo site_url('users/user_detail/' . $e['id']) ?>"
                                                               target="_blank"><?php echo config_item('ID_EXT') . $e['id']; ?></a>
                                                        </td>
                                                        <td><?php echo $e['name']; ?></td>
                                                        <td>
                                                            <a href="<?php echo site_url('users/user_detail/' . $e['sponsor']) ?>"
                                                               target="_blank"><?php echo $e['sponsor'] ? config_item('ID_EXT') . $e['sponsor'] : ''; ?>
                                                        </td>
                                                        <td><?php echo $e['phone']; ?></td>
                                                        <td><?php echo $e['join_time']; ?></td>
                                                        <td><?php echo($e['total_a'] + $e['total_b'] + $e['total_c'] + $e['total_d'] + $e['total_e']); ?></td>
                                                        <td>
                                                            <a href="<?php echo site_url('users/user_detail/' . $e['id']); ?>"
                                                               class="btn btn-warning btn-xs">View</a><a
                                                                    href="<?php echo site_url('users/edit_user/' . $e['id']); ?>"
                                                                    class="btn btn-info btn-xs">Edit</a>
                                                            <a onclick="return confirm('Are you sure you want to delete this Member ?')"
                                                               href="<?php echo site_url('users/remove_member/' . $e['id']); ?>"
                                                               class="btn btn-danger btn-xs">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner"> <?php echo date('Y') ?>
            &copy; <?php echo config_item('company_name') ?>
        </div>
        <div class="scroll-to-top">
            <i class="fa fa-arrow-up"></i>
        </div>
    </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"
        type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url('axxets/admin/theme.js') ?>"></script>
<script src="https://cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({html: true, placement: "top"});
    });
</script>
<script>
    $(function () {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            yearRange: "-70:+70",
            changeMonth: true,
            changeYear: true,
            defaultDate: 0,
            showOptions: {direction: "down"},
        });
    });
</script>
</body>
</html>
