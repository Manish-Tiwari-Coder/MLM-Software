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
    <table class="table table-striped table-bordered" style="font-size:13px">
        <tr>
            <th>SN</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Sponsor ID</th>
            <th>Phone</th>
            <?php if (config_item('enable_investment') == "Yes") {
                echo '<th>My Investment</th>';
            }
            ?>
            <th>Join Date</th>
            <th>Total Downline</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($members as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><a href="<?php echo site_url('users/user_detail/' . $e['id']) ?>"
                       target="_blank"><?php echo config_item('ID_EXT') . $e['id']; ?></a></td>
                <td><?php echo $e['name']; ?></td>
                <td><a href="<?php echo site_url('users/user_detail/' . $e['sponsor']) ?>"
                       target="_blank"><?php echo $e['sponsor'] ? config_item('ID_EXT') . $e['sponsor'] : ''; ?></td>
                <td><?php echo $e['phone']; ?></td>
                <?php if (config_item('enable_investment') == "Yes") {
                    echo '<td>$ ' . $e['topup'] . '</td>';
                }
                ?>
                <td><?php echo $e['join_time']; ?></td>
                <td><?php echo($e['total_a'] + $e['total_b'] + $e['total_c'] + $e['total_d'] + $e['total_e']); ?></td>
                <td>
                    <a onclick="return confirm('Are you sure you want to delete this Member ?')"
                       href="<?php echo site_url('users/remove_member/' . $e['id']); ?>" class="btn btn-danger btn-xs">Delete</a>

                    <a href="<?php echo site_url('users/login_member/' . $e['id']); ?>" target="_blank"
                       class="btn btn-danger btn-xs">Login</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>

<a href="<?php echo site_url('admin') ?>" class="btn btn-xs btn-danger">&larr; Go Back</a>