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
    <div align="center">
        <div class="fa fa-excel-o" style="font-size: 100px"></div>
        <br/>
    </div>
    <div class="col-sm-4">
        <?php echo form_open() ?>
        <label>Select Your Database</label><br/>
        <select class="form-control" name="table">
            <?php
            $tables = $this->db->list_tables();

            foreach ($tables as $table) {
                echo '<option>' . $table . '</option>';
            } ?>
        </select><br/>
        <button type="submit" class="btn btn-danger">
            Export to Excel &rarr;
        </button>
        <?php echo form_close() ?>
    </div>
</div>