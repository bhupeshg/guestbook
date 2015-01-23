<div class="page-content">
    <div class="page-header">
        <h1>
            Manage Staff
            <small>
                <i class="icon-double-angle-right"></i>
                <?php echo $pageTitle.' #'.$userId; ?>
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <?php echo $this->Form->create('User', array('url' => '/users/editStaffRoles/'.$userId, 'class' => 'form-horizontal','name'=>'editStaffRoles', 'id'=>'editStaffRoles')); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-dob"> Role </label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('User.staff_role_id', array('options' => $listRoles, 'empty' => '--Select Role--', 'label' => false, 'div' => false, 'class' => 'col-xs-10 col-sm-5', 'autocomplete' => 'off', 'data-placeholder' => 'Choose a Role', "required" => "required")); ?>
                </div>
            </div>

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