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

		if($facebook->getpageid() != "")
		{
			@$idpage = $facebook->getpageid();
			@$_SESSION['idpage'] = $idpage;
		}
		else
		{
			@$idpage = $_SESSION['idpage'];
		}
		
		$data = $page->getInfoPage($idpage);
		$this->view->pageInfo = $data;
		
		//Cau hinh Layout
		$option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/' . $data[0]['templates'] );
        Zend_Layout::startMvc($option);
    }

    public function postDispatch() {
        
    }

}

