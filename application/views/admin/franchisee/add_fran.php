<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<script type="text/javascript">
    function check_user() {
        var data = $("#username").val();
        $.ajax({
            url: "<?php echo site_url('cron/check_user') ?>",
            method: "POST",
            data: {
                user: data,
            },
            success: function (response) {
                document.getElementById("result").innerHTML = response;
            },
        });
    }
</script>
<script type="text/javascript" src="<?php echo base_url('axxets/countries.js') ?>"></script>
<?php echo form_open() ?>
<div class="row">
    <div class="col-sm-6">
        <label>Franchisee Name*</label>
        <input type="text" class="form-control" required name="name">
    </div>
    <div class="col-sm-6">
        <label>Franchisee Username*</label>
        <input type="text" class="form-control" required name="username" id="username"><span id="result"></span>
        <a href="javascript:;" onclick="check_user()" style="font-size: 10px; color: #f00">Check Availability &rarr;</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <label>Store / Business Name</label>
        <input type="text" class="form-control" name="business_name">
    </div>
    <div class="col-sm-6">
        <label>Email ID</label>
        <input type="text" class="form-control" name="email">
    </div>
    <div class="col-sm-6">
        <label>Phone*</label>
        <input type="text" class="form-control" name="phone">
    </div>
    <div class="col-sm-6">
        <label>Country*</label>
        <select id="country" name="country" class="form-control"></select>
    </div>
    <div class="col-sm-6">
        <label>State*</label>
        <select name="state" id="state" class="form-control"></select>
    </div>
    <div class="col-sm-6">
        <label>Address</label>
        <input type="text" class="form-control" name="address">
    </div>

    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Create" onclick="this.value='Creating..'">
    </div>
    <?php echo form_close() ?>
</div>
<script language="javascript">
    populateCountries("country", "state");
</script>