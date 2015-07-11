<?php

class UsersController extends AppController
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

    /**
     * Function performs two actions i.e. Login and Forgot Password
     */
    public function login()
    {
        $this->layout = 'login';
        $this->pageTitle = SITE_NAME;
        $this->set("pageTitle", $this->pageTitle);
        $this->set("token", $this->generateToken());

        App::import('model', 'User');
        $userModel = new User();
        if (!$this->Session->read("uid")) {
            //TODO Create common function to check user login
            if ($this->request->data) {
                $this->User->set($this->request->data);
                if ($this->request->data['User']['action'] == 'login') {
                    $this->User->validate = $this->User->validateLogin;
                    if ($this->User->validate) {
                        $userModel->userSessionRequiredModelJoins();

                        $this->User->recursive = 3;

                        $userDetails = $userModel->getDetails('first',array('User.email' => $this->request->data['User']['login_email'], 'User.user_pwd' => $this->request->data['User']['user_pwd']), array('id', 'first_name', 'last_name', 'email', 'user_type', 'parent_id', 'status', 'is_deleted', 'plan_expiry_date'));

                        if ($userDetails) {
                            if(!$userModel->isUserActive($userDetails)){
                                $this->Session->setFlash(Configure::read('INACTIVE_USER'));
                                $this->redirect(array('controller' => 'users', 'action' => 'login'));
                            }

                            if($userModel->isUserDeleted($userDetails)){
                                $this->Session->setFlash(Configure::read('DELETED_USER'));
                                $this->redirect(array('controller' => 'users', 'action' => 'login'));
                            }

                            $this->writeUserSession($userDetails);

                            $this->User->id = $userDetails['User']['id'];
                            $userInfo['User']['last_login'] = time(); //date(Configure::read('DB_DATE_FORMAT'));
                            $userInfo['User']['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                            $this->User->save($userInfo, array('validate' => false));



                            //Will use common function to update or save model
                            /*$userInfo = array();
                            $userInfo['User']['id'] = $userDetails['User']['id'];
                            $userInfo['User']['last_login'] = date(Configure::read('DB_DATE_FORMAT'));
                            $userInfo['User']['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                            $this->updateInfo($userDetails,'User');*/

                            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                            exit();
                        } else {
                            $this->Session->setFlash(Configure::read('USER_NOT_FOUND'));
                        }
                    }
                } elseif ($this->request->data['User']['action'] == 'forgot') {
                    //if ($this->User->validates(array('forgot_email'))) {
                    $this->User->validate = $this->User->validateForgotPassword;
                    if ($this->User->validate) {
                        $userDetails = $userModel->getDetails('first', array('User.email' => $this->request->data['User']['forgot_email']), array('id', 'first_name', 'last_name', 'email', 'user_type'));
                        if ($userDetails) {
                            /*App::import('Component','SendEmailComponent');
                            $SendEmail = & new SendEmail();*/
                            $emailData = array();
                            $this->Session->setFlash('<span class="setFlash success">Email sent successfully</span>');
                            /*if ($this->SendEmail->send($emailData, 'FORGOT_PASSWORD')) {
                                $userInfo = array();
                                $userInfo['User']['id'] = $userDetails['User']['id'];
                                $userInfo['User']['is_forgot'] = 1;
                                $userModel->updateUserInfo($userDetails, 'User');
                                $this->Session->setFlash('<span class="setFlash success">Email sent successfully</span>');
                            } else {
                                $this->Session->setFlash('<span class="setFlash error">Email cannot be sent, Please try again later</span>');
                            }*/
                        } else {
                            $this->Session->setFlash('<span class="setFlash error">The user could not be found. Please fill the correct information</span>');
                        }
                        if($this->request->isAjax()){
                            $this->render('forgot_password','ajax');
                        }else{
                            $this->redirect(array('controller' => 'users', 'action' => 'login'));
                        }
                    }
                }
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }


        /*if ($this->request->data) {
            if($this->request->data['User']['action'] == 'login'){
                $this->User->set($this->request->data);
                if ($this->User->validates()) {
                    $data = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['e_mail'], 'User.password' => $this->request->data['User']['password'], 'Customer.status ' => '1')));
                    if ($data) {

                    } else {
                        $this->Session->setFlash('Either username or password is wrong.', 'default', array(), 'failure');
                    }
                }
            }
            pr($this->request->data);die;

        }*/

        /* else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }*/
    }

    /**
     * Destroys all sessions of logged in user
     */
    public function logout()
    {
        $this->Session->delete('UserInfo');
		$this->Session->destroy();
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
        exit();
    }

    /**
     * Displays Dashboard Page as per the User Role
     */
    public function dashboard()
    {
		//echo '<pre>'; print_r($this->Session->read());
        $this->layout = 'basic';
        $this->pageTitle = 'Dashboard';
        $this->set("pageTitle", $this->pageTitle);
    }

    public function forgotPassword()
    {
        if (!$this->Session->read("uid") && !$this->Session->read("aid")) {
            $this->layout = 'login';
            if ($this->request->data) {
                $this->User->set($this->request->data);
                if ($this->User->validates()) {
                    $data = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['e_mail'], 'User.password' => $this->request->data['User']['password'], 'Customer.status ' => '1')));
                    if ($data) {

                    } else {
                        $this->Session->setFlash('Either username or password is wrong.', 'default', array(), 'failure');
                    }
                }
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            exit();
        }
    }

    function forgot_password(){

    }
	
	public function manageStaff()
    {
        if ($this->RequestHandler->isAjax()) {
            //Configure::write('debug', 0);
            //$this->autoRender = false;
            $this->layout = 'ajax';
        }else{
            $this->layout = 'basic';
        }

        $this->loadModel('User');

        $this->pageTitle = 'Staff Management';
        $this->set("pageTitle", $this->pageTitle);

        $conditions = array('User.user_type' => 3, 'User.is_deleted' => 0);
        $fields = array();

        if (isset($this->data['User']['status']) && !empty($this->data['User']['status'])) {
            $this->staffBulkAction($this->data['User']['status']);
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
        $criteria .= " User.user_type=3 AND User.is_deleted=0";
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

    public function addStaff()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Staff';
        $this->set("pageTitle", $this->pageTitle);

		App::import('model', 'StaffRole');
        $modelStaffRole = new StaffRole();
        $listRoles = $modelStaffRole->getDetails('list', array(), array('id', 'name'));
        $this->set('listRoles', $listRoles);

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
				$this->request->data['User']['user_type'] = 3;
				$this->request->data['User']['created_by'] = $this->Session->read("uid");
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

                    $this->Session->setFlash(Configure::read('STAFF_ADDED'));
                    $this->redirect(array('controller' => 'users', 'action' => 'manageStaff'));
				}
			} else {
				$userTblValidationErrors = $this->User->validationErrors;
				$userProfileTblValidationErrors = $this->Profile->validationErrors;
				$this->request->data += array_merge($userTblValidationErrors, $userProfileTblValidationErrors);
			}
		}
    }

	public function editStaff($id)
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
				$this->request->data['User']['created_by'] = $this->Session->read("uid");
				if ($this->User->save($this->request->data)) {
					$this->request->data['Profile']['user_id'] = $id;
					$this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
					$this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
					$this->request->data['Profile']['email'] = $this->request->data['User']['email'];
					if ($this->Profile->save($this->request->data)) {
						$this->Session->setFlash(Configure::read('STAFF_UPDATED'));
						$this->redirect(array('controller' => 'users', 'action' => 'manageStaff'));
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
	
	function staffBulkAction($statusValue)
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
            
            $this->Session->setFlash('<span class="setFlash success">Staff ' . $action . ' successfully.</span>');
        } else {
            $this->Session->setFlash(ERROR_OCCURRED);
        }
        $this->redirect($this->referer());
    }

    public function getRolePermissions($role){
        $modulesWithPermissions = array();
        if(!empty($role)){
            $this->loadModel('RolePermission');
            $rolePermissionModel = new RolePermission();
            $modulesWithPermissions = $rolePermissionModel->getModulesByRole($role);
        }
        $this->set('modulesWithPermissions',$modulesWithPermissions);
        $this->render('/Elements/Users/list_roles');
    }

    public function switchLawyer()
    {
        $this->layout = 'login';
        $this->loadModel('User');
        if ($this->request->data) {
            if ($this->request->data['User']['lawyer_id']!='') {
                $this->Session->write('UserInfo.lawyer_id', $this->request->data['User']['lawyer_id']);
                $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
            }
        }
        $userModel = new User();
        $listLawyers = $userModel->listActiveLawyers();
        $this->set('listLawyers',$listLawyers);
    }

    public function editStaffRoles($userId=null)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Edit Staff Roles';
        $this->set("pageTitle", $this->pageTitle);

        App::import('model', 'StaffRole');
        $modelStaffRole = new StaffRole();
        $listRoles = $modelStaffRole->getDetails('list', array(), array('id', 'name'));
        $this->set('listRoles', $listRoles);

        $this->loadModel('User');

        if($this->request->data){
            $this->loadModel('UserModule');
            $userModuleModel = new UserModule();
            $this->request->data['UserModule']['user_id'] = $id;
            $userModuleModel->saveUserData($this->request->data);
        }
        $this->set('userId', $userId);
    }

	public function listClients()
	{
		echo '<pre>'; print_r($_REQUEST); die;
	}
}