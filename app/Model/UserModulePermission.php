<?php
/**
 *
 */
class UserModulePermission extends AppModel
{
    public $actsAs = array('Containable');

    var $belongsTo = array(
        'UserModule' => array(
            'className'  => 'UserModule',
            'foreignKey' => 'user_module_id',
            'conditions' => array(),
            'order'      => ''
        ),
        'ModulePermission' => array(
            'className'  => 'ModulePermission',
            'foreignKey' => 'module_permission_id',
            'conditions' => array(),
            'fields' => array('ModulePermission.name','ModulePermission.url'),
            'order'      => ''
        )
    );

    public function saveUserData($permissionsData){
        if(isset($permissionsData['permission_ids']) && !empty($permissionsData['permission_ids'])){
            foreach($permissionsData['permission_ids'] as $permission){
                $saveData = array();
                $saveData['id'] = null;
                $saveData['user_module_id'] = $permissionsData['user_module_id'];
                $saveData['module_permission_id'] = $permission;
                $this->save($saveData);
            }
        }
    }
}