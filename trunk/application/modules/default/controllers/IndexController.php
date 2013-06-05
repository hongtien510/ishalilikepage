<?php

class IndexController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$fb = new Ishali_Facebook();
		$pageLike = App_Models_PagelikeModel::getInstance();
		$config = Zend_Registry::get(APPLICATION_CONFIG);

		$checkLike = $fb->kiemTraLike();
		if($checkLike == "")
		{
			$link = APP_DOMAIN . '/index/yeucaulike';
			header("location: $link");
		}
		else
		{
			$idUserFB = $_SESSION['idUserFB'];
			$soLuotLike = $pageLike->kiemTraSoLuongLikeUser($idUserFB);
			
			$data = $pageLike->getConfig();
			$solanlike = $data['solanlike'];
			if($soLuotLike < $solanlike)
			{
				$appId = $config->facebook->appid;
				$data = $pageLike->getPageLike();
				for($i=0; $i<count($data); $i++)
				{
					$idpage = $data[$i]['idpage'];
					$likePage = $fb->checkLikePage($idpage);
					if($likePage == 0)
					{
						$linkAppPage = $data[$i]['linkpage'].'/app_'.$appId;
						$this->view->linkAppPage = $linkAppPage;
						return;
					}
				}
				$this->view->linkAppPage = "";
			}
			else
			{
				$this->view->linkAppPage = "";
			}
				
		}
    }
	
	public function yeucaulikeAction()
	{
		$pageLike = App_Models_PagelikeModel::getInstance();
		$data = $pageLike->getConfig();
		$this->view->config = $data;
	}
	
	public function luotlikeuserAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		
		$pageLike = App_Models_PagelikeModel::getInstance();
		
		$idUserFB = $_SESSION['idUserFB'];
		$idpage = $_SESSION['idpage'];
		$pageLike->addUserLikepage($idUserFB, $idpage);
	}
    
    

   

}
