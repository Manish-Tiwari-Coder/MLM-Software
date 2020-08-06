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
            <th>User ID</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Ref ID</th>
            <th>Date</th>
            <th>Pair Match</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($earning as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><a href="<?php echo site_url('users/user_detail/' . $e['userid']) ?>"
                       target="_blank"><?php echo config_item('ID_EXT') . $e['userid']; ?></a></td>
                <td><?php echo config_item('currency') . $e['amount']; ?></td>
                <td><?php echo $e['type']; ?></td>
                <td><?php echo $e['ref_id'] ? config_item('ID_EXT') . $e['ref_id'] : ""; ?></td>
                <td><?php echo $e['date']; ?></td>
                <td><?php echo $e['pair_match']; ?></td>
                <td>
                    <a href="<?php echo site_url('income/edit_earning/' . $e['id']); ?>" class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this Record ?')"
                       href="<?php echo site_url('income/remove_earning/' . $e['id']); ?>"
                       class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
