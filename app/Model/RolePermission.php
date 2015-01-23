<?php
/**
 *
 */
class RolePermission extends AppModel
{
    public $actsAs = array('Containable');

    var $belongsTo = array(
        'Module' => array(
            'className'  => 'Module',
            'foreignKey' => 'module_id',
            'fields' => array('Module.id','Module.name')
        )
    );

    public function getModulesByRole($roleId){
        App::import('model', 'Module');
        $moduleModel = new Module();
        $moduleModel->bindModel(array
        (
            'hasMany' => array
            (
                'ModulePermission' => array
                (
                    'className'  => 'ModulePermission',
                    'foreignKey' => "module_id",
                    'conditions' => array(),
                    'fields' => array('ModulePermission.id', 'ModulePermission.name')
                )
            )
        ), false);
        $this->recursive = 2;
        return $this->find('all',array(
            'conditions' => array('RolePermission.role'=>$roleId),
            'fields' => array('RolePermission.module_id')
        ));
    }
}