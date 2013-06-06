<?php

class Admin_NoidungchiaseController extends App_Controller_AdminController {

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
		
		$sql = "select * from ishali_noidung_chiase order by idnoidung desc";
		$data = $store->SelectQuery($sql);
		$this->view->noidungchiase = $data;
		
		$pageLike = App_Models_PagelikeModel::getInstance();
		$listPageLike = $pageLike->getPageLike();
		$this->view->listPageLike = $listPageLike;
    }
	
	public function chitietAction() {
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		$idNoidung = $_GET['idnd'];
		$sql = "select * from ishali_noidung_chiase where idnoidung = '". $idNoidung ."'";
		$data = $store->SelectQuery($sql);
		$this->view->chitietnoidung = $data;
	}
	
	public function updateAction(){
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		$idnoidung = $_POST['idnd'];
		$banner = "";
		@$file=$_FILES['banner'];
		if($file['name']!="")//Neu nhu NSD co upload file
		{
			$banner=time().'_'.$file['name'];
			move_uploaded_file($file['tmp_name'],'application/layouts/tmplikepage/images/noidung/'.$banner);
		}

		$tieude = $_POST['tieude'];
		$mota = $_POST['mota'];
		$caption = $_POST['caption'];
		
		if($banner == "")
		{
			$sql = "update ishali_noidung_chiase set ";
			$sql.= "tieude = '". $tieude ."', ";
			$sql.= "mota = '". $mota ."', ";
			$sql.= "caption = '". $caption ."' ";
			$sql.= "where idnoidung = '". $idnoidung ."'";
		}
		else
		{
			$sql = "Select hinhanh from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
				$bn = $store->SelectQuery($sql);
				
				if($bn[0]['hinhanh'] != "")
				{
					$banner_old = $bn[0]['hinhanh'];
					if(file_exists('application/layouts/tmplikepage/images/noidung/'.$banner_old))
					{
						unlink('application/layouts/tmplikepage/images/noidung/'.$banner_old);
					}
				}

				$sql = "update ishali_noidung_chiase set ";
				$sql.= "tieude = '". $tieude ."', ";
				$sql.= "mota = '". $mota ."', ";
				$sql.= "caption = '". $caption ."', ";
				$sql.= "hinhanh = '". $banner ."' ";
				$sql.= "where idnoidung = '". $idnoidung ."'";
		}
		
		//echo $sql;

		$data = $store->InsertDeleteUpdateQuery($sql);
		if($data == 1)
		{
			$link = APP_DOMAIN . '/admin/noidungchiase';
			echo "<script>ThongBaoDongY('Lưu Thành Công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Lưu không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}

	}
	
	public function addAction() {
		
	}
	
	public function xulythemAction() {
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$banner = "";
		@$file=$_FILES['banner'];
		if($file['name']!="")//Neu nhu NSD co upload file
		{
			$banner=time().'_'.$file['name'];
			move_uploaded_file($file['tmp_name'],'application/layouts/tmplikepage/images/noidung/'.$banner);
		}

		$tieude = $_POST['tieude'];
		$mota = $_POST['mota'];
		$caption = $_POST['caption'];
		
		if($banner == "")
		{
			$sql = "insert into ishali_noidung_chiase(tieude, mota, caption) ";
			$sql.= "value('$tieude', '$mota', '$caption')";
		}
		else
		{
			$sql = "insert into ishali_noidung_chiase(tieude, mota, hinhanh, caption) ";
			$sql.= "value('$tieude', '$mota', '$banner', '$caption')";
		}
		
		//echo $sql;
		
		$data = $store->InsertDeleteUpdateQuery($sql);
		if($data == 1)
		{
			$link = APP_DOMAIN . '/admin/noidungchiase';
			echo "<script>ThongBaoDongY('Lưu Thành Công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Lưu không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}
	}
	
	public function deleteAction() {
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		$idnoidung = $_GET['idnd'];
		
		$sql = "Select hinhanh from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
			$bn = $store->SelectQuery($sql);
			
			if($bn[0]['hinhanh'] != "")
			{
				$banner_old = $bn[0]['hinhanh'];
				if(file_exists('application/layouts/tmplikepage/images/noidung/'.$banner_old))
				{
					unlink('application/layouts/tmplikepage/images/noidung/'.$banner_old);
				}
			}
		$sql = "delete from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
		$data = $store->InsertDeleteUpdateQuery($sql);
		if($data == 1)
		{
			$link = APP_DOMAIN . '/admin/noidungchiase';
			echo "<script>ThongBaoDongY('Xóa thành công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Xóa không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}
		
	}
	

}








































