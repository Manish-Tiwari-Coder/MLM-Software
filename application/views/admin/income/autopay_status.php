<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="panel panel-<?php echo $status ?>">
    <div class="panel-heading">Status</div>
    <div class="panel-body">
        <?php if ($status == "success") { ?>
            <p> Your company fund has withdrawn and credited to user accounts successfully. There is nothing left to do
                from your end. Happy Business !

            </p>
        <?php } else { ?>
            <p>Oops ! We found some error while processing your transactions. Please check if your
                <strong><?php echo config_item('payment_api') ?></strong> accounts has enough fund to cover your
                transactions or not. Also check payment gateway setting if everything is properly set or not.</p>
        <?php } ?>
        <?php if (isset($this->session->skip_autopay)) { ?>
            <div class="alert alert-danger">Some User do not have their <?php echo $this->session->skip_autopay ?>
                updated in their account. Their payment has not made.
            </div>
        <?php }
        unset($_SESSION['skip_autopay']); ?>
    </div>
</div>