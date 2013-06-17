<?php

class IndexController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$fb = new Ishali_Facebook();
		$pageLike = App_Models_PagelikeModel::getInstance();
		$config = Zend_Registry::get(APPLICATION_CONFIG);

		if($fb->getParameterUrl() == "")
			$idnoidung = "";
		else
			$idnoidung = $fb->getParameterUrl();

		
		$checkLike = $fb->kiemTraLike();
		//$checkLike = 1;
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
				if($data != "")
				{
					for($i=0; $i<count($data); $i++)
					{
						$idpage = $data[$i]['idpage'];
						$likePage = $fb->checkLikePage($idpage);
						if($likePage == 0)
						{
							$linkAppPage = $data[$i]['linkpage'].'/app_'.$appId.'?app_data='.$idnoidung;
							$this->view->linkAppPage = $linkAppPage;
							return;
						}
					}
					//Truong hop Page nao cung da like
					$this->view->linkAppPage = "";
					$linkNoiDung = $pageLike->getLinkNoiDung($idnoidung);
					$this->view->linkNoiDung = $linkNoiDung;
				}
				else//Truong hop ko co page trong du lieu
				{
					$this->view->linkAppPage = "";
					$linkNoiDung = $pageLike->getLinkNoiDung($idnoidung);
					$this->view->linkNoiDung = $linkNoiDung;
				}
					
			}
			else//Truong hop user da like du so luong
			{
				$this->view->linkAppPage = "";
				$linkNoiDung = $pageLike->getLinkNoiDung($idnoidung);
				$this->view->linkNoiDung = $linkNoiDung;
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
