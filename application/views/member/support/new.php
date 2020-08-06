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
<div class="col-sm-12">
    <label>Subject in Breif*</label>
    <input type="text" class="form-control" value="<?php echo set_value('ticket_title') ?>" name="ticket_title">
</div>
<div class="col-sm-12">
    <label>Issue in Detail*</label>
    <textarea class="form-control" id="editor" name="ticket_data"><?php echo set_value('ticket_data') ?></textarea>
</div>
<div class="col-sm-12">
    <br/>
    <button type="submit" class="btn btn-primary">Submit</button>
    <br/><br/>
</div>
<?php echo form_close() ?>
