<?php echo form_open() ?>
    <div class="row">
        <div class="form-group col-sm-6">
            <label for="name" class="control-label">Name*</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name') ?>"
                   placeholder="Mr Xyz">
        </div>
        <div class="form-group col-sm-6">
            <label for="sponsor" class="control-label">Sponsor ID*</label>
            <input type="text" onchange="get_user_name('#sponsor', '#spn_res')" class="form-control"
                   value="<?php echo set_value('sponsor', $this->uri->segment(4)) ?>"
                   id="sponsor"
                   name="sponsor" placeholder="1001">
            <span id="spn_res" style="color: red; font-weight: bold"></span>
        </div>
        <div class="form-group col-sm-6">
            <label for="email" class="control-label">Email</label>
            <input type="email" class="form-control" value="<?php echo set_value('email') ?>" id="email"
                   name="email"
                   placeholder="name@domain.com">
        </div>
        <div class="form-group col-sm-6">
            <label for="phone" class="control-label">Phone No*</label>
            <input type="text" class="form-control" value="<?php echo set_value('phone') ?>" id="phone" name="phone"
                   placeholder="9xxxxxxxxx">
        </div>
        <?php if (config_item('leg') !== "1" && config_item('show_placement_id') == "Yes" && config_item('autopool_registration') == "No") {
            ?>
            <div class="form-group col-sm-6">
                <label for="position" class="control-label">Placement ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
                            id="psn_res"
                            style="color: red; font-weight: bold"></span></label>
                <input type="text" class="form-control" onchange="get_user_name('#position', '#psn_res')"
                       id="position" value="<?php echo set_value('position') ?>"
                       name="position" id="position" placeholder="Where you want to place the ID">
            </div>
            <?php
        }
        if (config_item('leg') == "1") {
            echo form_hidden('leg', 'A');
        }
        else {
            if (config_item('show_leg_choose') == "Yes" && config_item('autopool_registration') == "No") {
                ?>
                <div class="form-group col-sm-6">
                    <label for="leg" class="control-label">Position*</label>
                    <select class="form-control" id="leg" name="leg">
                        <?php if (trim($this->uri->segment(3)) !== "") {
                            echo '<option selected>' . $this->uri->segment(3) . '</option>';
                        } ?>
                        <?php foreach ($leg as $key => $val) {
                            echo '<option value="' . $key . '">' . $val . ' </option>';
                        } ?>
                    </select>
                </div>
            <?php }
        }
        if (config_item('show_join_product') == "Yes") {
            ?>
            <div class="form-group col-sm-6">
                <label for="product" class="control-label">Sign Up Product*</label>
                <select class="form-control" id="product" name="product">
                    <?php foreach ($products as $val) {
                        echo '<option value="' . $val['id'] . '">' . $val['prod_name'] . '. Price :' . number_format($val['prod_price'] + ($val['prod_price'] * $val['gst'] / 100), 2) . ' </option>';
                    } ?>

                </select>
            </div>
            <?php
        }
        ?>
        <?php
        if (config_item('show_join_product') == "No" && config_item('free_registration') == "No") {
            ?>
            <div class="form-group col-sm-6" id="amt_to_pay">
                <label for="amt_to_pay" class="control-label">Registration Fee ?</label>
                <input type="text" required value="<?php echo set_value('amt_to_pay') ?>" class="form-control" id="amt_to_pay"
                       name="amt_to_pay">
            </div>
        <?php } ?>
        <div class="form-group col-sm-6">
            <label for="address_1" class="control-label">Address Line 1*</label>
            <input type="text" class="form-control" value="<?php echo set_value('address_1') ?>" id="address_1"
                   name="address_1">
        </div>
        <div class="form-group col-sm-6">
            <label for="address_2" class="control-label">Address Line 2</label>
            <input type="text" class="form-control" value="<?php echo set_value('address_2') ?>" id="address_2"
                   name="address_2">
        </div>
        <div class="form-group col-sm-6">
            <label for="password" class="control-label">Password*</label>
            <input type="password" class="form-control" value="<?php echo set_value('password') ?>" id="password"
                   name="password">
        </div>
        <div class="form-group col-sm-6">
            <label for="password_2" class="control-label">Retype Password</label>
            <input type="password" class="form-control" value="<?php echo set_value('password_2') ?>"
                   id="password_2"
                   name="password_2">
        </div>
        <div class="form-group col-sm-6">
            <label for="backdate" class="control-label">Join Date (For Backdate Entry)</label>
            <input type="text" readonly class="form-control datepicker" value="<?php echo set_value('backdate') ?>"
                   id="backdate"
                   name="backdate">
        </div>
        <div class="form-group col-sm-6">
            <label for="userid" class="control-label">User Id (Optional & Digit Only)</label>
            <input type="number" class="form-control" value="<?php echo set_value('userid') ?>"
                   id="userid"
                   name="userid">
        </div>
        <div class="form-group col-sm-6">
            <button class="btn btn-primary">Register</button>
        </div>
    </div>
<?php echo form_close(); ?>