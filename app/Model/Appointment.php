<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class Appointment extends AppModel
{
    public $actsAs = array('Containable');

    var $belongsTo = array(
        'Client' => array(
            'className'  => 'User',
            'foreignKey' => 'client_id',
            'conditions' => array(),
            'order'      => ''
        ),
	    'Lawyer' => array(
		    'className'  => 'User',
		    'foreignKey' => 'lawyer_id',
		    'conditions' => array(),
		    'order'      => ''
	    )
    );

	public $validate = array(
		'datetime' => array(
			'NotEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please select date and time',
				'last' => true,
			)
		)
	);

	public function dateTimeSqlFormat($date)
	{
		if(!empty($date))
		{
			$dateArr = explode(' ', $date);

		}

		return $date;
	}
}