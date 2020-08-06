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
            <th>Package Name</th>
            <th>Amount</th>
            <th>ROI</th>
            <th>ROI Payout</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result

                 as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->pack_name; ?></td>
                <td><?php echo config_item('currency') . $e->amount; ?></td>
                <td><?php echo $e->roi; ?></td>
                <td>Every <?php echo $e->roi_frequency; ?> days</td>
                <td>
                    <a href="<?php echo site_url('investments/edit_pack/' . $e->id); ?>" class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this Package ?')"
                       href="<?php echo site_url('investments/remove_inv_pack/' . $e->id); ?>"
                       class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
