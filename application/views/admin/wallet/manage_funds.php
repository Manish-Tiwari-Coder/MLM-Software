<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open() ?>
<div class="row">
    <div class="col-sm-6">
        <label>Enter User ID</label>
        <input type="text" class="form-control" id="uid" name="uid">
    </div>
    <div class="col-sm-6">
        <br/>
        <button type="button" onclick="populate()" class="btn btn-info">Populate</button>
    </div>
</div>
<div class="row" id="hidden" style="display: none">
    <div class="col-sm-6">
        <h3 class="hr_divider"><br/>
            <strong><strong style="color: #3a80d7">Available Wallet Balance:
                    <span id="qty"></span></strong>
        </h3>
        <p style="margin-top:100px;">
            <label>Add or Deduct Balance:</label>
            <input type="text" name="balance" required class="form-control" value="1"><br/>
            <button class="btn btn-success" name="submit" value="add">Add</button>
            <button class="btn btn-danger" name="submit" value="remove">Remove</button>
        </p>
    </div>
</div>
<script type="text/javascript">
    function populate() {
        var uid = $('#uid').val();
        if (uid == "") {
            alert('Please enter User ID');
        } else {
            $.get("<?php echo site_url('cron/get_wallet_balance/') ?>" + uid, function (data) {
                $("#hidden").show('slow');
                $("#qty").html(data);
            });
        }
    }
</script>
<?php echo form_close() ?>

