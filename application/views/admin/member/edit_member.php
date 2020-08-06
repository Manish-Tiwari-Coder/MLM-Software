<?php echo form_open() ?>
<h2 align="center">Update Profile</h2>
<div class="row">
    <div class="form-group col-sm-6">
        <label for="name" class="control-label">Name*</label>
        <input type="text" class="form-control" id="name" name="name"
               value="<?php echo set_value('name', $data->name) ?>"
               placeholder="Mr Xyz">
    </div>
    <div class="form-group col-sm-6">
        <label for="email" class="control-label">Email</label>
        <input type="email" class="form-control" value="<?php echo set_value('email', $data->email) ?>" id="email"
               name="email"
               placeholder="name@domain.com">
    </div>
    <div class="form-group col-sm-6">
        <label for="phone" class="control-label">Phone No*</label>
        <input type="text" class="form-control" value="<?php echo set_value('phone', $data->phone) ?>" id="phone"
               name="phone"
               placeholder="9xxxxxxxxx">
    </div>
    <div class="form-group col-sm-6">
        <label for="address" class="control-label">Address*</label>
        <input type="text" class="form-control" value="<?php echo set_value('address', $data->address) ?>"
               id="address"
               name="address">
    </div>
    <div class="form-group col-sm-6">
        <label for="join_time" class="control-label">Date of Join</label>
        <input type="text" readonly class="form-control datepicker"
               value="<?php echo set_value('join_time', $data->join_time) ?>"
               id="join_time" name="join_time">
    </div>
    <div class="form-group col-sm-6">
        <label for="password" class="control-label">New Password</label>
        <input type="password" class="form-control" value="<?php echo set_value('password') ?>" id="password"
               name="password">
    </div>
    <div class="form-group col-sm-6">
        <label for="status" class="control-label">Status</label>
        <select class="form-control" id="status"
                name="status">
            <option><?php echo $data->status ?></option>
            <option>Active</option>
            <option>Block</option>
            <option>Suspend</option>
        </select>
    </div>
</div>
<h3>Profile Detail
    <hr/>
</h3>
<div class="row">
    <div class="form-group col-sm-6">
        <label for="birthdate" class="control-label">Date of Birth</label>
        <input type="text" readonly class="form-control datepicker"
               value="<?php echo set_value('birthdate', $profile->date_of_birth) ?>"
               id="birthdate" name="birthdate">
    </div>
    <div class="form-group col-sm-6">
        <label for="gstin" class="control-label">GST No.</label>
        <input type="text" class="form-control" value="<?php echo set_value('gstin', $profile->gstin) ?>"
               id="gstin" name="gstin">
    </div>
    <div class="form-group col-sm-6">
        <label for="tax_no" class="control-label">PAN / Tax Reg No.</label>
        <input type="text" class="form-control" value="<?php echo set_value('tax_no', $profile->tax_no) ?>"
               id="tax_no" name="tax_no">
    </div>
    <div class="form-group col-sm-6">
        <label for="aadhar_no" class="control-label">Aadhar No.</label>
        <input type="text" class="form-control" value="<?php echo set_value('aadhar_no', $profile->aadhar_no) ?>"
               id="aadhar_no" name="aadhar_no">
    </div>
    <div class="form-group col-sm-6">
        <label for="bank_name" class="control-label">Bank Name.</label>
        <input type="text" class="form-control" value="<?php echo set_value('bank_name', $profile->bank_name) ?>"
               id="bank_name" name="bank_name">
    </div>
    <div class="form-group col-sm-6">
        <label for="bank_ac_no" class="control-label">Bank A/C No.</label>
        <input type="text" class="form-control" value="<?php echo set_value('bank_ac_no', $profile->bank_ac_no) ?>"
               id="bank_ac_no" name="bank_ac_no">
    </div>
    <div class="form-group col-sm-6">
        <label for="bank_ifsc" class="control-label">Bank IFSC.</label>
        <input type="text" class="form-control" value="<?php echo set_value('bank_ifsc', $profile->bank_ifsc) ?>"
               id="bank_ac_no" name="bank_ifsc">
    </div>
    <div class="form-group col-sm-6">
        <label for="bank_branch" class="control-label">Bank Branch Name.</label>
        <input type="text" class="form-control" value="<?php echo set_value('bank_branch', $profile->bank_branch) ?>"
               id="bank_branch" name="bank_branch">
    </div>
    <div class="form-group col-sm-6">
        <label for="btc_address" class="control-label">BTC Address.</label>
        <input type="text" class="form-control" value="<?php echo set_value('btc_address', $profile->btc_address) ?>"
               id="btc_address" name="btc_address">
    </div>
    <div class="form-group col-sm-6">
        <label for="nominee_name" class="control-label">Nominee Name.</label>
        <input type="text" class="form-control" value="<?php echo set_value('nominee_name', $profile->btc_address) ?>"
               id="nominee_name" name="nominee_name">
    </div>
    <div class="form-group col-sm-6">
        <label for="nominee_add" class="control-label">Nominee Address.</label>
        <input type="text" class="form-control" value="<?php echo set_value('nominee_add', $profile->nominee_add) ?>"
               id="nominee_add" name="nominee_add">
    </div>
    <div class="form-group col-sm-6">
        <label for="nominee_relation" class="control-label">Nominee Relationship.</label>
        <input type="text" class="form-control"
               value="<?php echo set_value('nominee_relation', $profile->nominee_relation) ?>"
               id="nominee_relation" name="nominee_relation">
    </div>
    <input type="hidden" name="id" value="<?php echo $data->id ?>">
    <div class="form-group col-sm-6">
        <button class="btn btn-primary">Update</button>
    </div>
</div>
<?php echo form_close() ?>
