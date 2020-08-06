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
    <table class="table table-stripe">
        <tr style="font-weight: bold">
            <td>Product Name</td>
            <td>Qty</td>
            <td>Order Date</td>
            <td>Status</td>
            <td>Total Cost</td>
        </tr>
        <tr>
            <td><?php echo $this->db_model->select('prod_name', 'product', array('id' => $orders->product_id)); ?></td>
            <td><?php echo $orders->qty ?></td>
            <td><?php echo $orders->date ?></td>
            <td><?php echo $orders->status ?></td>
            <td><?php echo config_item('currency') . ($orders->cost * $orders->qty) ?></td>
        </tr>
    </table>
</div>
<a href="javascript:history.back()" class="btn btn-xs btn-danger">Go Back</a>