<?php

class Admin_ConfigController extends App_Controller_AdminController {

    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
        
        $facebook = new Ishali_Facebook();
		$idpage = $facebook->getpageid();
        
        if(isset($idpage))
            $_SESSION['idpage'] = $idpage;
    }

    public function indexAction() {
        if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
		$_SESSION['list_page'] = "1";
		
		$store = $this->view->info = App_Models_StoreModel::getInstance();

		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
		
		$checkSessionIdpage = $store->KiemTraSessionIdPage($idpage);
		if($checkSessionIdpage == 0)
		{
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}
		else
		{
			$this->view->idpage = $idpage;
			
			$sql = "Select * from ishali_config where idpage = '". $idpage ."'";
			$config = $store->SelectQuery($sql);
			$this->view->config = $config;
			
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}
    }
	
	public function xulyconfigAction() {
		//$this->_helper->viewRenderer->setNoRender(true);
		//$this->_helper->layout->disableLayout();
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$banner = "";
		@$file=$_FILES['banner'];
		if($file['name']!="")//Neu nhu NSD co upload file
		{
			$banner=time().'_'.$file['name'];
			move_uploaded_file($file['tmp_name'],'public/images/banner/'.$banner);
		}

		$idpage = $_POST['idpage'];
		$footer = $_POST['footer'];
		$emailsmtp = $_POST['emailsmtp'];
		$passsmtp = $_POST['passsmtp'];
		$emailfrom = $_POST['emailfrom'];
		$titlemail = $_POST['titlemail'];
		$subjectemail = $_POST['subjectemail'];
		
		$bg_color_menu = $_POST['bg_color_menu'];
		$color_text_menu = $_POST['color_text_menu'];
		$bg_color_menu_act = $_POST['bg_color_menu_act'];
		$color_text_menu_act = $_POST['color_text_menu_act'];
		
		$donvitien = $_POST['donvitien'];
		$linkpage = $_POST['linkpage'];
		
		if(@$_POST['thongtinsp'] != "")
			$thongtinsp = @$_POST['thongtinsp'];
		else
			$thongtinsp = 0;
		$menuthongtinsp = $_POST['menuthongtinsp'];
		if($menuthongtinsp == "")
			$thongtinsp = 0;
		
		$sql = "Select 1 from ishali_config where idpage = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		
		if(count($data)==0)
		{
			if($banner == "")
			{
				$sql = "insert into ishali_config(footer, emailsmtp, passsmtp, emailfrom, title_from, subject_from, idpage, bg_color_menu, color_text_menu, bg_color_menu_act, color_text_menu_act, donvitien, thongtinsp, menuthongtinsp, link_page) ";
				$sql.= "value('$footer', '$emailsmtp', '$passsmtp', '$emailfrom', '$titlemail', '$subjectemail', '$idpage', '$bg_color_menu', '$color_text_menu', '$bg_color_menu_act', '$color_text_menu_act', '$donvitien', '$thongtinsp', '$menuthongtinsp', '$linkpage')";
			}
			else
			{
				$sql = "insert into ishali_config(banner, footer, emailsmtp, passsmtp, emailfrom, title_from, subject_from, idpage, bg_color_menu, color_text_menu, bg_color_menu_act, color_text_menu_act, donvitien, thongtinsp, menuthongtinsp, link_page) ";
				$sql.= "value('$banner', '$footer', '$emailsmtp', '$passsmtp', '$emailfrom', '$titlemail', '$subjectemail', '$idpage', '$bg_color_menu', '$color_text_menu', '$bg_color_menu_act', '$color_text_menu_act', '$donvitien', '$thongtinsp', '$menuthongtinsp', '$linkpage')";
			}
		}
		else
		{
			if($banner == "")
			{
				$sql = "Update ishali_config set ";
				$sql.= "footer = '". $footer . "', ";
				$sql.= "emailsmtp = '". $emailsmtp . "', ";
				$sql.= "passsmtp = '". $passsmtp . "', ";
				$sql.= "emailfrom = '". $emailfrom . "', ";
				$sql.= "title_from = '". $titlemail . "', ";
				$sql.= "subject_from = '". $subjectemail . "', ";
				$sql.= "bg_color_menu = '". $bg_color_menu . "', ";
				$sql.= "color_text_menu = '". $color_text_menu . "', ";
				$sql.= "bg_color_menu_act = '". $bg_color_menu_act . "', ";
				$sql.= "color_text_menu_act = '". $color_text_menu_act . "', ";
				$sql.= "donvitien = '". $donvitien . "', ";
				$sql.= "thongtinsp = '". $thongtinsp . "', ";
				$sql.= "menuthongtinsp = '". $menuthongtinsp . "', ";
				$sql.= "link_page = '". $linkpage . "' ";
				
				$sql.= "where idpage = '". $idpage ."'";
			}
			else
			{
				$sql = "Select banner from ishali_config where idpage = '". $idpage ."'";
				$bn = $store->SelectQuery($sql);
				
				if($bn[0]['banner'] != "")
				{
					$banner_old = $bn[0]['banner'];
					if(file_exists('public/images/banner/'.$banner_old))
					{
						unlink('public/images/banner/'.$banner_old);
					}
				}

				$sql = "Update ishali_config set ";
				$sql.= "banner = '". $banner . "', ";
				$sql.= "footer = '". $footer . "', ";
				$sql.= "emailsmtp = '". $emailsmtp . "', ";
				$sql.= "passsmtp = '". $passsmtp . "', ";
				$sql.= "emailfrom = '". $emailfrom . "', ";
				$sql.= "title_from = '". $titlemail . "', ";
				$sql.= "subject_from = '". $subjectemail . "', ";
				$sql.= "bg_color_menu = '". $bg_color_menu . "', ";
				$sql.= "color_text_menu = '". $color_text_menu . "', ";
				$sql.= "bg_color_menu_act = '". $bg_color_menu_act . "', ";
				$sql.= "color_text_menu_act = '". $color_text_menu_act . "', ";
				$sql.= "donvitien = '". $donvitien . "', ";
				$sql.= "thongtinsp = '". $thongtinsp . "', ";
				$sql.= "menuthongtinsp = '". $menuthongtinsp . "', ";
				$sql.= "link_page = '". $linkpage . "' ";
				
				$sql.= "where idpage = '". $idpage ."'";
			}
		}
		//echo $sql;
		
		$config = $store->InsertDeleteUpdateQuery($sql);
		if($config == 1)
		{
			echo "<script>ThongBaoLoi3('Lưu Thành Công.');</script>";	
		}
		else
		{
			echo "<script>ThongBaoLoi3('Lưu không thành công<br/>Vui Lòng thực hiện lại thao tác.');</script>";
		}
	}
    

}








































