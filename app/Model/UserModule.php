<?php
/**
 *
 */
class UserModule extends AppModel
{
    public $actsAs = array('Containable');

    /*var $belongsTo = array(
        'User' => array(
            'className'  => 'User',
            'foreignKey' => 'user_id',
            'conditions' => array(),
            'order'      => ''
        ),
        'Module' => array(
            'className'  => 'Module',
            'foreignKey' => 'module_id',
            'conditions' => array(),
            'order'      => ''
        )
    );

    var $hasMany = array(
        'UserModulePermission' => array(
            'className'  => 'UserModulePermission',
            'foreignKey' => 'user_module_id',
            'conditions' => array(),
            'fields' => array('UserModulePermission.user_module_id','UserModulePermission.module_permission_id'),
            'order'      => ''
        )
    );*/

    public function getDetails($type=null,$conditions=null,$fields=null,$order='',$limit='',$groupBy=''){
        return $this->find($type, array(
                'conditions' => $conditions,
                'fields' => $fields,
                'order' => $order,
                'limit' => $limit,
                'group' => $groupBy
            )
        );
    }

    public function getUserPermissionsForModules($userId){
        /*$this->bindModel(array
        (
            'hasMany' => array
            (
                'UserModulePermission' => array
                (
                    'className'  => 'UserModulePermission',
                    'foreignKey' => "user_module_id",
                    'conditions' => array(),
                    'fields' => array('UserModulePermission.user_module_id','UserModulePermission.module_permission_id')
                )
            )
        ), false);

        return $this->find('all',array(
                'conditions' => array('UserModule.user_id'=>$userId)
            )
        );
        */

        return $this->find('all',array(
            'conditions' => array('UserModule.user_id'=>$userId),
            'joins' => array(
                array('table' => 'user_module_permissions',
                    'alias' => 'UserModulePermission',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions'=> array('UserModulePermission.user_module_id = UserModule.id')),
            ),
            'fields' => array()
            )
        );
    }

    public function saveUserData($userData){
        if(isset($userData['UserModule']['module_id']) && !empty($userData['UserModule']['module_id'])){
            foreach($userData['UserModule']['module_id'] as $userModule){
                $userModuleData = array();
                $userModuleData['id'] = null;
                $userModuleData['user_id'] = $userData['UserModule']['user_id'];
                $userModuleData['module_id'] = $userModule;
                if($this->save($userModuleData)){
                    $lastInsertedId = $this->getLastInsertId();
                    if(isset($userData['UserModulePermission']['module_permission_id'][$userModule]) && !empty($userData['UserModulePermission']['module_permission_id'][$userModule])){
                        App::import('model', 'UserModulePermission');
                        $userModulePermissionModel = new UserModulePermission();
                        $permissionsData = array();
                        $permissionsData['user_module_id'] = $lastInsertedId;
                        $permissionsData['permission_ids'] = $userData['UserModulePermission']['module_permission_id'][$userModule];
                        $userModulePermissionModel->saveUserData($permissionsData);
                    }
                }else{
                    //TODO throw new Exception("Unable to save User Module");
                }
            }
        }
    }
}