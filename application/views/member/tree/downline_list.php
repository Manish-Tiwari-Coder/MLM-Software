<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="row table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>S.N.</td>
            <td>Name</td>
            <td>Join Date</td>
            <td>Total Downline</td>
            <td>Sponsor ID</td>
        </tr>
        </thead>
        <tbody>
        <?php $this->plan_model->ref_list($this->session->user_id) ?>
        </tbody>
    </table>
</div>
