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
        <label>Enter Email IDs (Separated by Commas)</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            <input type="text" class="form-control" name="email_id" id="email_id">
        </div>
        <input onclick="disable('#all', '#email_id')" type="checkbox" id="all" name="all" value="1"> Send eMail to All
        Member
    </div>
    <div class="col-sm-6">
        <label>Subject</label>
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
            <input type="text" class="form-control" name="subject">
        </div>
    </div>
    <div class="col-sm-12">
        <label>Mail Content</label>
        <textarea name="msg" id="editor"></textarea>
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