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
            <th>Ad Title</th>
            <th>Expiry Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($ads as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->ad_title; ?></td>
                <td><?php echo $e->expiry_date; ?></td>
                <td><?php if ($this->db_model->count_all('ad_user', array(
                            'ad_id'  => $e->id,
                            'userid' => $this->session->user_id,
                        )) > 0) {
                        echo '<strong style="color: darkgreen">Viewed</strong>';
                    }
                    else {
                        echo '<strong style="color: red">Not-Viewed</strong>';
                    } ?></td>
                <td>
                    <?php if ($e->expiry_date >= date('Y-m-d')) { ?>
                        <a target="_blank" href="<?php echo site_url('ads/ad_view/' . $e->id); ?>" class="btn btn-info btn-xs">View</a>
                    <?php }
                    else {
                        echo '<strong style="color: red">Expired !</strong>';
                    } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>