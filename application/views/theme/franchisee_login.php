<?php echo form_open() ?>
<h2 align="center">Franchisee Login</h2><p>&nbsp;</p>
<div class="container" align="center">
    <div class="row" style="max-width: 400px; text-align: left">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>') ?>
        <?php echo $this->session->flashdata('site_flash') ?>
        <div class="form-group col-sm-12">
            <label for="user" class="control-label">Username</label>
            <input type="text" class="form-control" id="user" name="username">
        </div>
        <div class="form-group col-sm-12">
            <label for="password" class="control-label">Password*</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group col-sm-12">
            <button class="btn btn-success">Login</button>
            <a href="<?php echo site_url('site/forgotpw-fran') ?>">Forgot Password ?</a>
        </div>
    </div>
</div>
<?php echo form_close() ?>
