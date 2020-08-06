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
            <th>Amount</th>
            <th>Type</th>
            <th>Ref ID</th>
            <th>Date</th>
            <th>Pair Match</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($earning as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo config_item('currency') . $e['amount']; ?></td>
                <td><?php echo $e['type']; ?></td>
                <td><?php echo $e['ref_id'] ? config_item('ID_EXT') . $e['ref_id'] : ""; ?></td>
                <td><?php echo $e['date']; ?></td>
                <td><?php echo $e['pair_match']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>
