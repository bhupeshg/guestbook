<?php
if(isset($modulesWithPermissions) && !empty($modulesWithPermissions)){ ?>
    <div class="controls">
        <label>
            <input type="checkbox" class="ace" name="form-field-checkbox">
            <span class="lbl">All</span>
        </label>
    </div>
    <?php foreach($modulesWithPermissions as $modulesInfo){ ?>
        <div class="controls">
            <label>
                <input type="checkbox" name="data[UserModule][module_id][]" value="<?php echo $modulesInfo['Module']['id']; ?>" class="ace" name="form-field-checkbox">
                <span class="lbl"> <?php echo $modulesInfo['Module']['name']; ?></span>
            </label>
            <?php if(isset($modulesInfo['Module']['ModulePermission']) && !empty($modulesInfo['Module']['ModulePermission'])){
                foreach($modulesInfo['Module']['ModulePermission'] as $modulesPermissionInfo){ ?>
            <div class="controls">
                <label class="modulePermissions">
                    <input type="checkbox" name="data[UserModulePermission][module_permission_id][<?php echo $modulesPermissionInfo['module_id']; ?>][]" value="<?php echo $modulesPermissionInfo['id']; ?>" class="ace" name="form-field-checkbox">
                    <span class="lbl"> <?php echo $modulesPermissionInfo['name']; ?></span>
                </label><br/>
            </div>
            <?php }
            } ?>
        </div>
    <?php }
}else{ ?>
    <div class="controls">
        <label>
            <span class="lbl">No module for this role</span>
        </label>
    </div>
<?php } ?>