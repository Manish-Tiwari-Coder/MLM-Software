<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Management Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style type="text/css">
        body
        {
            background:              url('<?php echo base_url('axxets/admin/bg_suburb.jpg')?>') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size:    cover;
            -o-background-size:      cover;
            background-size:         cover;
        }
        .panel-default
        {
            opacity:    0.9;
            margin-top: 0px;
        }
        .form-group.last
        {
            margin-bottom: 0px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>') ?>
        <?php echo $this->session->flashdata('admin_flash') ?>
       </br></br></br></br></br></br>
        <div class="col-md-4 col-md-offset-4">
		<img src="http://localhost/exodemo/uploads/logo.png" style="max-height: 50px; margin-left: 70px;"  alt="logo">
            <div class="panel panel-default">
                <div class="panel-heading"><strong><span class="glyphicon glyphicon-lock"></span> Management
                        Login</strong>

                </div>
                <div class="panel-body">
                    <?php echo form_open('site/admin', array('class' => 'form-horizontal')) ?>
                    <div class="form-group">
                        <label for="user" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="user" name="username" placeholder="Username"
                                   required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pass" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="pass" name="password" placeholder="Password"
                                   required="">
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm">Sign in</button>
                            <button type="reset" class="btn btn-default btn-sm">Clear</button>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="panel-footer"><a href="#" data-toggle="modal" data-target="#myModal">Forgot Password ?</a>
                </div>
                <div style="padding: 10px; font-size: 11px; text-align: right">
                    Copyright &copy; <?php echo config_item('company_name') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reset your password</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo form_open('site/admin_forget') ?>
                <div class="form-group">
                    <label>Enter Username/Email</label>
                    <input type="text" class="form-control" name="user">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Reset Password</button>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>

</body>
</html>
