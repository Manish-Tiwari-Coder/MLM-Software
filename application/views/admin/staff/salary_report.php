<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>S.N.</th>
            <th>Staff Name</th>
            <th>Salary</th>
            <th>Salary Month</th>
            <th>Pay Date</th>
            <th>Actions</th>
        </tr>
        <?php $sn = 1;
        foreach ($salary as $s) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $this->db_model->select('name', 'staffs', array('id' => $s->staff_id)); ?></td>
                <td><?php echo config_item('currency') . $s->salary; ?></td>
                <td><?php echo $s->month; ?>/<?php echo $s->year; ?></td>
                <td><?php echo $s->paydate; ?></td>
                <td>
                    <a href="<?php echo site_url('staff/edit_salary/' . $s->id); ?>"
                       class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure want to delete this staff ?')"
                       href="<?php echo site_url('staff/remove_salary/' . $s->id); ?>" class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo $this->pagination->create_links() ?>
</div>
