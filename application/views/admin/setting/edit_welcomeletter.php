<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
$welcome_letter = file_get_contents(FCPATH . '/uploads/welcome_letter.txt');
?>
<div class="row">
    <?php echo form_open() ?>
    <div class="col-sm-12">
        <label>Design Your Welcome Letter Very Carefully</label>
        <div class="alert alert-info">
            <strong>Note: </strong><br/>
            {{member_name}} : Member Name<br/>
            {{member_phone}} : Member Phone No<br/>
            {{member_email}} : Member Email ID<br/>
            {{member_add}} : Member Address<br/>
            {{member_sponsor}} : Sponsor ID<br/>
            {{member_join_date}} : Member Join Date<br/>
            {{member_purchased}} : Purchased Package<br/>
        </div>
        <textarea id="editor"
                  name="welcome_letter"><?php echo set_value('welcome_letter', $welcome_letter) ?></textarea>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>