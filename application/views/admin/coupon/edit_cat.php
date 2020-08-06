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
    <div class="col-sm-12">
        <label>Category Name</label>
        <input type="text" class="form-control" value="<?php echo set_value('cat_name', $result->cat_name) ?>"
               name="cat_name">
    </div>
    <input type="hidden" name="id" value="<?php echo $result->id ?>">
    <div class="col-sm-12">
        <label>Category Description</label>
        <textarea id="editor" class="form-control"
                  name="cat_desc"><?php echo set_value('cat_desc', $result->cat_description) ?></textarea>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Update" onclick="this.value='Updating..'">
    </div>
    <?php echo form_close() ?>
</div>