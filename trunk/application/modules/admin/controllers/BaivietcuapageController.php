<?php

class Admin_BaivietcuapageController extends App_Controller_AdminController {

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
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$sql = "SELECT inp.id, inp.idpage, ip.page_name, inc.tieude ";
		$sql.= "FROM ishali_noidung_page inp, ishali_noidung_chiase inc, ishali_pages ip ";
		$sql.= "WHERE inp.idpage = ip.id_fb_page AND inc.idnoidung = inp.idnoidung";
		$data = $store->SelectQuery($sql);
		$this->view->baivietcuapage = $data;

		$pageLike = App_Models_PagelikeModel::getInstance();
		$listPageLike = $pageLike->getPageLike();
		$this->view->listPageLike = $listPageLike;
    }
	
	public function addAction(){
		if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		
		$sql = "SELECT ipl.idpage, ipl.pagename ";
		$sql.= "FROM ishali_pages_like ipl ";
		$sql.= "WHERE ipl.idpage NOT IN (SELECT inp.idpage FROM ishali_noidung_page inp)";
		$data = $store->SelectQuery($sql);
		$this->view->listPageLike = $data;
		
		$sql = "select * from ishali_noidung_chiase order by idnoidung desc";
		$data = $store->SelectQuery($sql);
		$this->view->noidungchiase = $data;
		
		if(isset($_POST['luunoidung']))
		{
			@$idFanpage = $_POST['fanpage'];
			if($idFanpage == "")
			{
				$link = ROOT_DOMAIN . '/admin/baivietcuapage';
				echo "<script>ThongBaoDongY('Bạn cần thêm Fanpage để tiếp tục thao tác.', '$link');</script>";	
			}
			else
			{
				$idnoidung = $_POST['baiviet'];
				$sql = "insert into ishali_noidung_page(idpage, idnoidung) values('$idFanpage', '$idnoidung')";
				$data = $store->InsertDeleteUpdateQuery($sql);
				
				$link = ROOT_DOMAIN . '/admin/baivietcuapage';
				echo "<script>ThongBaoDongY('Lưu Thành Công.', '$link');</script>";	
			}
			
		}
		
	}
	
	public function editAction(){
		if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$idpage = @$_GET['idpage'];
		$sql = "select page_name from ishali_pages where id_fb_page = $idpage";
		$data = $store->SelectQuery($sql);
		$this->view->pagename = $data[0]['page_name'];
		
		$sql = "select * from ishali_noidung_chiase order by idnoidung desc";
		$data = $store->SelectQuery($sql);
		$this->view->noidungchiase = $data;
		
		if(isset($_POST['luunoidung']))
		{
			$baiviet = $_POST['baiviet'];
			$sql = "update ishali_noidung_page set idnoidung = '$baiviet' where idpage = '$idpage'";
			$data = $store->InsertDeleteUpdateQuery($sql);
			$link = ROOT_DOMAIN . '/admin/baivietcuapage';
			echo "<script>ThongBaoDongY('Lưu Thành Công.', '$link');</script>";	
		}
	}
	
	public function deleteAction(){
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		$idpage = @$_GET['idpage'];
		$sql = "delete from ishali_noidung_page where idpage = ". $idpage;
		$data = $store->InsertDeleteUpdateQuery($sql);
		$link = ROOT_DOMAIN . '/admin/baivietcuapage';
		header("location: $link");
	}
}








































