<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<?php echo form_open() ?>

<div class="col-sm-6">
    <h3>
        <strong style="color: #0cc745">Available Wallet Balance:
            <?php echo config_item('currency') . $this->db_model->select('balance', 'wallet', array('userid' => $this->session->user_id)) ?></strong>
    </h3>
    <p>
        <label>Enter Amount to withdraw:</label>
        <br/>
    <h4>You have to withdraw minium: <?php echo config_item('currency') . config_item('min_withdraw') ?></h4>
    <input type="text" name="amount" required class="form-control" value="1"><br/>
    <button class="btn btn-success" name="submit" value="add">Withdraw</button>
    </p>
</div>
<?php echo form_close() ?>

