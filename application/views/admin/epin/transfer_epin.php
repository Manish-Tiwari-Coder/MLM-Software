<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?><?php echo form_open() ?>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-6">
                <label>From User ID *</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input placeholder="From where to deduct epin" value="<?php echo set_value('from') ?>"
                       class="form-control" name="from">
                </div>
            </div>
            <div class="col-sm-6">
                <label>To User ID *</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input placeholder="Where to transfer epins" value="<?php echo set_value('to') ?>" class="form-control"
                       name="to">
                </div>
            </div>
            <div class="col-sm-6">
                <label>Amount *</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                    <input placeholder="Amount of e-pins" value="<?php echo set_value('amount') ?>" class="form-control"
                       name="amount">
                </div>
                
            </div>
            <div class="col-sm-6">
                <label>Number of Pins *</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-pushpin"></span></span>
                    <input placeholder="How many epin to transfer" value="<?php echo set_value('qty') ?>"
                       class="form-control" name="qty">
                </div>
            </div>
            <div class="col-sm-6">
                <br/>
                <input type="submit" class="btn btn-primary" value="Transfer" onclick="this.value='Transferring..'">
            </div>
        </div>
    </div><p>&nbsp;</p>
<?php echo form_close() ?>