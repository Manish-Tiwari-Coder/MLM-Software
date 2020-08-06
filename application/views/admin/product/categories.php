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
    <h4 align="center">Create New Category</h4>
    <hr/>
    <div class="form-group">
        <div class="col-sm-6">
            <label>Category Name*</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                <input type="text" class="form-control" name="cat_name">
            </div>
        </div>
        <div class="col-sm-6">
            <label>Parent Category</label>
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span></span>
                <select class="form-control" name="parent_cat">
                    <option value="" selected>No Parent</option>
                    <?php foreach ($parents as $val) {
                    echo '<option value="' . $val['id'] . '">' . $val['cat_name'] . '</option>';
                    } ?>
                </select>
            </div>
        </div>
        <div>&nbsp;</div>
        <div class="col-sm-12">
            <label>Category Description</label>
            <textarea class="form-control" id="editor"
                      name="description"><?php echo set_value('description') ?></textarea>
        </div>
        <div class="col-sm-12"><br/>
            <input type="submit" class="btn btn-success" value="Create" onclick="this.value='Creating..'">
        </div>

    </div>
    <?php echo form_close() ?>
</div>
<div class="row table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Category Title</th>
            <th>Parent</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($cat as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e['cat_name']; ?></td>
                <td><?php echo $this->db_model->select('cat_name', 'product_categories', array('id' => $e['parent_cat'])); ?></td>
                <td><?php echo strip_tags($e['description']); ?></td>
                <td>
                    <a href="<?php echo site_url('admin/category/edit/' . $e['id']); ?>" class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this Category ?')"
                       href="<?php echo site_url('admin/category/remove/' . $e['id']); ?>"
                       class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="pull-right">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>