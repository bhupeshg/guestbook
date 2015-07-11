<?php

class CasesController extends AppController
{
    public $helpers = array("Form", "Js" => array('Jquery'), 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Email');

	public function manage()
    {
	    if ($this->RequestHandler->isAjax()) {
		    $this->layout = 'ajax';
	    }else{
		    $this->layout = 'basic';
	    }

	    $this->loadModel('ClientCase');

	    $this->pageTitle = 'Manage Cases';
	    $this->set("pageTitle", $this->pageTitle);

	    $fields = array();

	    if (isset($this->data['ClientCase']['stage']) && !empty($this->data['ClientCase']['stage'])) {
		    $this->bulkAction($this->data['ClientCase']['stage']);
	    }

	    $paginateLimit = LIMIT;
	    if (isset($this->request->data) && !empty($this->request->data)) {
		    foreach ($this->request->data['ClientCase'] as $key => $value) {
			    if (!empty($value)) {
				    $this->request->params['named'][$key] = base64_encode($value);
			    }
		    }
	    }

	    if (isset($this->request->params['named']) && !empty($this->request->params['named'])) {
		    foreach ($this->request->params['named'] as $key => $value) {
			    if (!empty($value)) {
				    $this->request->data['ClientCase'][$key] = base64_decode($value);
				    if ($key == 'paging_limit') {
					    $paginateLimit = base64_decode($value);
				    }
			    }
		    }
	    }

	    $criteria = "";
	    $criteria .= "1=1";
	    if (isset($this->data) || !empty($this->params['named'])) {
		    if (isset($this->data['ClientCase']['client_name']) && ($this->data['ClientCase']['client_name'] != '')) {
			    $criteria .= " AND (ClientCase.client_first_name LIKE '%" . $this->data['ClientCase']['client_name'] . "%' OR ClientCase.client_last_name LIKE '%" . $this->data['ClientCase']['client_name'] . "%')";
		    } elseif (isset($this->params['named']['client_name']) && $this->params['named']['client_name'] != '') {
			    if (!isset($this->data['ClientCase']['client_name'])) {
				    $criteria .= " AND (ClientCase.first_name LIKE '%" . $this->params['named']['client_name'] . "%' OR ClientCase.last_name LIKE '%" . $this->params['named']['client_name'] . "%')";
			    }
		    }

		    if (isset($this->data['ClientCase']['client_email']) && ($this->data['ClientCase']['client_email'] != '')) {
			    $criteria .= " AND (ClientCase.client_email LIKE '%" . $this->data['ClientCase']['client_email'] . "%')";
		    } elseif (isset($this->params['named']['client_email']) && $this->params['named']['client_email'] != '') {
			    if (!isset($this->data['ClientCase']['client_email'])) {
				    $criteria .= " AND (ClientCase.client_email LIKE '%" . $this->params['named']['client_email'] . "%')";
			    }
		    }

		    if (isset($this->data['ClientCase']['opponent_name']) && ($this->data['ClientCase']['opponent_name'] != '')) {
			    $criteria .= " AND (ClientCase.opponent_first_name LIKE '%" . $this->data['ClientCase']['opponent_name'] . "%' OR ClientCase.opponent_last_name LIKE '%" . $this->data['ClientCase']['opponent_name'] . "%')";
		    } elseif (isset($this->params['named']['opponent_name']) && $this->params['named']['opponent_name'] != '') {
			    if (!isset($this->data['ClientCase']['opponent_name'])) {
				    $criteria .= " AND (ClientCase.first_name LIKE '%" . $this->params['named']['opponent_name'] . "%' OR ClientCase.last_name LIKE '%" . $this->params['named']['opponent_name'] . "%')";
			    }
		    }
	    }

	    $this->Paginator->settings = array(
		    'conditions' => array('ClientCase.is_deleted' => 0),
		    'page' => 1,
		    'limit' => $paginateLimit,
		    'fields' => $fields,
		    'order' => array('ClientCase.id' => 'desc'),
		    //'contain' => array('Customer' => array('Country', 'State', 'City'))
	    );
	    $records = $this->Paginator->paginate('ClientCase', $criteria);
	    //echo '<pre>'; print_r($records); die;
	    $this->set('records', $records);
	    $this->set('paginateLimit', $paginateLimit);
    }

    public function add($caseId=null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Case';
	    if(!empty($caseId)) {
		    $this->pageTitle = 'Edit Case';
	    }

        $this->set("pageTitle", $this->pageTitle);

	    $this->loadModel('ClientCase');
	    //$this->loadModel('CaseHearing');
	    $this->loadModel('CasePayment');

	    if($this->request->data){
		    //pr($this->request->data); die;
		    if ($this->ClientCase->validates()) {
			    //$hearingDate = $this->dateTimeSqlFormat($this->request->data['CaseHearing']['date']);
			    $this->request->data['ClientCase']['next_hearing_date'] = '';
			    if ($this->ClientCase->save($this->request->data)) {
				    if(empty($caseId)) {
					    $caseId = $this->ClientCase->getLastInsertId();
				    }

				    /*$this->request->data['CaseHearing']['case_id'] = $caseId;
				    $this->request->data['CaseHearing']['client_id'] = $this->request->data['ClientCase']['client_id'];
				    $this->request->data['CaseHearing']['date'] = $hearingDate;
				    $this->request->data['CaseHearing']['created_by'] = $this->Session->read("UserInfo.uid");

				    try{
					    $this->CaseHearing->save($this->request->data);
				    } catch (Exception $e) {
					    //TODO throw $e;
				    }*/

				    if(!empty($this->request->data['CasePayment']['amount']))
				    {
					    $paymentData = $this->request->data['CasePayment'];
					    foreach($paymentData['amount'] as $paymentKey=>$payment)
					    {
						    if(!empty($payment))
						    {
							    App::import('Model', 'CasePayment');
							    $casePayment = new CasePayment();
							    $save_data = array();
							    $save_data['CasePayment']['case_id'] = $caseId;
							    $save_data['CasePayment']['type'] = $paymentData['type'][$paymentKey];
							    $save_data['CasePayment']['amount'] = $payment;
							    $save_data['CasePayment']['notes'] = $paymentData['notes'][$paymentKey];
							    $save_data['CasePayment']['date'] = $paymentData['date'][$paymentKey];
							    $save_data['CasePayment']['created_by'] = $this->Session->read("UserInfo.uid");

							    $casePayment->save($save_data);
						    }
					    }
				    }
				    $this->Session->setFlash(CASE_INFORMATION_ADDED);
				    $this->redirect(array('controller' => 'cases', 'action' => 'manage'));
			    }
		    }
	    }
	    if(!empty($caseId)) {
		    $this->ClientCase->editCaseRequiredModelJoins();
		    $caseDetails = $this->ClientCase->read(null, $caseId);
		    $this->request->data['ClientCase'] = $caseDetails['ClientCase'];

		    /*if(!empty($caseDetails['ClientCase']['next_hearing_date']))
		    {
			    $this->request->data['CaseHearing']['date'] = $this->dateTimeDisplayFormat($caseDetails['ClientCase']['next_hearing_date']);
		    }*/

		    $this->set('case_payments',$caseDetails['CasePayment']);
	    }
	    $this->set('caseId',$caseId);

	    $this->loadModel('User');
	    $userModel = new User();
	    $listClients = $userModel->listActiveClients($this->Session->read("UserInfo.uid"));
	    $this->set('listClients',$listClients);
    }

	function uploadFiles()
	{
		die(111);
	}

	function getClientDetails($clientId)
	{
		$this->autoRender = false;
		$this->loadModel('User');
		$user = $this->User->read(null, $clientId);

		$user_details = array(
			'ClientCaseClientFirstName' => '',
			'ClientCaseClientLastName' => '',
			'ClientCaseClientEmail' => '',
			'ClientCaseClientPhoneNumber' => '',
			'ClientCaseClientAlternateNumber' => ''
		);
		if(!empty($user))
		{
			$user_details = array(
				'ClientCaseClientFirstName' => $user['User']['first_name'],
				'ClientCaseClientLastName' => $user['User']['last_name'],
				'ClientCaseClientEmail' => $user['Profile']['email'],
				'ClientCaseClientPhoneNumber' => $user['Profile']['mobile'],
				'ClientCaseClientAlternateNumber' => ''
			);
		}

		echo json_encode($user_details);
		exit;
	}

	function bulkAction($statusValue)
	{
		if (isset($statusValue) && !empty($statusValue)) {
			$data = array();
			$data['ClientCase']['stage'] = $statusValue;

			for ($i = 0; $i < count($_POST['box']); $i++) {
				$this->ClientCase->id = $_POST['box'][$i];
				$this->ClientCase->save($data, array('validate' => false));
			}

			$this->Session->setFlash('<span class="setFlash success">Case ' . $statusValue . ' successfully.</span>');
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	function delete($id=null) {
		$this->loadModel('ClientCase');
		$this->ClientCase->id = $id;
		$data['ClientCase']['is_deleted'] = 1;
		if($this->ClientCase->save($data,array('validate'=>false))) {
			$this->Session->setFlash(CASE_DELETED);
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	public function manageHearings($caseId=null)
	{
		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
		}else{
			$this->layout = 'basic';
		}

		$this->loadModel('CaseHearing');

		$this->pageTitle = 'Manage Case Hearings';
		$this->set("pageTitle", $this->pageTitle);

		$fields = array();

		if (isset($this->data['CaseHearing']['status']) && !empty($this->data['CaseHearing']['status'])) {
			$this->hearingBulkAction($this->data['CaseHearing']['status']);
		}

		$paginateLimit = LIMIT;
		if (isset($this->request->data) && !empty($this->request->data)) {
			foreach ($this->request->data['CaseHearing'] as $key => $value) {
				if (!empty($value)) {
					$this->request->params['named'][$key] = base64_encode($value);
				}
			}
		}

		if (isset($this->request->params['named']) && !empty($this->request->params['named'])) {
			foreach ($this->request->params['named'] as $key => $value) {
				if (!empty($value)) {
					$this->request->data['CaseHearing'][$key] = base64_decode($value);
					if ($key == 'paging_limit') {
						$paginateLimit = base64_decode($value);
					}
				}
			}
		}

		$criteria = "";
		$criteria .= "1=1";
		if (isset($this->data) || !empty($this->params['named'])) {
			if (isset($this->data['ClientCase']['client_name']) && ($this->data['ClientCase']['client_name'] != '')) {
				$criteria .= " AND (ClientCase.client_first_name LIKE '%" . $this->data['ClientCase']['client_name'] . "%' OR ClientCase.client_last_name LIKE '%" . $this->data['ClientCase']['client_name'] . "%')";
			} elseif (isset($this->params['named']['client_name']) && $this->params['named']['client_name'] != '') {
				if (!isset($this->data['ClientCase']['client_name'])) {
					$criteria .= " AND (ClientCase.first_name LIKE '%" . $this->params['named']['client_name'] . "%' OR ClientCase.last_name LIKE '%" . $this->params['named']['client_name'] . "%')";
				}
			}

			if (isset($this->data['CaseHearing']['judge']) && ($this->data['CaseHearing']['judge'] != '')) {
				$criteria .= " AND (CaseHearing.judge LIKE '%" . $this->data['CaseHearing']['judge'] . "%')";
			} elseif (isset($this->params['named']['judge']) && $this->params['named']['judge'] != '') {
				if (!isset($this->data['CaseHearing']['judge'])) {
					$criteria .= " AND (CaseHearing.judge LIKE '%" . $this->params['named']['judge'] . "%')";
				}
			}

			if (isset($this->data['CaseHearing']['date']) && ($this->data['CaseHearing']['date'] != '')) {
				$criteria .= " AND (CaseHearing.date LIKE '%" . $this->data['CaseHearing']['date'] . "%')";
			} elseif (isset($this->params['named']['date']) && $this->params['named']['date'] != '') {
				if (!isset($this->data['CaseHearing']['date'])) {
					$criteria .= " AND (CaseHearing.date LIKE '%" . $this->params['named']['date'] . "%')";
				}
			}
		}

		$conditions = array('CaseHearing.is_deleted' => 0, 'ClientCase.is_deleted' => 0);

		if(!empty($caseId))
		{
			$conditions['case_id'] = $caseId;
		}

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'page' => 1,
			'limit' => $paginateLimit,
			'fields' => $fields,
			'order' => array('CaseHearing.date' => 'desc'),
			//'contain' => array('Customer' => array('Country', 'State', 'City'))
		);
		$records = $this->Paginator->paginate('CaseHearing', $criteria);
		//echo '<pre>'; print_r($records); die;
		$this->set('records', $records);
		$this->set('paginateLimit', $paginateLimit);
		$this->set('caseId',$caseId);
	}

	function hearingBulkAction($statusValue)
	{
		if (isset($statusValue) && !empty($statusValue)) {
			$data = array();
			$data['CaseHearing']['status'] = $statusValue;

			for ($i = 0; $i < count($_POST['box']); $i++) {
				$this->CaseHearing->id = $_POST['box'][$i];
				$this->CaseHearing->save($data, array('validate' => false));
			}

			$this->Session->setFlash('<span class="setFlash success">Case Hearing ' . $statusValue . ' successfully.</span>');
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	function deleteHearing($id=null) {
		$this->loadModel('CaseHearing');
		$this->CaseHearing->id = $id;
		$data['CaseHearing']['is_deleted'] = 1;
		if($this->CaseHearing->save($data,array('validate'=>false))) {
			$this->Session->setFlash(HEARING_DELETED);
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	public function addHearing($caseId, $id=null)
	{
		if(empty($caseId))
		{
			$this->Session->setFlash('<span class="setFlash error">Invalid URL</span>');
			$this->redirect(array('controller' => 'cases', 'action' => 'manage'));
		}

		$this->layout = 'basic';
		$this->pageTitle = 'Add Case Hearing';
		if(!empty($id)) {
			$this->pageTitle = 'Edit Case Hearing';
		}

		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('ClientCase');
		$this->loadModel('CaseHearing');

		if($this->request->data){
			//pr($this->request->data); die;
			if ($this->CaseHearing->validates()) {
				$hearingDate = $this->dateTimeSqlFormat($this->request->data['CaseHearing']['date']);
				if(empty($this->request->data['CaseHearing']['next_hearing_date']))
				{
					$this->request->data['ClientCase']['id'] = $caseId;
					$this->request->data['ClientCase']['next_hearing_date'] = $hearingDate;
					$this->ClientCase->save($this->request->data);
				}

				$caseDetails = $this->ClientCase->read(null, $caseId);

				$this->request->data['CaseHearing']['case_id'] = $caseId;
				$this->request->data['CaseHearing']['client_id'] = $caseDetails['ClientCase']['client_id'];
				$this->request->data['CaseHearing']['date'] = $hearingDate;
				$this->request->data['CaseHearing']['created_by'] = $this->Session->read("UserInfo.uid");

				try{
					$this->CaseHearing->save($this->request->data);
				} catch (Exception $e) {
					//TODO throw $e;
				}

				$this->Session->setFlash(HEARING_ADDED);
				$this->redirect(array('controller' => 'cases', 'action' => 'manageHearings', $caseId));
			}
		}

		$caseHearingDetails = $this->CaseHearing->read(null, $id);
		$this->request->data = $caseHearingDetails;

		$nextHearingDate = '';
		$previousHearingDate = '';
		if(!empty($caseHearingDetails['CaseHearing']['date']))
		{
			$this->request->data['CaseHearing']['date'] = $this->dateTimeDisplayFormat($caseHearingDetails['CaseHearing']['date']);
			$caseHearingModel = new CaseHearing();
			$nextHearingDetails = $caseHearingModel->getNextHearing($caseId, $caseHearingDetails['CaseHearing']['date']);
			$previousHearingDetails = $caseHearingModel->getPreviousHearing($caseId, $caseHearingDetails['CaseHearing']['date']);

			$nextHearingDate = (!empty($nextHearingDetails['CaseHearing']['date'])) ?
				$this->dateTimeDisplayFormat($nextHearingDetails['CaseHearing']['date']) :
				'';

			$previousHearingDate = (!empty($previousHearingDetails['CaseHearing']['date'])) ?
				$this->dateTimeDisplayFormat($previousHearingDetails['CaseHearing']['date']) :
				'';
		}

		$this->set('caseId',$caseId);
		$this->set('id',$id);
		$this->set('nextHearingDate',$nextHearingDate);
		$this->set('previousHearingDate',$previousHearingDate);
		/*$this->loadModel('User');
		$userModel = new User();
		$listClients = $userModel->listActiveClients($this->Session->read("UserInfo.uid"));
		$this->set('listClients',$listClients);*/
	}

	function deletePayment($id, $caseId) {
		$this->loadModel('CasePayment');
		$this->CasePayment->id = $id;
		if($this->CasePayment->delete($id)) {
			$this->Session->setFlash(PAYMENT_DELETED);
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}
}