<div class="page-content">
    <div class="page-header">
        <h1>
            <?php echo $pageTitle; ?>
            <small>
                <i class="icon-double-angle-right"></i>
                <?php echo $pageTitle; ?>
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <?php echo $this->Form->create('Case', array('action' => 'add', 'class' => 'form-horizontal', 'name' => 'add', 'id' => 'add')); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> Case Type </label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Case.type', array('options' => array('Case','Notice','PIL'), 'empty' => '--Select Role--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose Case type', "required" => "required")); ?>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> Description </label>

                <div class="col-sm-4">
                    <div class="input-group">
                        <?php echo $this->Form->input('Case.description', array('label' => false, 'type' => 'textarea', 'div' => false, 'placeholder' => 'Description', "class" => "form-control", "required" => "required")); ?>
                        <span class="input-group-addon">
					<i class="icon-calendar bigger-110"></i>
				</span>
                    </div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> Filing date </label>

                <div class="col-sm-4">
                    <div class="input-group">
                        <?php echo $this->Form->input('Case.filing_date', array('label' => false, 'type' => 'text', 'div' => false, 'placeholder' => 'DOB', 'id' => 'id-date-picker-1', 'data-date-format' => 'dd-mm-yyyy', "class" => "form-control datepicker", "required" => "required")); ?>
                        <span class="input-group-addon">
					<i class="icon-calendar bigger-110"></i>
				</span>
                    </div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> Applicable Acts </label>

                <div class="col-sm-4">
                    <div class="input-group">
                        <?php echo $this->Form->input('Case.applicable_acts', array('label' => false, 'type' => 'textarea', 'div' => false, 'placeholder' => 'Applicable Acts', "class" => "form-control", "required" => "required")); ?>
                        <span class="input-group-addon">
					<i class="icon-calendar bigger-110"></i>
				</span>
                    </div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Court</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Case.court', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Court', "required" => "required")); ?>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Reference Number</label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('Case.reference_number', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Reference Number', "required" => "required")); ?>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="space-4"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Judge</label>
                <div class="col-sm-9">
                    <?php echo $this->Form->input('Case.judge', array('label' => false, 'div' => false, 'error' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Judge')); ?>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="space-4"></div>

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


            <div class="hr hr-24"></div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-zip">Modules &
                    Permissions</label>
                <div class="col-sm-9" id="modulePermissions">
                    <div class="controls">
                        <label>
                            <span class="lbl">No Role Selected</span>
                        </label>
                    </div>
                </div>
            </div>

            <!--<div class="row">
                <div class="col-sm-12">
                    <div class="widget-box">
                        <div class="widget-header">
                            <h4>jQuery UI Sliders</h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="row">
                                    <div class="col-xs-3 col-md-2">
                                        <div id="slider-range"></div>
                                    </div>

                                    <div class="col-xs-9 col-md-10">
                                        <div id="eq">
                                            <span class="ui-slider-green">77</span>
                                            <span class="ui-slider-red">55</span>
                                            <span class="ui-slider-purple">33</span>
                                            <span class="ui-slider-orange">40</span>
                                            <span class="ui-slider-dark">88</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#UserStaffRoleId').change(function(){
            var selectedRoleId = $("#UserStaffRoleId").val();
            $.ajax({
                category: "GET",
                url: '<?php echo $this->Html->url(array('controller'=>'users', 'action' => 'getRolePermissions')) ?>/'+selectedRoleId,
                success: function(response){
                    $('#modulePermissions').html(response);
                }
            })
        })
    })
</script>