<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $components = array('Session', 'Paginator');

    public function beforeFilter()
    {
        $currentUrl = $this->params['controller'].'/'.$this->params['action'];

        if(!$this->checkUserAccess($currentUrl)){
            $this->Session->setFlash(Configure::read('UNAUTHORIZED_ACCESS'));
            $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
        }

        $this->isLawyerSelected();
        /*if(!$this->isLawyerSelected()){
            echo 'sdds'; die;
            if ($this->Session->read('UserInfo.lawyer_id')!='' && $this->Session->read('UserInfo.lawyer_id')!=0) {
                return true;
            }else{
                if($this->isAdminLoggedIn()){
                    $this->redirect(array('controller' => 'users', 'action' => 'switch'));
                }else{
                    $this->redirect(array('controller' => 'users', 'action' => 'logout'));
                }
            }
        }*/

        parent::beforeFilter();
        /*if ($this->RequestHandler->isAjax()) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $this->layout = 'ajax';
        }*/
    }

    public function generateToken()
    {
        $token = uniqid();
        $this->Session->write("token", $token);
        return uniqid();
    }

    public function isTokenValid($token)
    {
        if (!empty($token) && $this->Session->read("token") == $token) {
            return true;
        }
        return false;
    }

    public function isUserLoggedIn()
    {
        if ($this->Session->read('UserInfo.uid') != '') {
            return true;
        }
        return false;
    }

    public function isAdminLoggedIn()
    {
        if ($this->Session->read('isSuperAdmin') != '') {
            return true;
        }
        return false;
    }

    public function writeUserSession($userDetails)
    {
        if (isset($userDetails) && !empty($userDetails)) {
            $userType = $userDetails['User']['user_type'];
            switch ($userType) {
                case '1':
                    $this->Session->write('isSuperAdmin', 1);
                    break;
                case '2':
                    $this->Session->write('isLawyer', 1);
                    $this->Session->write('UserInfo.lawyer_id', $userDetails['User']['id']);
                    break;
                case '3':
                    $this->Session->write('isStaff', 1);
                    $this->Session->write('UserInfo.lawyer_id', $userDetails['User']['parent_id']);
                    break;
                default:
                    break;
            }

            $this->Session->write('UserInfo.uid', $userDetails['User']['id']);
            $this->Session->write('UserInfo.email', $userDetails['User']['email']);
            $this->Session->write('UserInfo.first_name', $userDetails['User']['first_name']);
            $this->Session->write('UserInfo.last_name', $userDetails['User']['last_name']);
            $this->Session->write('UserInfo.user_type', $userDetails['User']['user_type']);
            $this->Session->write('UserInfo.plan_expiry_date', $userDetails['User']['plan_expiry_date']);

            $userModulesArray = array();
            $userPermissionsArray = array();
            if(isset($userDetails['UserModule']) && !empty($userDetails['UserModule'])){
                foreach($userDetails['UserModule'] as $userModules){
                    $userModulesArray[$userModules['module_id']] = array();
                    if(isset($userModules['UserModulePermission']) && !empty($userModules['UserModulePermission'])){
                        foreach($userModules['UserModulePermission'] as $userModulesPermission){
                            $userPermissionsArray[$userModulesPermission['module_permission_id']] = $userModulesPermission['ModulePermission']['url'];
                            $userModulesArray[$userModules['module_id']][$userModulesPermission['module_permission_id']] = $userModulesPermission['ModulePermission']['url'];
                        }
                    }
                }
            }

            $this->Session->write('UserInfo.UserAccessPermissions', $userPermissionsArray);
            $this->Session->write('UserInfo.UserAccessModules', $userModulesArray);
        }
    }

    public function updateInfo($data, $model)
    {
        $this->loadModel($model);
        if ($this->$model->save($data)) {

        }
    }

    public function checkUserAccess($currentUrl)
    {
        if(empty($currentUrl)){
            return false;
        }

        if($this->isAdminLoggedIn() || $this->isUserLoggedIn()){
            return true;
        }

        if(!$this->checkAllowedActions($currentUrl)){
            if($this->isUserLoggedIn()){
                if($this->Session->read('UserInfo.UserAccessPermissions')!=''){
                    if($this->checkPermissions($currentUrl,$this->Session->read('UserInfo.UserAccessPermissions'))){
                        return true;
                    }
                }
            }
        }else{
            return true;
        }
        return false;
    }

    public function checkAllowedActions($currentUrl)
    {
        if($this->checkPermissions($currentUrl,$this->allowedActions())){
            return true;
        }
        return false;
    }

    public function checkPermissions($currentUrl,$listActions){
        $listAllowedActions = array_map('strtolower',$listActions);
        if(in_array(strtolower($currentUrl),$listAllowedActions)){
            return true;
        }
        return false;
    }

    public function allowedActions(){
        return array(
            'users/dashboard',
            'users/login',
            'users/logout',
        );
    }

    public function isLawyerSelected(){
        if ($this->Session->read('UserInfo')!='') {
            if ($this->Session->read('UserInfo.lawyer_id')=='' || $this->Session->read('UserInfo.lawyer_id')==0) {
                if($this->isAdminLoggedIn()){
                    if($this->params['action']!='switchLawyer'){
                        $this->redirect(array('controller' => 'users', 'action' => 'switchLawyer'));
                    }
                }else{
                    $this->redirect(array('controller' => 'users', 'action' => 'logout'));
                }
            }
        }
    }

	public function dateTimeSqlFormat($dateTime)
	{
		$dateTime = strtotime($dateTime);
		return date( 'Y-m-d H:i:s', $dateTime);
	}

	public function dateTimeDisplayFormat($dateTime)
	{
		$dateTime = strtotime($dateTime);
		return date( 'm/d/Y g:i A', $dateTime);
	}
}