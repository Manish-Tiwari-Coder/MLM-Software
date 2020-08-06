<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$top_id = $this->session->user_id;
$this->db->select('id, name, phone, join_time, topup, total_a, rank, total_b, total_c, total_d, total_e')->from('member')
         ->where(array('sponsor' => htmlentities($top_id)));
$data = $this->db->get()->result();
?>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>S.N.</td>
            <td>Name</td>
            <?php if (config_item('enable_investment') == "Yes") { ?>
                <td>My Investment</td>
            <?php } ?>
            <td>Join Date</td>
            <td>Total Downline</td>
            <td>Rank</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $e) { ?>
            <tr>
                <td><?php echo $sn = 1; ?></td>
                <td><?php echo $e->name ?></td>
                <?php if (config_item('enable_investment') == "Yes") {
                    echo "<td>" . config_item('currency') . $e->topup . "</td>";
                } ?>
                <td><?php echo $e->join_time ?></td>
                <td><?php echo($e->total_a + $e->total_b + $e->total_c + $e->total_d + $e->total_e) ?></td>
                <td><?php echo $e->rank ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
