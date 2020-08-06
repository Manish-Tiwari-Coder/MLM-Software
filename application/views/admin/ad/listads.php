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
    <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-lg pull-right"><i class="fa fa-bullhorn"></i>
        Create New Ad</a>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Ad Title</th>
            <th>Expiry Date</th>
            <th>Type</th>
            <th>Total Visit</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($ads as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->ad_title; ?></td>
                <td><?php echo $e->expiry_date; ?></td>
                <td><?php echo $e->type; ?></td>
                <td><?php echo $this->db_model->count_all('ad_user', array('ad_id' => $e->id)); ?></td>
                <td>
                    <a target="_blank" href="<?php echo site_url('ads/preview/' . $e->id); ?>" class="btn btn-info btn-xs">Preview</a>
                    <a href="<?php echo site_url('ads/edit/' . $e->id); ?>" class="btn btn-danger btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this Ad ?')"
                       href="<?php echo site_url('ads/remove/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
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
                <h4 class="modal-title">Create a New Ad</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('ads/create') ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>Ad Title *</label><br/>
                        <input required type="text" name="ad_title" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Expiry Date *</label>
                        <input type="text" readonly value="<?php echo date('Y-m-d') ?>" name="expiry_date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Ad HTML Code / URL *</label>
                        <textarea class="form-control" rows="10" name="ad_html">
                        </textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Level Earning  (in <?php echo config_item('currency') ?>)<br/>
                            <span style="font-size: 13px; color: red">(Comma Separated. First one is self income. If you donot want to give
                            direct or self income please use 0. eg: 0, 5, 6)</span></label>
                        <input type="text" name="level_earning" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Type *</label>
                        <select class="form-control" name="type">
                            <option value="html">HTML / Text</option>
                            <option value="url">URL</option>
                        </select>
                    </div>
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