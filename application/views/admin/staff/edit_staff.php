<?php echo form_open('staff/edit/' . $staff['id'], array("class" => "form-horizontal")); ?>
<div class="form-group">
    <label for="password" class="col-md-4 control-label">Designation</label>
    <div class="col-md-8">
        <select name="designation" class="form-control">
            <?php foreach ($data as $e) { ?>
                <option value="<?php echo $e->id ?>"><?php echo $e->des_title ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-md-4 control-label">Password</label>
    <div class="col-md-8">
        <input type="text" name="password"
               value="<?php echo($this->input->post('password') ? $this->input->post('password') : $staff['password']); ?>"
               class="form-control" id="password"/>
    </div>
</div>

<div class="form-group">
    <label for="name" class="col-md-4 control-label"><span class="text-danger">*</span>Name</label>
    <div class="col-md-8">
        <input type="text" name="name"
               value="<?php echo($this->input->post('name') ? $this->input->post('name') : $staff['name']); ?>"
               class="form-control" id="name"/>
        <span class="text-danger"><?php echo form_error('name'); ?></span>
    </div>
</div>
<div class="form-group">
    <label for="email" class="col-md-4 control-label">Email</label>
    <div class="col-md-8">
        <input type="text" name="email"
               value="<?php echo($this->input->post('email') ? $this->input->post('email') : $staff['email']); ?>"
               class="form-control" id="email"/>
        <span class="text-danger"><?php echo form_error('email'); ?></span>
    </div>
</div>
<div class="form-group">
    <label for="phone" class="col-md-4 control-label"><span class="text-danger">*</span>Phone</label>
    <div class="col-md-8">
        <input type="text" name="phone"
               value="<?php echo($this->input->post('phone') ? $this->input->post('phone') : $staff['phone']); ?>"
               class="form-control" id="phone"/>
        <span class="text-danger"><?php echo form_error('phone'); ?></span>
    </div>
</div>
<div class="form-group">
    <label for="pan" class="col-md-4 control-label">Pan</label>
    <div class="col-md-8">
        <input type="text" name="pan"
               value="<?php echo($this->input->post('pan') ? $this->input->post('pan') : $staff['pan']); ?>"
               class="form-control" id="pan"/>
    </div>
</div>
<div class="form-group">
    <label for="aadhar" class="col-md-4 control-label">Aadhar</label>
    <div class="col-md-8">
        <input type="text" name="aadhar"
               value="<?php echo($this->input->post('aadhar') ? $this->input->post('aadhar') : $staff['aadhar']); ?>"
               class="form-control" id="aadhar"/>
    </div>
</div>
<div class="form-group">
    <label for="address" class="col-md-4 control-label"><span class="text-danger">*</span>Address</label>
    <div class="col-md-8">
        <textarea name="address" class="form-control"
                  id="address"><?php echo($this->input->post('address') ? $this->input->post('address') : $staff['address']); ?></textarea>
        <span class="text-danger"><?php echo form_error('address'); ?></span>
    </div>
</div>
<div class="form-group">
    <label for="bank_detail" class="col-md-4 control-label">Bank Detail</label>
    <div class="col-md-8">
        <textarea name="bank_detail" class="form-control"
                  id="bank_detail"><?php echo($this->input->post('bank_detail') ? $this->input->post('bank_detail') : $staff['bank_detail']); ?></textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</div>

<?php echo form_close(); ?>
