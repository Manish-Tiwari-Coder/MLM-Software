<h2 align="center" style="color: red">Registration is Failed ! Payment Not Made</h2>
<div class="container">
    <?php echo $this->session->flashdata('site_flash') ?>
    <div class="row">
        Dear <?php echo $this->session->_user_name_ ?>,<br/>
        We are sorry that, we are unable to complete your registration at this moment. Please try again from the
        begining.
        <hr/>
    </div>
    <div class="row" align="center">
        <a href="<?php echo site_url('site/register') ?>" class="btn btn-primary btn-lg">Register Again</a>
    </div>
</div>
