<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Eamil</th>
            <th>Action</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->name; ?></td>
                <td><?php echo $e->username; ?></td>
                <td><?php echo $e->email; ?></td>
                <td><a href="<?php echo site_url('staff/edit-des/' . $e->id); ?>" class="btn btn-info btn-xs">Edit</a><a
                            onclick="return confirm('Are you sure you want to delete this Admin ?')"
                            href="<?php echo site_url('Admin/remove-admin/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>