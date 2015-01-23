<?php

class CasesController extends AppController
{
    public $helpers = array("Form", "Js" => array('Jquery'), 'Validation');
    //JS and Validation helpers are not in Use right now

    public $components = array('RequestHandler', 'Email');

	public function manage()
    {
        if ($this->RequestHandler->isAjax()) {
            //Configure::write('debug', 0);
            //$this->autoRender = false;
            $this->layout = 'ajax';
        }else{
            $this->layout = 'basic';
        }

        $this->pageTitle = 'Manage Cases';
        $this->set("pageTitle", $this->pageTitle);
    }

    public function add()
    {
        $this->layout = 'basic';
        $this->pageTitle = 'Add Case';
        $this->set("pageTitle", $this->pageTitle);
    }
}