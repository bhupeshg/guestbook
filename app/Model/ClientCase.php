<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class ClientCase extends AppModel
{
	public $actsAs = array('Containable');
	var $belongsTo = array(
		'Client' => array(
			'className'  => 'User',
			'foreignKey' => 'client_id',
			'conditions' => array(),
			'order'      => ''
		)
	);

	public function editCaseRequiredModelJoins()
	{
		$this->unbindModel(array('belongsTo' => array('Client')));

		$this->bindModel(array
		(
			'hasMany' => array
			(
				'CasePayment' => array
				(
					'className'  => 'CasePayment',
					'foreignKey' => "case_id",
					'conditions' => array(),
					'fields' => array()
				)
			)
		), false);
	}
}