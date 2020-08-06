<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open('franchisee/sale_product') ?>
<div class="row">
    <div class="col-sm-6 ui-widget">
        <label>Product Name</label>
        <select name="pname" id="pname" class="form-control">
            <?php
            $this->db->select('product_id, available_qty')->where('franchisee_id', $this->session->fran_id)
                     ->where('available_qty >', 0);
            $data = $this->db->get('franchisee_stock')->result();
            foreach ($data as $e) {
                echo '<option value="' . $e->product_id . '">' . $this->db_model->select('prod_name', 'product', array('id' => $e->product_id)) . ' (Available Qty: ' . $e->available_qty . ')</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-sm-6">
        <br/>
        <button type="button" onclick="populate()" class="btn btn-info">Populate</button>
    </div>
</div>
<div class="row" id="hidden" style="display: none">
    <div class="col-sm-12">
        <h3 class="hr_divider"><br/>
        </h3>
        <p style="margin-top:100px;">
        <div id="res"></div>
        <p>
            <label>Member ID</label>
            <input style="max-width: 200px" type="text" class="form-control" name="userid" id="userid" required>
        </p>
        <button class="btn btn-success" name="submit" value="add">Sale</button>
        </p>
    </div>
</div>
<script>
    function remove(id) {
        $(id).remove();
    }

    function populate() {

        $("#hidden").show('slow');
        var prod_id = $("#pname").val();
        var prod_title = $("#pname option:selected").text();

        $("#res").append(
            '<div id="' + prod_id + '" style="border-bottom: 1px solid #ccc; padding: 5px"> <strong>Product Name :</strong> ' + prod_title + ' <input type="hidden' +
            '" name="prod_name[]" value="' + prod_id + '">' +
            '<strong><br/>Qty</strong> <input style="max-width: 40px" value="1" name="qty[]"> <a href="javascript:;" onclick="remove(\'#' + prod_id + '\')" class="btn btn-danger glyphicon glyphicon-remove"></a></div>'
        );
    }
</script>
<?php echo form_close() ?>

