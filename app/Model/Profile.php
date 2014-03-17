<?php
class Profile extends AppModel {
    var $name = 'Profile';
    
    var $validate = array(
        'dob' => array(
            'NotEmpty' => array(
                'rule' => array('notEmpty','date'),
                'message' => 'Please enter Date of Birth',
                'last' => true,
            )
        )
    );
}