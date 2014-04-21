<?php
class UserTransaction extends AppModel {
    var $name = 'UserTransaction';
    var $validate = array(
        'any_discount' => array(
            'ruleName' => array(
                'rule' => 'notEmpty',
                'message' => 'Please select if any discount given or not',
                'last' => true
            ),
            'ruleName2' => array(
                'rule' => array('checkDiscountValues'),
                'message' => 'Please enter complete discount details'
            )
        )
    );

    public function checkDiscountValues() {
        //pr($this->data['UserTransaction']['any_discount']); die;
        if(isset($this->data['UserTransaction']['any_discount']) && $this->data['UserTransaction']['any_discount']=='y'){
            if(isset($this->data['UserTransaction']['coupon_id']) && !empty($this->data['UserTransaction']['coupon_id'])){
                return true;
            }
            return false;
        }
        return true;
    }
}