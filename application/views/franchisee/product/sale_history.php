<div class="panel-body table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>S.N.</td>
            <td>Product Name</td>
            <td>Member ID</td>
            <td>Qty</td>
            <td>Total Cost</td>
            <td>Delivery Date</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $sn = 1;
        foreach ($data as $data):
            ?>
            <tr>
                <td><?php echo $sn++ ?></td>
                <td><?php echo $this->db_model->select('prod_name', 'product', array('id' => $data->product_id)) ?></td>
                <td><?php echo $data->userid ?></td>
                <td><?php echo $data->qty ?></td>
                <td><?php echo config_item('currency') . $data->cost ?></td>
                <td><?php echo $data->deliver_date ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
