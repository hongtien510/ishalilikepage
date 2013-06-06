<?php
class App_Controller_FrontController extends Zend_Controller_Action {

    public function init() {
        
        
    }

    public function preDispatch() {
	
        $facebook = new Ishali_Facebook();
		$page = App_Models_PagesModel::getInstance();
		$facebook->begins_works(0);

        $idUserFB = $facebook->getuserfbid();
		$_SESSION['idUserFB'] = $idUserFB;
		
		//Cau hinh Layout
		$option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/tmplikepage');
        Zend_Layout::startMvc($option);
    }

    public function postDispatch() {
        
    }

}

