<?php echo form_open() ?>
<h2 align="center">Recover your Password</h2><p>&nbsp;</p>
<div class="container" align="center">
    <div class="row" style="max-width: 400px; text-align: left">
        <div class="form-group col-sm-12">
            <label for="user" class="control-label">ID / Username</label>
            <input type="text" class="form-control" id="user" name="user">
        </div>
        <div class="form-group col-sm-12">
            <button class="btn btn-success">Reset Password</button>
            <a href="<?php echo site_url('site/login') ?>">Want to Login ?</a>
        </div>
    </div>
</div>
<?php echo form_close() ?>
