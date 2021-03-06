<div class="page-content">
    <div class="page-header">
        <h1>
            <?php echo $pageTitle; ?>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <?php echo $this->Form->create('User', array('url' => '/lawyers/addClient', 'class' => 'form-horizontal', 'name' => 'addClient', 'id' => 'addClient')); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"> Name </label>

                <div class="col-sm-4">
                    <?php echo $this->Form->input('User.first_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'placeholder' => 'First Name', "required" => "required", "class" => "col-sm-6")); ?>
                    <?php echo $this->Form->input('User.last_name', array('label' => false, 'div' => false, 'id' => 'form-field-1', 'placeholder' => 'Last Name', "required" => "required", "class" => "col-sm-6")); ?>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> DOB </label>

                <div class="col-sm-4">
                    <div class="input-group">
                        <?php echo $this->Form->input('Profile.dob', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'DOB', 'id' => 'id-date-picker-1', 'data-date-format' => 'yyyy-mm-dd', "class" => "form-control date-picker", "required" => "required")); ?>
						<span class="input-group-addon">
							<i class="icon-calendar bigger-110"></i>
						</span>
                    </div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-input-mobile"> Phone Number </label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.mobile', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Phone Number')); ?>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Email', "required" => "required")); ?>
                    <div class="clear"></div>
                    <?php echo $this->Form->error('User.email'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-password">Password</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('User.user_pwd', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'type' => 'password', 'placeholder' => 'Password', "required" => "required")); ?>
                    <div class="clear"></div>
                    <?php echo $this->Form->error('User.user_pwd'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-confirm-password">Confirm
                    Password</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('User.confirm_password', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'type' => 'password', 'placeholder' => 'Confirm Password', "required" => "required")); ?>
                    <div class="clear"></div>
                    <?php echo $this->Form->error('User.confirm_password'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-address1">Address 1</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.street_address_1', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Address 1')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-address2">Address 2</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.street_address_2', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Address 2')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-country">Country</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.country', array('options' => array('1' => 'India'), 'empty' => '--Select Country--', 'label' => false, 'div' => false, 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Country', 'class' => 'col-xs-10 col-sm-5')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-state">State</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.state', array('options' => array('1' => 'Punjab'), 'empty' => '--Select State--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a State')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-city">City</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.city', array('options' => array('1' => 'Chandigarh'), 'empty' => '--Select City--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a City')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Zip</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Profile.zip', array('label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Zip')); ?>
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <?php echo $this->Form->button("<i class='icon-ok bigger-110'></i>Submit", array("class" => "btn btn-info", "escape" => false, "type" => "submit"));?>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
            <div class="hr hr-18 dotted hr-double"></div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.page-content -->