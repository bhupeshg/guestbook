<?php
class Document extends AppModel {
    var $name = 'Document';

	public function listDocuments($fieldName, $entityId){
		return $this->find('all', array(
				'conditions' => array(
					$fieldName => $entityId
				),
				'fields' => array('id','original_name', 'name', 'created'),
				'order' => 'original_name'
			)
		);
	}
}