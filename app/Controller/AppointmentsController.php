<?php

class AppointmentsController extends AppController
{
    public $helpers = array("Form", "Js" => array('Jquery'), 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Email', 'SendEmail');

    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->isUserLoggedIn() && in_array($this->params['action'], array("login"))) {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
        } elseif (!$this->isUserLoggedIn() && !in_array($this->params['action'], array("login"))) {
            $this->Session->setFlash(Configure::read('UNAUTHORIZED_ACCESS'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

	public function manage()
	{
		if ($this->RequestHandler->isAjax()) {
			$this->layout = 'ajax';
		}else{
			$this->layout = 'basic';
		}

		$this->loadModel('Appointment');

		$this->pageTitle = 'Manage Appointments';
		$this->set("pageTitle", $this->pageTitle);

		$fields = array();

		if (isset($this->data['Appointment']['status']) && !empty($this->data['Appointment']['status'])) {
			$this->bulkAction($this->data['Appointment']['status']);
		}

		$paginateLimit = LIMIT;
		if (isset($this->request->data) && !empty($this->request->data)) {
			foreach ($this->request->data['Appointment'] as $key => $value) {
				if (!empty($value)) {
					$this->request->params['named'][$key] = base64_encode($value);
				}
			}
		}

		if (isset($this->request->params['named']) && !empty($this->request->params['named'])) {
			foreach ($this->request->params['named'] as $key => $value) {
				if (!empty($value)) {
					$this->request->data['Appointment'][$key] = base64_decode($value);
					if ($key == 'paging_limit') {
						$paginateLimit = base64_decode($value);
					}
				}
			}
		}

		$criteria = "";
		$criteria .= "1=1";
		if (isset($this->data) || !empty($this->params['named'])) {
			if (isset($this->data['Appointment']['date']) && ($this->data['Appointment']['date'] != '')) {
				$criteria .= " AND date(Appointment.datetime) BETWEEN '".$this->data['Appointment']['date'] . "' AND '".$this->data['Appointment']['date'] . "'";
			} elseif (isset($this->params['named']['date']) && $this->params['named']['date'] != '') {
				if (!isset($this->data['Appointment']['date'])) {
					$criteria .= " AND date(Appointment.datetime) BETWEEN " . $this->params['named']['date'] . " AND ".$this->params['named']['date'];
				}
			}

			if (isset($this->data['Client']['name']) && ($this->data['Client']['name'] != '')) {
				$criteria .= " AND (Client.first_name LIKE '%" . $this->data['Client']['name'] . "%' OR Client.last_name LIKE '%" . $this->data['Client']['name'] . "%')";
			} elseif (isset($this->params['named']['name']) && $this->params['named']['name'] != '') {
				if (!isset($this->data['Client']['name'])) {
					$criteria .= " AND (Client.first_name LIKE '%" . $this->params['named']['name'] . "%' OR Client.last_name LIKE '%" . $this->params['named']['name'] . "%')";
				}
			}
		}

		$this->Paginator->settings = array(
			'conditions' => array('Appointment.is_deleted' => 0),
			'page' => 1,
			'limit' => $paginateLimit,
			'fields' => $fields,
			'order' => array('Appointment.id' => 'desc'),
			//'contain' => array('Customer' => array('Country', 'State', 'City'))
		);
		$records = $this->Paginator->paginate('Appointment', $criteria);
		//echo '<pre>'; print_r($records); die;
		$this->set('records', $records);
		$this->set('paginateLimit', $paginateLimit);
	}

	public function add()
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Add Appointment';
		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('Appointment');

		if($this->request->data){
			if ($this->Appointment->validates()) {
				$dateTime = $this->request->data['Appointment']['datetime'];
				$dateTime = strtotime($dateTime);
				$dateTime = date( 'Y-m-d H:i:s', $dateTime);

				$this->request->data['Appointment']['lawyer_id'] = $this->Session->read("UserInfo.lawyer_id");
				$this->request->data['Appointment']['datetime'] = $dateTime;
				$this->request->data['Appointment']['created_by'] = $this->Session->read("UserInfo.uid");
				if ($this->Appointment->save($this->request->data)) {
					$this->Session->setFlash(APPOINTMENT_ADDED);
					$this->redirect(array('controller' => 'appointments', 'action' => 'manage'));
				}
			}
		}

		$this->loadModel('User');
		$userModel = new User();
		$listClients = $userModel->listActiveClients($this->Session->read("UserInfo.uid"));
		$this->set('listClients',$listClients);
	}

	public function getClients()
	{

	}

	public function edit($id)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Edit Appointment';
		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('Appointment');

		if($this->request->data){
			if ($this->Appointment->validates()) {

				$dateTime = $this->request->data['Appointment']['datetime'];
				$dateTime = strtotime($dateTime);
				$dateTime = date( 'Y-m-d H:i:s', $dateTime);

				$this->request->data['Appointment']['datetime'] = $dateTime;

				if ($this->Appointment->save($this->request->data)) {
					$this->Session->setFlash(APPOINTMENT_UPDATED);
					$this->redirect(array('controller' => 'appointments', 'action' => 'manage'));
				}
			}
		}
		$this->request->data = $this->Appointment->read(null, $id);

		if(!empty($this->request->data['Appointment']['datetime']))
		{
			$dateTime = $this->request->data['Appointment']['datetime'];
			$dateTime = strtotime($dateTime);
			$this->request->data['Appointment']['datetime'] = date( 'm/d/Y g:i A', $dateTime);
		}

		$this->loadModel('User');
		$userModel = new User();
		$listClients = $userModel->listActiveClients($this->Session->read("UserInfo.uid"));
		$this->set('listClients',$listClients);
		$this->set('id',$id);
	}

	function bulkAction($statusValue)
	{
		if (isset($statusValue) && !empty($statusValue)) {
			$data = array();
			switch ($statusValue) {
				case 1:
					$action = 'Pending';
					$data['Appointment']['status'] = $statusValue;
					break;
				case 2:
					$action = 'Closed';
					$data['Appointment']['status'] = $statusValue;
					break;
			}

			for ($i = 0; $i < count($_POST['box']); $i++) {
				$this->Appointment->id = $_POST['box'][$i];
				$this->Appointment->save($data, array('validate' => false));
			}

			$this->Session->setFlash('<span class="setFlash success">Appointment ' . $action . ' successfully.</span>');
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	function delete($id=null) {
		$this->loadModel('Appointment');
		$this->Appointment->id = $id;
		$data['Appointment']['is_deleted'] = 1;
		if($this->Appointment->save($data,array('validate'=>false))) {
			$this->Session->setFlash(APPOINTMENT_DELETED);
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}
}