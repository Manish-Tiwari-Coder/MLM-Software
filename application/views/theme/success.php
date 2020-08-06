<h2 align="center" style="color: green">Registration is Completed !</h2>
<div class="container">
    <?php echo $this->session->flashdata('site_flash') ?>
    <div class="row">
        Dear <?php echo $this->session->_user_name_ ?>,<br/>
        congratulation on your first step towards a rewarding career. We <?php echo config_item('company_name') ?> team
        cordially invite you to our home, where we make friends to earn and learn together. Below is your detail of
        Registration.
        <hr/>
        <strong>Sponsor ID :</strong> <?php echo config_item('ID_EXT') . $this->session->_sponsor_ ?><br/>
        <strong>User ID :</strong> <?php echo config_item('ID_EXT') . $this->session->_user_id_ ?><br/>
        <strong>Password :</strong> (<em>You have entered already.</em>)
        <hr/>

    </div>
    <div class="row" align="center">
        <a href="<?php echo site_url('site/auto_login') ?>" class="btn btn-success btn-lg">Login</a>
        <a href="<?php echo site_url('site/register') ?>" class="btn btn-primary btn-lg">Register Another</a>
    </div>
</div>
