<?php
class AdminsController extends AppController
{
    public $helpers = array('Validation');

    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!$this->isAdminLoggedIn()) {
            $this->Session->setFlash('<span class="setFlash error">Unauthorized Access</span>');
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function manageLawyers()
    {
        $this->layout = 'basic';
        $this->loadModel('User');

        $this->pageTitle = 'Lawyers Management';
        $this->set("pageTitle", $this->pageTitle);

        $conditions = array('User.user_type' => 2, 'User.status !=' => 0);
        $fields = array();
        /*$this->paginate = array('limit' => LIMIT,'conditions'=>$conditions,'fields'=>$fields,'order'=>'User.id desc');
        $records = $this->paginate('User');
        $this->set('records',$records);*/


        /*$this->User->bindModel(
                array('belongsTo' => array(
                    'Role' => array(
                        'className' => 'Role',
                        'foreignKey'   => 'role_id'
                    )
                )
            )
        );*/

        if (isset($this->data['User']['status']) && !empty($this->data['User']['status'])) {
            $this->lawyersBulkAction($this->data['User']['status']);
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

        /*$urlString = "/";
        if (isset($this->params['pass'][0]) && !empty($this->params['pass'][0])) {
            $urlString .= $this->params['pass'][0] . "/";
        }*/
        $criteria = "";
        $criteria .= " User.user_type=2 AND User.status!=3";
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
            //'conditions' => $conditions,
            'page' => 1,
            'limit' => $paginateLimit,
            'fields' => $fields,
            'order' => array('User.id' => 'desc'),
            //'contain' => array('Customer' => array('Country', 'State', 'City'))
        );
        $records = $this->Paginator->paginate('User', $criteria);
        $this->set('records', $records);
        $this->set('paginateLimit', $paginateLimit);
    }

    public function addLawyer()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Lawyer';
        $this->set("pageTitle", $this->pageTitle);

        App::import('model', 'Plan');
        $modelPlan = new Plan();
        $listPlans = $modelPlan->getPlanDetails('list', array(), array('id_amount', 'name'));
        $this->set('listPlans', $listPlans);

        $this->loadModel('User');
        $this->loadModel('Profile');
        $this->loadModel('UserTransaction');

        $isUserValidate = false;
        $isUserProfileValidate = false;
        $isUserTransactionValidate = false;

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

        $this->UserTransaction->set($this->request->data);
        if ($this->UserTransaction->validates()) {
            $isUserTransactionValidate = true;
        } else {
            $isUserTransactionValidate = false;
        }

        if ($isUserValidate && $isUserProfileValidate && $isUserTransactionValidate) {
            if(isset($this->request->data['UserTransaction']['plan_id']) && !empty($this->request->data['UserTransaction']['plan_id'])){
                $this->request->data['UserTransaction']['plan_id'] = strstr($this->request->data['UserTransaction']['plan_id'],'_',true);
            }

            //pr($this->request->data); die;
            $this->request->data['User']['user_type'] = 2;
            $planDetails = $modelPlan->getPlanDetails('first', array('Plan.id' => $this->request->data['UserTransaction']['plan_id']), array());
            $planExpiryDate = '';
            if (isset($planDetails['Plan']['no_of_days']) && !empty($planDetails['Plan']['no_of_days'])) {
                $planExpiryDate = date('Y-m-d H:i:s', strtotime("+" . $planDetails['Plan']['no_of_days'] . " days"));
            }
            $this->request->data['User']['plan_expiry_date'] = $planExpiryDate;
            $this->request->data['User']['created_by'] = $this->Session->read("uid");
            if ($this->User->save($this->request->data)) {
                $lastInsertedId = $this->User->getLastInsertId();
                $this->request->data['Profile']['user_id'] = $lastInsertedId;
                $this->request->data['Profile']['first_name'] = $this->request->data['User']['first_name'];
                $this->request->data['Profile']['last_name'] = $this->request->data['User']['last_name'];
                if ($this->Profile->save($this->request->data)) {
                    $this->request->data['UserTransaction']['user_id'] = $lastInsertedId;
                    if (!empty($planExpiryDate)) {
                        $this->request->data['UserTransaction']['plan_name'] = $planDetails['Plan']['name'];
                        $this->request->data['UserTransaction']['plan_description 	'] = $planDetails['Plan']['plan_description'];
                        $this->request->data['UserTransaction']['no_of_days'] = $planDetails['Plan']['no_of_days'];
                        $this->request->data['UserTransaction']['plan_expiry_date'] = $planExpiryDate;
                        $this->request->data['UserTransaction']['created_by'] = $this->Session->read("uid");
                        if (isset($this->request->data['UserTransaction']['discount_type'])) {
                            $discountType = $this->request->data['UserTransaction']['discount_type'];
                            $discountAmount = 0;
                            switch ($discountType) {
                                case 1:
                                    $discountAmount = $this->request->data['UserTransaction']['discount_value'] / 100 * $planDetails['Plan']['price'];
                                    break;
                                case 2:
                                    $discountAmount = $this->request->data['UserTransaction']['discount_value'];
                                    break;
                            }
                        }
                        $this->request->data['UserTransaction']['amount'] = $planDetails['Plan']['price'] - $discountAmount;
                        $this->request->data['UserTransaction']['discount_amount'] = $discountAmount;
                    }
                    if ($this->UserTransaction->save($this->request->data)) {
                        $this->Session->setFlash('<span class="setFlash error">Lawyer added successfully.</span>');
                        $this->redirect(array('controller' => 'admins', 'action' => 'manageLawyers'));
                    }
                }
            }
        } else {
            $userTblValidationErrors = $this->User->validationErrors;
            $userProfileTblValidationErrors = $this->Profile->validationErrors;
            $userUserTransactionTblValidationErrors = $this->UserTransaction->validationErrors;
            $this->request->data += array_merge($userTblValidationErrors, $userProfileTblValidationErrors, $userUserTransactionTblValidationErrors);
        }
    }

    function lawyersBulkAction($statusValue)
    {
        if (isset($statusValue) && !empty($statusValue)) {
            for ($i = 0; $i < count($_POST['box']); $i++) {
                $this->User->id = $_POST['box'][$i];
                $data['User']['status'] = $statusValue;
                $data['User']['modified_by'] = $this->Session->read("uid");
                $this->User->save($data, array('validate' => false));
            }

            switch ($statusValue) {
                case 1:
                    $action = 'Activated';
                    break;
                case 2:
                    $action = 'Deactivated';
                    break;
                case 3:
                    $action = 'Deleted';
                    break;
            }
            $this->Session->setFlash('<span class="setFlash error">Lawyers ' . $action . ' successfully.</span>');
        } else {
            $this->Session->setFlash('<span class="setFlash error">An error occurred, Please try again later.</span>');
        }
        $this->redirect($this->referer());
    }
}