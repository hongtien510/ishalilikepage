<?php
class App_Controller_FrontController extends Zend_Controller_Action {

    public function init() {
    }

    public function preDispatch() {
	
        $facebook = new Ishali_Facebook();
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		$pageLike = App_Models_PagelikeModel::getInstance();
		
		
		if($facebook->getpageid() != "")
		{
			@$idpage = $facebook->getpageid();
			@$_SESSION['idpage'] = $idpage;
		}
		else
		{
			@$idpage = $_SESSION['idpage'];
		}
		/*
		$infoPage = $pageLike->thongTinTrang($idpage);
		
		$linkPage = $infoPage[0]['link_page'];
		$appId = $config->facebook->appid;
		
		if($facebook->getParameterUrl() == "")
		{
			$appData = "";
			$linkPageApp = $linkPage . '/app_' . $appId;
		}
		else
		{
			$appData = $facebook->getParameterUrl();
			$linkPageApp = $linkPage . '/app_' . $appId . '?app_data=' . $appData;
		}
		*/
		
		
/* 		$idUserFB = $facebook->getuserfbid();
		if($idUserFB == 0)
		{
			$facebook->userlogin($linkPageApp);
		}
		$_SESSION['idUserFB'] = $idUserFB; */
		
		//Cau hinh Layout
		$option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/tmplikepage');
        Zend_Layout::startMvc($option);
    }

    public function postDispatch() {
        
    }

}

