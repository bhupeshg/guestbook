<?php

class UsersController extends AppController
{
    public $helpers = array("Form", "Js", 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Email', 'SendEmail');

    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->isUserLoggedIn() && in_array($this->params['action'], array("login"))) {
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
        } elseif (!$this->isUserLoggedIn() && !in_array($this->params['action'], array("login"))) {
            $this->Session->setFlash('<span class="setFlash error">Unauthorized Access</span>');
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
        if (!$this->Session->read("uid")) {
            //TODO Create common function to check user login
            if ($this->request->data) {
                $this->User->set($this->request->data);
                if ($this->request->data['User']['action'] == 'login') {
                    $this->User->validate = $this->User->validateLogin;
                    if ($this->User->validate) {
                        App::import('model', 'User');
                        $userModel = new User();
                        $userDetails = $userModel->getDetails('first',
                            array('User.email' => $this->request->data['User']['login_email'], 'User.user_pwd' => $this->request->data['User']['user_pwd']), array('id', 'first_name', 'last_name', 'email', 'user_type'));
                        if ($userDetails) {
                            switch ($type) {
                                case '1':

                                    break;
                                case '2':

                                    break;
                                case '3':

                                    break;
                                default:
                                    break;
                            }
                            $this->writeUserSession($userDetails);

                            $this->User->id = $userDetails['User']['id'];
                            $userInfo['User']['last_login'] = date(Configure::read('DB_DATE_FORMAT'));
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
                            $this->Session->setFlash('<span class="setFlash error">The user could not be found. Please fill the correct information</span>');
                        }
                    }
                } elseif ($this->request->data['User']['action'] == 'forgot') {
                    //if ($this->User->validates(array('forgot_email'))) {
                    $this->User->validate = $this->User->validateForgotPassword;
                    if ($this->User->validate) {
                        App::import('model', 'User');
                        $userModel = new User();
                        $userDetails = $userModel->getDetails('first', array('User.email' => $this->request->data['User']['forgot_email']), array('id', 'first_name', 'last_name', 'email', 'user_type'));
                        if ($userDetails) {
                            /*App::import('Component','SendEmailComponent');
                            $SendEmail = & new SendEmail();*/
                            $emailData = array();
                            if ($this->SendEmail->send($emailData, 'FORGOT_PASSWORD')) {
                                $userInfo = array();
                                $userInfo['User']['id'] = $userDetails['User']['id'];
                                $userInfo['User']['is_forgot'] = 1;
                                $userModel->updateUserInfo($userDetails, 'User');
                                $this->Session->setFlash('<span class="setFlash success">Email sent successfully</span>');
                            } else {
                                $this->Session->setFlash('<span class="setFlash error">Email cannot be sent, Please try again later</span>');
                            }
                        } else {
                            $this->Session->setFlash('<span class="setFlash error">The user could not be found. Please fill the correct information</span>');
                        }
                        $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    }
                }
            }
        } else {
            $this->redirect(array('controller' => 'users', 'action' => 'myAccount'));
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
        $this->set("token", $this->generateToken());
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
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
        exit();
    }

    /**
     * Displays Dashboard Page as per the User Role
     */
    public function dashboard()
    {
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
}