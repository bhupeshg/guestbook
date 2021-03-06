<?php

class LawyersController extends AppController
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

	public function manageClient()
	{
		if ($this->RequestHandler->isAjax()) {
			//Configure::write('debug', 0);
			//$this->autoRender = false;
			$this->layout = 'ajax';
		}else{
			$this->layout = 'basic';
		}

		$this->loadModel('User');

		$this->pageTitle = 'Client Management';
		$this->set("pageTitle", $this->pageTitle);

		$conditions = array('User.user_type' => 4, 'User.is_deleted' => 0);
		$fields = array();

		if (isset($this->data['User']['status']) && !empty($this->data['User']['status'])) {
			$this->clientBulkAction($this->data['User']['status']);
		}

		$paginateLimit = LIMIT;
		if (isset($this->request->data) && !empty($this->request->data)) {
			foreach ($this->request->data['User'] as $key => $value) {
				if (!empty($value)) {
					$this->request->params['named'][$key] = base64_encode($value);
				}
			}
		}

		if (isset($this->request->params['named']) && !empty($this->request->params['named'])) {
			foreach ($this->request->params['named'] as $key => $value) {
				if (!empty($value)) {
					$this->request->data['User'][$key] = base64_decode($value);
					if ($key == 'paging_limit') {
						$paginateLimit = base64_decode($value);
					}
				}
			}
		}

		$criteria = "";
		$criteria .= " User.user_type=4 AND User.is_deleted=0";
		if (isset($this->data['User']) || !empty($this->params['named'])) {

			if (isset($this->data['User']['first_name']) && ($this->data['User']['first_name'] != '')) {
				$criteria .= " AND User.first_name LIKE '%" . $this->data['User']['first_name'] . "%'";
			} elseif (isset($this->params['named']['first_name']) && $this->params['named']['first_name'] != '') {
				if (!isset($this->data['User']['first_name'])) {
					$criteria .= " AND User.first_name LIKE '%" . $this->params['named']['first_name'] . "%'";
				}
			}

			if (isset($this->data['User']['last_name']) && ($this->data['User']['last_name'] != '')) {
				$criteria .= " AND User.last_name LIKE '%" . $this->data['User']['last_name'] . "%'";
			} elseif (isset($this->params['named']['last_name']) && $this->params['named']['last_name'] != '') {
				if (!isset($this->data['User']['last_name'])) {
					$criteria .= " AND User.last_name LIKE '%" . $this->params['named']['last_name'] . "%'";
				}
			}

			if (isset($this->data['User']['email']) && ($this->data['User']['email'] != '')) {
				$criteria .= " AND User.email LIKE '%" . $this->data['User']['email'] . "%'";
			} elseif (isset($this->params['named']['email']) && $this->params['named']['email'] != '') {
				if (!isset($this->data['User']['email'])) {
					$criteria .= " AND User.email LIKE '%" . $this->params['named']['email'] . "%'";
				}
			}
		}

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'page' => 1,
			'limit' => $paginateLimit,
			'fields' => $fields,
			'order' => array('User.id' => 'desc'),
			//'contain' => array('Customer' => array('Country', 'State', 'City'))
		);
		$records = $this->Paginator->paginate('User', $criteria);
		//echo '<pre>'; print_r($records); die;
		$this->set('records', $records);
		$this->set('paginateLimit', $paginateLimit);
	}

	public function addClient()
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Add Client';
		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('User');
		$this->loadModel('Profile');

		if($this->request->data){
			//pr($this->request->data); die;
			$isUserValidate = false;
			$isUserProfileValidate = false;

			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$isUserValidate = true;
			} else {
				$isUserValidate = false;
			}

			$this->Profile->set($this->request->data);
			if ($this->Profile->validates()) {
				$isUserProfileValidate = true;
			} else {
				$isUserProfileValidate = false;
			}

			if ($isUserValidate && $isUserProfileValidate) {
				//pr($this->request->data); die;
				$this->request->data['User']['type'] = 'Lawyer';
				$this->request->data['User']['user_type'] = 4;
				$this->request->data['User']['parent_id'] = $this->Session->read("UserInfo.lawyer_id");
				$this->request->data['User']['created_by'] = $this->Session->read("UserInfo.uid");
				if ($this->User->save($this->request->data)) {
					$lastInsertedId = $this->User->getLastInsertId();
					$this->request->data['Profile']['user_id'] = $lastInsertedId;
					$this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
					$this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
					$this->request->data['Profile']['email'] = $this->request->data['User']['email'];

					try{
						$this->Profile->save($this->request->data);
					} catch (Exception $e) {
						//TODO throw $e;
					}

					$this->loadModel('UserModule');
					$userModuleModel = new UserModule();
					$this->request->data['UserModule']['user_id'] = $lastInsertedId;
					$userModuleModel->saveUserData($this->request->data);

					$this->Session->setFlash(CLIENT_ADDED);
					$this->redirect(array('controller' => 'lawyers', 'action' => 'manageClient'));
				}
			} else {
				$userTblValidationErrors = $this->User->validationErrors;
				$userProfileTblValidationErrors = $this->Profile->validationErrors;
				$this->request->data += array_merge($userTblValidationErrors, $userProfileTblValidationErrors);
			}
		}
	}

	public function editClient($id)
	{
		$this->layout = 'basic';
		$this->pageTitle = 'Edit Lawyer';
		$this->set("pageTitle", $this->pageTitle);

		$this->loadModel('User');
		$this->loadModel('Profile');

		if($this->request->data){
			$isUserValidate = false;
			$isUserProfileValidate = false;

			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$isUserValidate = true;
			}

			$this->Profile->set($this->request->data);
			if ($this->Profile->validates()) {
				$isUserProfileValidate = true;
			}

			if ($isUserValidate && $isUserProfileValidate) {
				$this->request->data['User']['created_by'] = $this->Session->read("uid");
				if ($this->User->save($this->request->data)) {
					$this->request->data['Profile']['user_id'] = $id;
					$this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
					$this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
					$this->request->data['Profile']['email'] = $this->request->data['User']['email'];
					if ($this->Profile->save($this->request->data)) {
						$this->Session->setFlash(CLIENT_UPDATED);
						$this->redirect(array('controller' => 'lawyers', 'action' => 'manageClient'));
					}
				}
			} else {
				$userTblValidationErrors = $this->User->validationErrors;
				$userProfileTblValidationErrors = $this->Profile->validationErrors;
				$this->request->data += array_merge($userTblValidationErrors, $userProfileTblValidationErrors);
			}
		}
		$this->request->data = $this->User->read(null, $id);
		//pr($this->request->data); die;
		$this->set('id',$id);
	}

	function clientBulkAction($statusValue)
	{
		if (isset($statusValue) && !empty($statusValue)) {
			$data = array();
			switch ($statusValue) {
				case 1:
					$action = 'Activated';
					$data['User']['status'] = $statusValue;
					break;
				case 2:
					$action = 'Deactivated';
					$data['User']['status'] = $statusValue;
					break;
				case 3:
					$action = 'Deleted';
					$data['User']['is_deleted'] = 1;
					break;
			}

			for ($i = 0; $i < count($_POST['box']); $i++) {
				$this->User->id = $_POST['box'][$i];
				$data['User']['modified_by'] = $this->Session->read("uid");
				$this->User->save($data, array('validate' => false));
			}

			$this->Session->setFlash('<span class="setFlash success">Client ' . $action . ' successfully.</span>');
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	function deleteClient($id=null) {
		$this->loadModel('User');
		$this->User->id = $id;
		$data['User']['is_deleted'] = 1;
		if($this->User->save($data,array('validate'=>false))) {
			$this->Session->setFlash(CLIENT_DELETED);
		} else {
			$this->Session->setFlash(ERROR_OCCURRED);
		}
		$this->redirect($this->referer());
	}

	public function addQuickClient()
	{
		$this->layout = 'ajax';

		$this->loadModel('User');
		$this->loadModel('Profile');

		$result = array('status' => 'error', 'message' => 'Unable to process data');

		if($this->request->data){
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$isUserValidate = true;
			} else {
				$isUserValidate = false;
			}

			$this->Profile->set($this->request->data);
			if ($this->Profile->validates()) {
				$isUserProfileValidate = true;
			} else {
				$isUserProfileValidate = false;
			}

			if ($isUserValidate && $isUserProfileValidate) {

				$this->request->data['User']['type'] = 'Lawyer';
				$this->request->data['User']['user_type'] = 4;
				$this->request->data['User']['parent_id'] = $this->Session->read("UserInfo.lawyer_id");
				$this->request->data['User']['created_by'] = $this->Session->read("UserInfo.uid");
				if ($this->User->save($this->request->data)) {
					$lastInsertedId = $this->User->getLastInsertId();
					$this->request->data['Profile']['user_id'] = $lastInsertedId;
					$this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
					$this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
					$this->request->data['Profile']['email'] = $this->request->data['User']['email'];

					try{
						$this->Profile->save($this->request->data);
					} catch (Exception $e) {
						//TODO throw $e;
					}

					$this->loadModel('UserModule');
					$userModuleModel = new UserModule();
					$this->request->data['UserModule']['user_id'] = $lastInsertedId;
					$userModuleModel->saveUserData($this->request->data);


					$userModel = new User();
					$listClients = $userModel->listActiveClients($this->Session->read("UserInfo.uid"));

					$result = array('status' => 'success', 'message' => CLIENT_ADDED, 'clients' => $listClients);
				}
			} else {
				$userTblValidationErrors = $this->User->validationErrors;
				$userProfileTblValidationErrors = $this->Profile->validationErrors;
				$formErrors = array_merge($userTblValidationErrors, $userProfileTblValidationErrors);

				$result = array('status' => 'error', 'message' => $formErrors);
			}
		}

		echo json_encode($result); exit;
	}
}