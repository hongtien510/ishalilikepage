<?php

class Admin_IndexController extends App_Controller_AdminController {

    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
    }

    public function indexAction() {
        $facebookadmin = new Ishali_FacebookAdmin();  
        $facebook = new Ishali_Facebook();  
		$facebook->begins_works('1');
		$manage_pages =  $facebookadmin->checkpermissions('manage_pages');
		if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
        
    	
    	if ($manage_pages)
    	{
    	
		$this->view->appid = $facebook->getAppId();
	 	$this->view->fbuserid = $facebook->getuserfbid();
		$this->view->list_pages = $facebookadmin->list_pages($this->view->fbuserid, 'page');

        $this->view->pageslist = App_Models_PagesModel::getInstance()->getList2();

    	}else {
    		$facebookadmin->install();
    	}
        
    }

    public function installpageAction() {
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$pageid = $_GET['pageid'];
		$pagename = $_GET['pagename'];
		$userid = $_GET['userid'];
		$appid = $_GET['appid'];
		$status = $_GET['status'];
		$facebook = new Ishali_Facebook();
		$linkpage = $facebook->getLinkPage($pageid);
		
		if($status == 1)
		{
			$sql = "Select 1 from ishali_pages where id_fb_page = '". $pageid ."' and id_fb = '". $userid ."'";
			$data = $store->SelectQuery($sql);
			if(count($data) > 0)
			{
				echo "<script>ThongBaoDongY('Fanpage <u>$pagename</u><br/>Đã được cài thành công vào ứng dụng.', '".ROOT_DOMAIN."/admin');</script>";	
			}
			else
			{
				$link = "http://www.facebook.com/add.php?api_key=$appid&pages=1&page=$pageid";
				echo "<script>customerLoadWindow('$link', '', '540', '400');</script>";
				
				$sql = "Insert into ishali_pages(id_fb_page, page_name, id_fb, link_page, templates) value(";
				$sql.= "'".$pageid."', ";
				$sql.= "'".$pagename."', ";
				$sql.= "'".$userid."', ";
				$sql.= "'".$linkpage."', ";
				$sql.= "'tmplikepage') ";
				
				$data = $store->InsertDeleteUpdateQuery($sql);
				
				if($data == 1)
				{
					echo "<script>ThongBaoDongY('Sau khi cài ứng dụng lên FanPage thành công,<br/>Hãy nhấn nút Đóng', '".ROOT_DOMAIN."/admin');</script>";	
				}
				else
				{
					echo "<script>ThongBaoDongY('Cài ứng dụng không thành công<br/>Vui Lòng thực hiện lại thao tác.', '".ROOT_DOMAIN."/admin');</script>";
				}
			}
		}
		else
		{
			$link = "http://www.facebook.com/add.php?api_key=$appid&pages=1&page=$pageid";
				echo "<script>customerLoadWindow('$link', '', '540', '400');</script>";
			echo "<script>ThongBaoDongY('Sau khi cài ứng dụng lên FanPage thành công,<br/>Hãy nhấn nút Đóng', '".ROOT_DOMAIN."/admin');</script>";	

		}
    }
	
	public function removepageAction(){
		$page = App_Models_PagesModel::getInstance();
		$idpage = $_GET['idpage'];
		
		$data = $page->xoaTatCaThongTinPage($idpage);
		if($data == 1)
		{
			$link = ROOT_DOMAIN . '/admin';
			echo "<script>ThongBaoDongY('Xóa Thành Công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Xóa không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}

		
	}
}

