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
<div class="row">
    <div class="form-group">
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                <input placeholder="Enter User ID" class="form-control" name="uid">
            </div>
        </div>
    </div>
    Or
    <div class="form-group">
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-pushpin"></span></span>
                <input class="form-control" name="epin" placeholder="Enter e-PIN">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
            <input type="submit" class="btn btn-primary" value="Search" onclick="this.value='Searching..'"></div>
    </div>
</div><p>&nbsp;</p>
<?php echo form_close() ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Epin</th>
            <th>Amount</th>
            <th>Issued To</th>
            <th>Transferred By</th>
            <th>Used By</th>
            <th>Used Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($epin as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e['epin']; ?></td>
                <td><?php echo $e['amount']; ?></td>
                <td><?php echo $e['issue_to'] ? config_item('ID_EXT') . $e['issue_to'] : ''; ?></td>
                <td><?php echo $e['transfer_by'] ? config_item('ID_EXT') . $e['transfer_by'] : ''; ?></td>
                <td><?php echo $e['used_by'] ? config_item('ID_EXT') . $e['used_by'] : ''; ?></td>
                <td><?php echo $e['used_time']; ?></td>
                <td>
                    <a href="<?php echo site_url('admin/epin/edit/' . $e['id']); ?>"
                       class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this epin ?')"
                       href="<?php echo site_url('admin/epin/remove/' . $e['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
