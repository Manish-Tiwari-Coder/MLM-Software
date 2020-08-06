<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<a href="<?php echo site_url('product/add_product') ?>" class="btn btn-xs btn-success">Add New Product</a>
<div class="row table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Name</th>
            <th>Price + Tax</th>
            <th>Image</th>
            <th>Qty Avlb.</th>
            <th>Qty Sold</th>
            <th>Joining Product ?</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($prod as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e['prod_name']; ?></td>
                <td><?php echo config_item('currency') . " " . $this->common_model->filter($e['prod_price'] + ($e['prod_price'] * $e['gst'] / 100), 'decimal'); ?></td>
                <td>
                    <img src="<?php echo $e['image'] ? base_url('uploads/' . $e['image']) : base_url('uploads/default.jpg'); ?>"
                         class="img-thumbnail img-responsive" style="max-height: 100px"></td>
                <td><?php echo $e['qty']; ?></td>
                <td><?php echo $e['sold_qty']; ?></td>
                <td><?php echo $e['show_on_regform']; ?></td>
                <td>
                    <a href="<?php echo site_url('product/view/' . $e['id']); ?>" class="btn btn-danger btn-xs">View</a>
                    <a href="<?php echo site_url('product/edit/' . $e['id']); ?>" class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure you want to delete this Product ?')"
                       href="<?php echo site_url('product/remove/' . $e['id']); ?>"
                       class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div class="pull-right">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>