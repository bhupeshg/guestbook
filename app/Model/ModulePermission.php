<?php
/**
 *
 */
class ModulePermission extends AppModel
{
    public $actsAs = array('Containable');

    var $belongsTo = array(
        'Module' => array(
            'className'  => 'Module',
            'foreignKey' => 'module_id',
            'conditions' => array(),
            'order'      => ''
        )
    );
}