<?php

App::uses('AppModel', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class StaffRole extends AppModel {
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
}