<?php

class Admin_ChonpagelikeController extends App_Controller_AdminController {

    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
        
    }

    public function indexAction() {
        if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
		$_SESSION['list_page'] = "0";
		$pageLike = App_Models_PagelikeModel::getInstance();

		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
		
		$listPage = $pageLike->getPage();
		$this->view->listPage = $listPage;
		
		

		
    }
	
	public function luupagelikeAction()
	{
		$pageLike = App_Models_PagelikeModel::getInstance();
		$listPage = $_POST['pagelike'];
		//print_r($listPage);
		$data = $pageLike->luuPageLike($listPage);
		//echo $data;
		if($data == 1)
		{
			$link = APP_DOMAIN . '/admin/chonpagelike';
			echo "<script>ThongBaoDongY('Lưu Thành Công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Lưu không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}
	
	}
	

}








































