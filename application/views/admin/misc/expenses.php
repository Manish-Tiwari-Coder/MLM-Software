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
            <th>Expense Name</th>
            <th>Amount</th>
            <th>Detail</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($expense as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->expense_name; ?></td>
                <td><?php echo config_item('currency') . $e->amount; ?></td>
                <td><?php echo $e->detail; ?></td>
                <td><?php echo $e->date; ?></td>
                <td>
                    <a onclick="return confirm('Are you sure you want to delete this Expense Entry ?')"
                       href="<?php echo site_url('admin/expense_remove/' . $e->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
