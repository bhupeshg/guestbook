<?php
App::uses('AppModel', 'Model');

class Coupon extends AppModel {
    public $virtualFields = array(
        'id_value_type' => 'CONCAT(Coupon.id, "_", Coupon.value, "_", Coupon.type)'
    );

    public function getCouponDetails($type=null,$conditions=null,$fields=null,$order='',$limit='',$groupBy=''){
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