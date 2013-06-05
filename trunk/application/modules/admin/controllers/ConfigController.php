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
		$_SESSION['list_page'] = "0";
		
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$sql = "Select * from ishali_config";
		$config = $store->SelectQuery($sql);
		$this->view->config = $config;

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

		$footer = $_POST['footer'];
		$solanlike = $_POST['solanlike'];
		
		$sql = "Select 1 from ishali_config";
		$data = $store->SelectQuery($sql);
		
		if(count($data)==0)
		{
			if($banner == "")
			{
				$sql = "insert into ishali_config(footer, solanlike) ";
				$sql.= "value('$footer', '$solanlike')";
			}
			else
			{
				$sql = "insert into ishali_config(banner, footer, solanlike) ";
				$sql.= "value('$banner', '$footer', '$solanlike')";
			}
		}
		else
		{
			if($banner == "")
			{
				$sql = "Update ishali_config set ";
				$sql.= "footer = '". $footer . "', ";
				$sql.= "solanlike = '". $solanlike . "' ";
			}
			else
			{
				$sql = "Select banner from ishali_config";
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
				$sql.= "solanlike = '". $solanlike . "'";
				
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








































