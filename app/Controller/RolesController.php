<?php
class RolesController extends AppController
{
    public $components = array('RequestHandler');
    //public $helpers = array('Validation','Js');
    public $helpers = array('Js' => array('Jquery'));

    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!$this->isAdminLoggedIn()) {
            $this->Session->setFlash(Configure::read('UNAUTHORIZED_ACCESS'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    public function add()
    {
        $this->layout = 'add';
    }

    public function assign()
    {
        $this->layout = 'main';
    }

    public function manage()
    {
        if ($this->RequestHandler->isAjax()) {
            //Configure::write('debug', 0);
            //$this->autoRender = false;
            $this->layout = 'ajax';
        }else{
            $this->layout = 'basic';
        }
		
		/*if($this->request->isAjax()){
			$this->render('forgot_password','ajax');
		}else{
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}*/

        $this->loadModel('User');

        $this->pageTitle = 'Lawyers Management';
        $this->set("pageTitle", $this->pageTitle);

        $conditions = array('User.user_type' => 2, 'User.is_deleted' => 0);
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
        $criteria .= " User.user_type=2 AND User.is_deleted=0";
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
}