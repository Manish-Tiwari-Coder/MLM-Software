<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open('adm_franchisee/update_stock') ?>
<div class="row">
    <div class="col-sm-12">
        <label>Franchisee Name</label>
        <select class="form-control" name="fname" id="fname">
            <option selected value="" required>Choose One</option>
            <?php foreach ($fran as $data): ?>
                <option value="<?php echo $data->id ?>"><?php echo $data->name ?> (Business
                    Name: <?php echo $data->business_name ?>
                    /
                    Username: <?php echo $data->username ?>
                    )
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div><br/>
<div class="row">
    <div class="col-sm-6 ui-widget">
        <label>Product Name</label>
        <input type="text" class="form-control" name="pname" id="pname">
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
        <h2>Add Qty:</h2>
        <div id="res"></div>
        <p>
            <label>Total Amount</label>
            <input style="max-width: 200px" type="text" class="form-control" name="total_amt" id="total_amt" value="0">
        </p>
        <p>
            <label>Paid Amount</label>
            <input style="max-width: 200px" type="text" class="form-control" name="paid_amt" id="paid_amt" value="0">
        </p>
        <button class="btn btn-success" name="submit" value="add">Transfer Stock</button>
        </p>
    </div>
</div>
<script>
    $(function () {
        $("#pname").autocomplete({
            source: '<?php echo site_url('cron/get_products') ?>'
        });
    });

    function remove(id) {
        $(id).remove();
    }

    function populate() {
        var fran_id = $('#fname').val();
        var prod_name = $('#pname').val();
        var id = Math.floor(Math.random() * 20);

        if (prod_name == "" || fran_id == "") {
            alert('Please enter product name and Select Franchisee');
        } else {
            $.post("<?php echo site_url('cron/get_stock_qty/') ?>", {fran_id: fran_id, prod: prod_name})
                .done(function (data) {
                    $("#hidden").show('slow');
                    $("#res").append(
                        '<div class="row" id="' + id + '"> <div class="col-sm-6"> <label>Product Name</label> <input readonly name="prod_name[]" class="form-control" value="' + prod_name + '"></div>' +
                        '<div class="col-sm-6"> <label> Add Stock</label> <input style="max-width: 60px" value="1" name="qty[]"> <a href="javascript:;" onclick="remove(\'#' + id + '\')" class="btn btn-danger glyphicon glyphicon-remove"></a> <br/>(This Franchisee currently has: ' + data + ' nos available.)</div></div><hr/>'
                    );
                });
        }
    }
</script>
<?php echo form_close() ?>

