<?php
App::uses('AppModel', 'Model');

/**
 *
 */
class CaseHearing extends AppModel
{
	public $actsAs = array('Containable');

	var $belongsTo = array(
		'ClientCase' => array(
			'className'  => 'ClientCase',
			'foreignKey' => 'case_id',
			'conditions' => array(),
			'order'      => ''
		)
	);

	public function getNextHearing($caseId, $date)
	{
		return $this->find('first', array(
				'conditions' => array('CaseHearing.case_id'=> $caseId, 'CaseHearing.date >'=> $date),
				'fields' => array('id','date'),
				'order' => 'CaseHearing.date ASC'
			)
		);
	}

	public function getPreviousHearing($caseId, $date)
	{
		return $this->find('first', array(
				'conditions' => array('CaseHearing.case_id'=> $caseId, 'CaseHearing.date <'=> $date),
				'fields' => array('id','date'),
				'order' => 'CaseHearing.date ASC'
			)
		);
	}
}