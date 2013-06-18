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
		//$checkLike = 1;
		if($checkLike == "")
		{
			$link = APP_DOMAIN . '/index/yeucaulike';
			header("location: $link");
		}
		else
		{
			$idpage = @$_SESSION['idpage'];
			$userLike = $_SESSION['userLike'];
			$pageLike->luuSessionUserLikePage($userLike, $idpage);//Sau khi like page, sẽ luu dia chi Mac va idPage
		
			$soLuotLikeTrongNgay = $pageLike->soLuotLikeTrongNgay($userLike);
			
			$data = $pageLike->getConfig();//Lay Gia Tri Bang Config
			$solanlike = $data['solanlike'];
			
			if($soLuotLikeTrongNgay < $solanlike)
			{
				$appId = $config->facebook->appid;
				$data = $pageLike->getPageLike();//List Page Like
				if($data != "")
				{
					for($i=0; $i<count($data); $i++)
					{
						$idpage = $data[$i]['idpage'];
						$checkLikePage = $pageLike->checkLikePage($userLike, $idpage);
						if($checkLikePage == 1)//Page nay chua duoc like
						{
							if($fb->getParameterUrl() == "")
							{
								$linkAppPage = $data[$i]['linkpage'].'/app_'.$appId;
							}
							else
							{
								$idnoidung = $fb->getParameterUrl();
								$linkAppPage = $data[$i]['linkpage'].'/app_'.$appId.'?app_data='.$idnoidung;
							}
							$this->view->linkAppPage = $linkAppPage;
							return;
						}
					}//Truong hop Page nao cung da like
					if($fb->getParameterUrl() == ""){
						$this->view->linkAppPage = "";
						$this->view->linkNoiDung = "";
					}else{
						$this->view->linkAppPage = "";
						$idnoidung = $fb->getParameterUrl();
						$linkNoiDung = $pageLike->getLinkNoiDung($idnoidung);
						$this->view->linkNoiDung = $linkNoiDung;
					}
				}
				else//Truong hop ko co page trong du lieu
				{
					if($fb->getParameterUrl() == ""){
						$this->view->linkAppPage = "";
						$this->view->linkNoiDung = "";
					}else{
						$this->view->linkAppPage = "";
						$idnoidung = $fb->getParameterUrl();
						$linkNoiDung = $pageLike->getLinkNoiDung($idnoidung);
						$this->view->linkNoiDung = $linkNoiDung;
					}
				}
					
			}
			else//Truong hop user da like du so luong
			{
				if($fb->getParameterUrl() == ""){
						$this->view->linkAppPage = "";
						$this->view->linkNoiDung = "";
				}else{
					$this->view->linkAppPage = "";
					$idnoidung = $fb->getParameterUrl();
					$linkNoiDung = $pageLike->getLinkNoiDung($idnoidung);
					$this->view->linkNoiDung = $linkNoiDung;
				}
			}
		}
    }
	
	public function yeucaulikeAction()
	{
		$pageLike = App_Models_PagelikeModel::getInstance();
		$data = $pageLike->getConfig();
		$this->view->config = $data;
	}
	

    

   

}
