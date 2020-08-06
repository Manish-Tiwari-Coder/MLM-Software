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
            <th>User / Fran Id</th>
            <th>Gateway</th>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->userid; ?></td>
                <td><?php echo $e->gateway; ?></td>
                <td><?php echo $e->transaction_id; ?></td>
                <td><?php echo config_item('currency') . $e->amount; ?></td>
                <td><?php echo date('d/m/Y', $e->time); ?></td>
                <td>
                    <a onclick="return confirm('Are you sure you want to delete this Record ?')"
                       href="<?php echo site_url('accounting/remove_tlog/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>