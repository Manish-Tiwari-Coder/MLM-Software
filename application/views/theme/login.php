<?php echo form_open() ?>
<h2 align="center">Member Access</h2><p>&nbsp;</p>
<div class="container" align="center">
    <div class="row" style="max-width: 400px; text-align: left">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>') ?>
        <?php echo $this->session->flashdata('site_flash') ?>
        <?php if (config_item('is_demo') == TRUE) {
            echo '<div class="alert alert-danger">Please Pay your remaining balance to remove this banner !<br/> इस बैनर को हटाने के
 लिए कृपया अपनी शेष राशि का भुगतान करें !</div>';
        } ?>
        <div class="form-group col-sm-12">
            <label for="user" class="control-label">ID / Username</label>
            <input type="text" required class="form-control" id="user" name="username">
        </div>
        <div class="form-group col-sm-12">
            <label for="password" class="control-label">Password*</label>
            <input type="password" required class="form-control" id="password" name="password">
        </div>
        <div class="form-group col-sm-12">
            <button class="btn btn-success">Login</button>
            <a href="<?php echo site_url('site/forgotpw') ?>">Forgot Password ?</a>
        </div>
    </div>
</div>
<?php echo form_close() ?>
