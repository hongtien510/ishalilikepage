<?php

class Admin_SapxeppagelikeController extends App_Controller_AdminController {

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

		$pageLike = App_Models_PagelikeModel::getInstance();

		$listPage = $pageLike->getPageLike();
		$this->view->listPage = $listPage;
    }
	
	public function capnhatpagelikeAction() {
		$store = App_Models_StoreModel::getInstance();
		$sql = "select idpage from ishali_pages_like";
		$data = $store->SelectQuery($sql);
		for($i=0; $i<count($data); $i++)
		{
			$idpage = $data[$i]['idpage'];
			$thutu = @$_POST[$idpage];
			
			$sql2 = "update ishali_pages_like set thutu = '". $thutu ."' where idpage = '". $idpage ."'";
			$rs = $store->InsertDeleteUpdateQuery($sql2);
		}
		
		$link = APP_DOMAIN . '/admin/sapxeppagelike';
		echo "<script>ThongBaoDongY('Cập nhật thành công.', '$link');</script>";	
	}
	
	public function xoapagelikeAction() {
		$store = App_Models_StoreModel::getInstance();
		$idpage = $_GET['idpage'];
		
		$sql = "delete from ishali_pages_like where idpage = '". $idpage . "'";
		$rs = $store->InsertDeleteUpdateQuery($sql);
		if($rs == 1)
		{
			$link = APP_DOMAIN . '/admin/sapxeppagelike';
			echo "<script>ThongBaoDongY('Xóa Thành Công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Xóa không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}
	}
	

	

}








































