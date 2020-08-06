<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Pan</th>
            <th>Aadhar</th>
            <th>Address</th>
            <th>Bank Detail</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($data as $s) { ?>
            <tr>
                <td><?php echo $s['id']; ?></td>
                <td><?php echo $s['username']; ?></td>
                <td><?php echo $s['name']; ?></td>
                <td><?php echo $s['email']; ?></td>
                <td><?php echo $s['phone']; ?></td>
                <td><?php echo $s['pan']; ?></td>
                <td><?php echo $s['aadhar']; ?></td>
                <td><?php echo $s['address']; ?></td>
                <td><?php echo $s['bank_detail']; ?></td>
                <td>
                    <a href="<?php echo site_url('staff/edit/' . $s['id']); ?>" class="btn btn-info btn-xs">Edit</a>
                    <a onclick="return confirm('Are you sure want to delete this staff ?')"
                       href="<?php echo site_url('staff/remove/' . $s['id']); ?>"
                       class="btn btn-danger btn-xs">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>
