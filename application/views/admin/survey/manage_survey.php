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
    <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-lg pull-right"><i class="fa fa-list"></i>
        Add New Survey</a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Survey Name</th>
            <th>Expiry Date</th>
            <th>Type</th>
            <th>Total Submission</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($survey as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->survey_name; ?></td>
                <td><?php echo $e->expiry_date; ?></td>
                <td><?php echo $e->type; ?></td>
                <td><?php echo $this->db_model->count_all('survey_user', array('survey_id' => $e->id)); ?></td>
                <td>
                    <a target="_blank" href="<?php echo site_url('survey/preview/' . $e->id); ?>" class="btn btn-info btn-xs">Preview</a>
                    <a onclick="return confirm('Are you sure you want to delete this Survey ?')"
                       href="<?php echo site_url('survey/remove/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
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
                <h4 class="modal-title">Add a New Survey</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="dup" value="1">
                <?php echo form_open('survey/create') ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Survey Title *</label><br/>
                        <input required type="text" name="survey_name" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Expiry Date *</label>
                        <input type="text" readonly value="<?php echo date('Y-m-d') ?>" name="expiry_date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Level Earning (in <?php echo config_item('currency') ?>)<br/>
                            <span style="font-size: 13px; color: red">(Comma Separated. First one is self income. If you donot want to give
                            direct or self income please use 0. eg: 0, 5, 6)</span></label>
                        <input type="text" name="level_earning" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        Type: Third Party means using other survey like mailchimp.<br/>
                        <input onclick="toogle('hosted')" checked type="radio" name="type" value="Hosted Survey"> Hosted
                        Survey<br/>
                        <input onclick="toogle('thirdparty')" type="radio" name="type" value="Third Party"> Third Party
                    </div>
                </div>
                <div class="row" id="hosted">
                    <div><a href="javascript:;" onclick="add_item()" class="btn btn-xs btn-success">Add
                            Item +</a>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Enter Survey Question</label>
                        <input type="text" class="form-control" name="qust[]">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Options (Separated by comma)</label>
                        <input type="text" placeholder="Leave blank to show text field" class="form-control" name="ans[]">
                    </div>
                    <div id="res"></div>
                </div>
                <div class="row">
                    <div id="thirdparty" style="display: none">
                        <div class="form-group col-sm-12">
                            <label>Enter Thirdparty URL Here</label>
                            <input type="text" class="form-control" name="thirdparty_url">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">Create &rarr;</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function add_item() {
        var rand = parseInt($('#dup').val()) + 1;
        $('#dup').val(rand);
        $('#res').append(' <div id="' + rand + '">\n' +
            '                  <div class="form-group col-sm-6">\n' +
            '                        <label>Enter Survey Question</label>\n' +
            '                        <input type="text" class="form-control" name="qust[]">\n' +
            '                    </div>\n' +
            '                    <div class="form-group col-sm-6">\n' +
            '                        <label>Options (Separated by comma)</label>\n' +
            '                        <input type="text" placeholder="Leave blank to show text field" class="form-control" name="ans[]">\n' +
            '                    </div>\n' +
            '                <a href="javascript:;" onclick="remove_item(\'#' + rand + '\')" class="btn btn-xs btn-danger">Remove</a></div>');
    }

    function remove_item(id) {
        $(id).remove();
    }

    function toogle(type) {
        if (type == "hosted") {
            $('#hosted').show('slow');
            $('#thirdparty').hide('slow');
        }
        if (type == "thirdparty") {
            $('#hosted').hide('slow');
            $('#thirdparty').show('slow');
        }
    }
</script>