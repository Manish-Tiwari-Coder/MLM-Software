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
    <?php echo form_open('accounting/search_purchase') ?>
    <div class="col-sm-6">
        <label>Date Start</label>
        <input class="form-control datepicker" readonly name="sdate" type="text">
    </div>
    <div class="col-sm-6">
        <label>Date End</label>
        <input class="form-control datepicker" readonly name="edate" type="text">
    </div>
    <div class="col-sm-6">
        <label>Bill No</label>
        <input class="form-control" name="billno" type="text">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">
    </div>
    <?php echo form_close() ?>
</div>
<div class="row">
    <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-lg pull-right"><i class="fa fa-chrome"></i>
        Add Purchase</a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Supplier Name</th>
            <th>Bill No</th>
            <th>Total Amt</th>
            <th>Paid Amt</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($bills as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->supplier; ?></td>
                <td><?php echo $e->bill_no; ?></td>
                <td><?php echo config_item('currency') . $e->bill_amt; ?></td>
                <td><?php echo config_item('currency') . $e->paid_amt; ?></td>
                <td><?php echo $e->date; ?></td>
                <td>
                    <a href="<?php echo site_url('accounting/purchase_view/' . $e->id); ?>" class="btn btn-info btn-xs">View</a>
                    <?php if ($e->bill_amt - $e->paid_amt > 0) { ?>
                        <a href="javascript:;" data-toggle="modal" onclick="document.getElementById('id').value='<?php echo $e->id ?>'" data-target="#addFund" class="btn btn-success btn-xs">Pay
                            Balance</a>
                    <?php } ?>
                    <a onclick="return confirm('Are you sure you want to delete this Bill ?')"
                       href="<?php echo site_url('accounting/remove_purchase/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Make New Purchase Entry</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('accounting/add-purchase') ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Supplier Bill No *</label>
                        <input required type="text" name="bill_no" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Bill Date *</label>
                        <input type="text" readonly value="<?php echo date('Y-m-d') ?>" name="date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Total Amount (in <?php echo config_item('currency') ?>) *</label>
                        <input required type="text" class="form-control" name="bill_amt">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Paid Amount (in <?php echo config_item('currency') ?>) *</label>
                        <input required type="text" class="form-control" name="paid_amt">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Supplier Name *</label>
                        <input required type="text" class="form-control" name="supplier">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Bill Copy (optional)</label>
                        <input type="file" name="copy">
                    </div>
                </div>
                <input type="hidden" id="dup" value="1">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Item Name *</label>
                        <input required type="text" class="form-control" name="item_name[]">
                    </div>
                    <div class="col-sm-4">
                        <label>Item Price (in <?php echo config_item('currency') ?>)*</label>
                        <input required type="text" class="form-control" name="item_price[]">
                    </div>
                    <div class="col-sm-4">
                        <br/>
                        <a href="javascript:;" onclick="add_item()" class="btn btn-xs btn-success">Add
                            Item +</a>
                    </div>
                </div>
                <div id="res"></div>
                <br/>
                <button type="submit" class="btn btn-primary">Add Purchase</button>
                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addFund" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Pay Balance for Bill</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('accounting/bill_add_fund') ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <input type="hidden" name="id" id="id" value="">
                        <label>Amount to Pay *</label>
                        <input required type="text" name="paid_amt" class="form-control">
                    </div>
                    <div class="form-group col-sm-6"><br/>
                        <button type="submit" class="btn btn-primary">Pay Balance &rarr;</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function add_item() {
            var rand = parseInt($('#dup').val()) + 1;
            $('#dup').val(rand);
            var data = '<div id="' + rand + '" class="row">\n' +
                '                        <div class="col-sm-4">\n' +
                '                            <label>Item Name *</label>\n' +
                '                            <input required type="text" class="form-control" name="item_name[]">\n' +
                '                        </div>\n' +
                '                        <div class="col-sm-4">\n' +
                '                            <label>Item Price (in <?php echo config_item('currency') ?>)*</label>\n' + '                            <input required type="text" class="form-control" name="item_price[]">\n' + '                        </div>\n' + '                        <div class="col-sm-4">\n' + '                            <br/>\n' + '                            <a href="javascript:;" onclick="remove_item(\'#' + rand + '\')" class="btn btn-xs btn-danger">Remove\n' + '                                Item</a>\n' + '                        </div>\n' + '                    </div>';
            $('#res').append(data);
        }

        function remove_item(id) {
            $(id).remove();
        }
    </script>