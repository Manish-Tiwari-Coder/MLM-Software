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
            <th>Survey Title</th>
            <th>Expiry Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $sn = 1;
        foreach ($survey as $e) { ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $e->survey_name; ?></td>
                <td><?php echo $e->expiry_date; ?></td>
                <td><?php if ($this->db_model->count_all('survey_user', array(
                            'survey_id' => $e->id,
                            'userid'    => $this->session->user_id,
                        )) > 0) {
                        echo '<strong style="color: darkgreen">Submitted</strong>';
                        echo '&nbsp;&nbsp;&nbsp;<a target="_blank" class="btn btn-xs btn-success" href="' . site_url('survey/view/' . $e->id) . '">View</a>';
                    }
                    else {
                        if ($e->expiry_date >= date('Y-m-d')) { ?>
                            <a target="_blank" href="<?php echo site_url('survey/survey_view/' . $e->id); ?>" class="btn btn-info btn-xs">Submit</a>
                        <?php }
                        else {
                            echo '<strong style="color: red">Expired !</strong>';
                        }
                    } ?></td>
                <td>

                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="pull-right">
    <?php echo $this->pagination->create_links(); ?>
</div>