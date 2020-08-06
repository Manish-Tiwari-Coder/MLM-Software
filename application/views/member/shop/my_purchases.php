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
            <th>Product Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Order Date</th>
            <th>Delivery Date</th>
            <th>Sold By</th>
            <th>Status</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($data as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $this->db_model->select('prod_name', 'product', array('id' => $e->product_id)); ?></td>
                <td><?php echo config_item('currency') . $e->cost; ?></td>
                <td><?php echo $e->qty; ?></td>
                <td><?php echo $e->date; ?></td>
                <td><?php echo $e->deliver_date; ?></td>
                <td><?php echo $e->franchisee_id; ?></td>
                <td><?php echo $e->status; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>

