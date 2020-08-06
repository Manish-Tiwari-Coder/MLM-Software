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
            <th>Ticket Subject</th>
            <th>Date</th>
            <th style="background-color: #d6e9c6">Status</th>
            <th>#</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($data as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->ticket_title; ?></td>
                <td><?php echo $e->date; ?></td>
                <td style="background-color: #d6e9c6"><?php echo $e->status; ?></td>
                <td><a href="<?php echo site_url('ticket/view/' . $e->id) ?>" class="btn btn-xs btn-danger">View</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>

