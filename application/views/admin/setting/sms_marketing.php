<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="row">
    <?php echo form_open() ?>
    <div class="col-sm-6">
        <label>Enter Phone No (Separated by Commas)</label>
        <input type="text" class="form-control" id="phone_no" name="phone_no">
        <input onclick="disable('#all', '#phone_no')" type="checkbox" id="all" name="all" value="1"> Send SMS to All
        Member
    </div>
    <div class="col-sm-6">
        <label>Message Content (160 Char = 1 SMS)</label>
        <textarea class="form-control" name="msg"></textarea>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Send" onclick="this.value='Sending..'">
    </div>
    <?php echo form_close() ?>
</div>
<script type="text/javascript">
    function disable(id, id2) {
        if ($(id).prop("checked") == true) {
            $(id2).hide('slow');
        } else {
            $(id2).show('slow');
        }
    }
</script>