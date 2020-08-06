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
    <?php echo form_open('accounting/search_invoice') ?>
    <div class="col-sm-6">
        <label>Date Start</label>
        <input class="form-control datepicker" readonly name="sdate" type="text">
    </div>
    <div class="col-sm-6">
        <label>Date End</label>
        <input class="form-control datepicker" readonly name="edate" type="text">
    </div>
    <div class="col-sm-6">
        <label>User ID</label>
        <input class="form-control" name="userid" type="text">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">
    </div>
    <?php echo form_close() ?>
</div>
<div class="row">
    <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-lg pull-right"><i class="fa fa-print"></i>
        Create Invoice</a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Invoice Name</th>
            <th>Userid</th>
            <th>Total Amt</th>
            <th>Paid Amt</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($invoice as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->invoice_name; ?></td>
                <td><?php echo $e->userid; ?></td>
                <td><?php echo config_item('currency') . $e->total_amt; ?></td>
                <td><?php echo config_item('currency') . $e->paid_amt; ?></td>
                <td><?php echo $e->date; ?></td>
                <td>
                    <a target="_blank" href="<?php echo site_url('accounting/invoice_view/' . $e->id); ?>" class="btn btn-info btn-xs">Print</a>
                    <?php if ($e->total_amt - $e->paid_amt > 0) { ?>
                        <a href="javascript:;" data-toggle="modal" onclick="document.getElementById('id').value='<?php echo $e->id ?>'" data-target="#addFund" class="btn btn-success btn-xs">Add
                            Balance</a>
                    <?php } ?>
                    <a onclick="return confirm('Are you sure you want to delete this Invoice ?')"
                       href="<?php echo site_url('accounting/remove_invoice/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create a New Invoice</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('accounting/add-invoice') ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Invoice Name *</label>
                        <input required type="text" name="invoice_name" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>User Id/Franchisee Id (Optional)</label>
                        <input type="text" name="user_id" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Invoice Date *</label>
                        <input type="text" readonly value="<?php echo date('Y-m-d') ?>" name="invoice_date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>User Type</label>
                        <select name="user_type" class="form-control">
                            <option>Franchisee</option>
                            <option>Member</option>
                            <option selected>Other</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Company Address *</label>
                        <textarea class="form-control" name="company_add">
<?php echo config_item('company_address') ?>
                        </textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Billing Address *</label>
                        <textarea class="form-control" name="bill_add">
Name:
Address:
Phone:</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Total Amount (in <?php echo config_item('currency') ?>) *</label>
                        <input required type="text" class="form-control" name="total_amt">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Paid Amount (in <?php echo config_item('currency') ?>) *</label>
                        <input required type="text" class="form-control" name="paid_amt">
                    </div>
                </div>
                <input type="hidden" id="dup" value="1">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Item Name *</label>
                        <input required type="text" class="form-control" name="item_name[]">
                    </div>
                    <div class="col-sm-3">
                        <label>Price (in <?php echo config_item('currency') ?>)*</label>
                        <input required type="text" class="form-control" name="item_price[]">
                    </div>
                    <div class="col-sm-2">
                        <label>Qty*</label>
                        <input required type="text" class="form-control" value="1" name="item_qty[]">
                    </div>
                    <div class="col-sm-3">
                        <label>Tax (eg: GST)(in <?php echo config_item('currency') ?>)</label>
                        <input type="text" class="form-control" name="item_tax[]">
                    </div>
                </div>
                <div id="res"></div>
                <div><a href="javascript:;" onclick="add_item()" class="btn btn-xs btn-success">Add
                        Item +</a>
                </div>
                <button type="submit" class="btn btn-primary">Create &rarr;</button>
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
                <h4 class="modal-title">Add Balance to Invoice</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('accounting/invoice_add_fund') ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <input type="hidden" name="id" id="id" value="">
                        <label>Amount to Add *</label>
                        <input required type="text" name="paid_amt" class="form-control">
                    </div>
                    <div class="form-group col-sm-6"><br/>
                        <button type="submit" class="btn btn-primary">Add Fund &rarr;</button>
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
            var data = '<div class="row" id="' + rand + '">\n' +
                '                    <div class="col-sm-4">\n' +
                '                        <label>Item Name *</label>\n' +
                '                        <input required type="text" class="form-control" name="item_name[]">\n' +
                '                    </div>\n' +
                '                    <div class="col-sm-3">\n' +
                '                        <label>Item Price*</label>\n' +
                '                        <input required type="text" class="form-control" name="item_price[]">\n' +
                '                    </div>\n'+
                '                    <div class="col-sm-2">\n' +
                '                        <label>Item Qty*</label>\n' +
                '                        <input required type="text" class="form-control" value="1" name="item_qty[]">\n' +
                '                    </div>\n' +
                '                    <div class="col-sm-3">\n' +
                '                        <label>Tax (eg: GST)(in <?php echo config_item('currency') ?>)</label>\n' +
                '                        <input type="text" class="form-control" name="item_tax[]">\n' +
                '                    </div>\n' +
                '<div>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="remove_item(\'#' + rand + '\')" class="btn btn-xs btn-danger">Remove </a>' +
                '</div>' +
                '                </div>';
            $('#res').append(data);
        }

        function remove_item(id) {
            $(id).remove();
        }
    </script>