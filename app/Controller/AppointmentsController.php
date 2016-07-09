<?php

class AppointmentsController extends AppController
{
    public $helpers = array('Form', 'Js' => array('Jquery'), 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Email', 'SendEmail');

    /**
     * This function gets called before every action of the controller to implement any common logic
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->isUserLoggedIn() && in_array($this->params['action'], array('login'))) {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
        } elseif (!$this->isUserLoggedIn() && !in_array($this->params['action'], array('login'))) {
            $this->Session->setFlash(Configure::read('UNAUTHORIZED_ACCESS'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    /**
     * Returns appointments in paginated way. It also take care of search functionality on page
     * @return [json] [If request is API returns data in json format]
     */
    public function index()
    {
        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'basic';
        }

        $this->loadModel('Appointment');

        $this->pageTitle = 'Manage Appointments';
        $this->set('pageTitle', $this->pageTitle);

        $fields = array();

        if (isset($this->request->data['Appointment']['status']) && !empty($this->data['Appointment']['status'])) {
            $this->bulkAction($this->request->data['Appointment']['status']);
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

        $criteria = '';
        $criteria .= '1=1';
        if (isset($this->data) || !empty($this->params['named'])) {
            if (isset($this->data['Appointment']['date']) && ($this->data['Appointment']['date'] != '')) {
                $criteria .= " AND date(Appointment.datetime) BETWEEN '".$this->data['Appointment']['date']."' AND '".$this->data['Appointment']['date']."'";
            } elseif (isset($this->params['named']['date']) && $this->params['named']['date'] != '') {
                if (!isset($this->data['Appointment']['date'])) {
                    $criteria .= ' AND date(Appointment.datetime) BETWEEN '.$this->params['named']['date'].' AND '.$this->params['named']['date'];
                }
            }

            if (isset($this->data['Client']['name']) && ($this->data['Client']['name'] != '')) {
                $criteria .= " AND (Client.first_name LIKE '%".$this->data['Client']['name']."%' OR Client.last_name LIKE '%".$this->data['Client']['name']."%' OR Appointment.new_client_name LIKE '%".$this->data['Client']['name']."%')";
            } elseif (isset($this->params['named']['name']) && $this->params['named']['name'] != '') {
                if (!isset($this->data['Client']['name'])) {
                    $criteria .= " AND (Client.first_name LIKE '%".$this->params['named']['name']."%' OR Client.last_name LIKE '%".$this->params['named']['name']."%' OR Appointment.new_client_name LIKE '%".$this->params['named']['name']."%')";
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
        $this->set('records', $records);
        $this->set('paginateLimit', $paginateLimit);

        // If request is API request then send JSON response
        if ($this->isApi) {
        	$result = array('success' => true, 'data' => $records);
        	$this->response->body(json_encode($result));
            $this->response->type('json');
            return $this->response;
        }
    }

    /**
     * This function will be used to add new appointments
     */
    public function add()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Appointment';
        $this->set('pageTitle', $this->pageTitle);

        $this->loadModel('Appointment');
        if ($this->request->data) {
            if ($this->isApi) {
                $this->request->data['Appointment'] = $this->request->data;
            }
            // Add current logged in User data
            $this->request->data['Appointment']['lawyer_id'] = $this->Session->read('UserInfo.lawyer_id');
            $this->request->data['Appointment']['created_by'] = $this->Session->read('UserInfo.uid');
            $result = $this->Appointment->add($this->request->data['Appointment']);

            // Check if request is an API request
            if ($this->isApi) {
                if ($result['success']) {
                    $result['message'] = APPOINTMENT_ADDED;
                } else {
                    $result['message'] = ERROR_OCCURRED;
                }
                $this->response->body(json_encode($result));
                $this->response->type('json');

                return $this->response;
            } else {
                if ($result['success']) {
                    $this->Session->setFlash(APPOINTMENT_ADDED);
                } else {
                    $this->Session->setFlash(APPOINTMENT_ADDED);
                }
                $this->redirect(array('controller' => 'appointments', 'action' => 'manage'));
            }
        }

        $this->loadModel('User');
        $userModel = new User();
        $listClients = $userModel->listActiveClients($this->Session->read('UserInfo.uid'));
        $this->set('listClients', $listClients);
    }

    
    /**
     * This function will edit an existing appointment of the current logged in user
     * @param  string $id [Id of appointment being edited]
     * @return array  returns the success or failure of the operation if its an API request or simply redirect the page
     */
    public function edit($id)
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Edit Appointment';
        $this->set('pageTitle', $this->pageTitle);

        $this->loadModel('Appointment');
        if ($this->request->data) {
            if ($this->isApi) {
                $this->request->data['Appointment'] = $this->request->data;
            }
            $this->request->data['Appointment']['id'] = $id;
            $result = $this->Appointment->edit($this->request->data['Appointment']);
            // Check if request is an API call or redirect user to respective page
            if ($this->isApi) {
                if ($result['success']) {
                    $result['message'] = APPOINTMENT_UPDATED;
                } else {
                    $result['message'] = ERROR_OCCURRED;
                }
                $this->response->body(json_encode($result));
                $this->response->type('json');

                return $this->response;
            } else {
                if ($result['success']) {
                    $this->Session->setFlash(APPOINTMENT_UPDATED);
                } else {
                    $this->Session->setFlash(ERROR_OCCURRED);
                }
                $this->redirect(array('controller' => 'appointments', 'action' => 'manage'));
            }
        }

        // Get the current record being edited
        $this->request->data = $this->Appointment->read(null, $id);

        // CHange datetime to view on front end
        if (!empty($this->request->data['Appointment']['datetime'])) {
            $dateTime = $this->request->data['Appointment']['datetime'];
            $dateTime = strtotime($dateTime);
            $this->request->data['Appointment']['datetime'] = date('m/d/Y g:i A', $dateTime);
        }

        $this->loadModel('User');
        $userModel = new User();
        $listClients = $userModel->listActiveClients($this->Session->read('UserInfo.uid'));
        $this->set('listClients', $listClients);
        $this->set('id', $id);
    }

    /**
     * To mark the status of multiple appontments as pending/closed at once
     * @param  [string] $statusValue [status of appointment to be updated]
     */
    public function bulkAction($statusValue)
    {
        if (isset($statusValue) && !empty($statusValue)) {
            $data = array();
            $data['Appointment']['status'] = $statusValue;
            switch ($statusValue) {
                case 1:
                    $action = 'Pending';
                    break;
                case 2:
                    $action = 'Closed';
                    break;
            }

            for ($i = 0; $i < count($_POST['box']); ++$i) {
                $this->Appointment->id = $_POST['box'][$i];
                $this->Appointment->save($data, array('validate' => false));
                $this->Appointment->id = null;
            }

            $this->Session->setFlash('<span class="setFlash success">Appointment '.$action.' successfully.</span>');
        } else {
            $this->Session->setFlash(ERROR_OCCURRED);
        }
        $this->redirect($this->referer());
    }

    /**
     * Mark the given appointment to be deleted
     * @param  string $id Id of appointment being deleted
     * @return array  returns the success or failure of the operation if its an API request or simply redirect the page
     */
    public function delete($id = null)
    {
        $this->loadModel('Appointment');
        $this->Appointment->id = $id;
        $data['Appointment']['is_deleted'] = 1;
        if ($this->Appointment->save($data, array('validate' => false))) {
            if ($this->isApi) {
                $result = array('success' => true, 'message' => APPOINTMENT_DELETED);
            } else {
                $this->Session->setFlash(APPOINTMENT_DELETED);
            }
        } else {
            if ($this->isApi) {
                $result = array('success' => false, 'message' => ERROR_OCCURRED);
            } else {
                $this->Session->setFlash(ERROR_OCCURRED);
            }
        }
        if ($this->isApi) {
            $this->response->body(json_encode($result));
            $this->response->type('json');

            return $this->response;
        } else {
            $this->redirect($this->referer());
        }
    }
}
