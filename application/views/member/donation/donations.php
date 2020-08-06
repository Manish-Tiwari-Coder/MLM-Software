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
            <th>Level</th>
            <th>Amount</th>
            <th>Receiver Id</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($result as $e) {
            $detail = $this->db_model->select_multi('name,phone', 'member', array('id' => $e->receiver_id));
            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td>
                    Stage <?php echo $this->db_model->select('donation_level', 'donation_package', array('id' => $e->donation_pack)); ?></td>
                <td><?php echo config_item('currency') . $e->donation_amount; ?></td>
                <td><?php echo $detail->name . '<br/>' . $detail->phone ?></td>
                <td><?php echo date('Y-m-d', $e->time); ?></td>
                <td style="font-weight: bold; color: #0d638f"><?php echo $e->status; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>