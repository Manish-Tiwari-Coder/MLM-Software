<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="row">
    <?php echo form_open('ads/achievers') ?>
    <div class="col-sm-6">
        <label>User ID</label>
        <input class="form-control" name="userid" type="text">
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Search" onclick="this.value='Searching..'">
    </div>
    <?php echo form_close() ?>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>SN</th>
            <th>Ad Title</th>
            <th>Expiry Date</th>
            <th>User ID</th>
            <th>Viewed Date</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($ads as $e) {
            $data = $this->db_model->select_multi('ad_title, expiry_date', 'ads', array('id' => $e->ad_id));
            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $data->ad_title; ?></td>
                <td><?php echo $data->expiry_date; ?></td>
                <td>
                    <a target="_blank" href="<?php echo site_url('users/user_detail/' . $e->userid) ?>"> <?php echo config_item('ID_EXT') . $e->userid; ?></a>
                </td>
                <td><?php echo date('d/m/Y : h:i A', $e->date); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>