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
		$status = 0;
		
		@$file=$_FILES['banner'];
		if($file['name']!="")//Neu nhu NSD co upload file
		{
			$tenhinh = "";
			$tenhinh=time().'_'.$file['name'];
			move_uploaded_file($file['tmp_name'],'application/layouts/tmplikepage/images/noidung/'.$tenhinh);
			$linkhinh = APP_DOMAIN . '/application/layouts/tmplikepage/images/noidung/' . $tenhinh;
			$status = 1;//Co Uphinh
		}
		else
		{
			if($_POST['linkhinh'] == "")
			{
				$linkhinh = "";
				$status = 2;//Ko Uphinh va Ko thay doi Link hinh
			}
			else
			{
				$linkhinh = $_POST['linkhinh'];
				$status = 3;//Ko Uphinh va Co thay doi Link hinh
			}
		}

		$tieude = $_POST['tieude'];
		$mota = $_POST['mota'];
		$caption = $_POST['caption'];
		$linktintuc = $_POST['linktintuc'];
		
		if($status == 2)
		{
			$sql = "update ishali_noidung_chiase set ";
			$sql.= "tieude = '". $tieude ."', ";
			$sql.= "mota = '". $mota ."', ";
			$sql.= "caption = '". $caption ."', ";
			$sql.= "linktintuc = '". $linktintuc ."' ";
			$sql.= "where idnoidung = '". $idnoidung ."'";
			
		}
		if($status == 1)
		{
			$sql = "Select tenhinh from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
			$bn = $store->SelectQuery($sql);
			if($bn[0]['tenhinh'] != "")
			{
				$tenhinh_old = $bn[0]['tenhinh'];
				if(file_exists('application/layouts/tmplikepage/images/noidung/'.$tenhinh_old))
				{
					unlink('application/layouts/tmplikepage/images/noidung/'.$tenhinh_old);
				}
			}
			
			$sql = "update ishali_noidung_chiase set ";
			$sql.= "tieude = '". $tieude ."', ";
			$sql.= "mota = '". $mota ."', ";
			$sql.= "caption = '". $caption ."', ";
			$sql.= "linktintuc = '". $linktintuc ."', ";
			$sql.= "hinhanh = '". $linkhinh ."', ";
			$sql.= "tenhinh = '". $tenhinh ."' ";
			$sql.= "where idnoidung = '". $idnoidung ."'";
		}
		if($status == 3)
		{
			$sql = "Select tenhinh from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
			$bn = $store->SelectQuery($sql);
			if($bn[0]['tenhinh'] != "")
			{
				$tenhinh_old = $bn[0]['tenhinh'];
				if(file_exists('application/layouts/tmplikepage/images/noidung/'.$tenhinh_old))
				{
					unlink('application/layouts/tmplikepage/images/noidung/'.$tenhinh_old);
				}
			}
			
			$sql = "update ishali_noidung_chiase set ";
			$sql.= "tieude = '". $tieude ."', ";
			$sql.= "mota = '". $mota ."', ";
			$sql.= "caption = '". $caption ."', ";
			$sql.= "linktintuc = '". $linktintuc ."', ";
			$sql.= "hinhanh = '". $linkhinh ."', ";
			$sql.= "tenhinh = '' ";
			$sql.= "where idnoidung = '". $idnoidung ."'";
		
		}

		$data = $store->InsertDeleteUpdateQuery($sql);
		if($data == 1)
		{
			$link = ROOT_DOMAIN . '/admin/noidungchiase';
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

		$tenhinh = "";
		@$file=$_FILES['banner'];
		if($file['name']!="")//Neu nhu NSD co upload file
		{
			$tenhinh=time().'_'.$file['name'];
			move_uploaded_file($file['tmp_name'],'application/layouts/tmplikepage/images/noidung/'.$tenhinh);
			$linkhinh = APP_DOMAIN . '/application/layouts/tmplikepage/images/noidung/' . $tenhinh;
		}
		else
		{
			if($_POST['linkhinh'] == "")
			{
				$linkhinh = "";
			}
			else
			{
				$linkhinh = $_POST['linkhinh'];
			}
		}
		
		$tieude = $_POST['tieude'];
		$mota = $_POST['mota'];
		$caption = $_POST['caption'];
		$linktintuc = $_POST['linktintuc'];
		

		$sql = "insert into ishali_noidung_chiase(tieude, mota, hinhanh, tenhinh, caption, linktintuc) ";
		$sql.= "value('$tieude', '$mota', '$linkhinh', '$tenhinh', '$caption', '$linktintuc')";
		
		//echo $sql;
		
		$data = $store->InsertDeleteUpdateQuery($sql);
		if($data == 1)
		{
			$link = ROOT_DOMAIN . '/admin/noidungchiase';
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
		
		$sql = "Select tenhinh from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
			$bn = $store->SelectQuery($sql);
			
			if($bn[0]['tenhinh'] != "")
			{
				$tenhinh = $bn[0]['tenhinh'];
				if(file_exists('application/layouts/tmplikepage/images/noidung/'.$tenhinh))
				{
					unlink('application/layouts/tmplikepage/images/noidung/'.$tenhinh);
				}
			}
		$sql = "delete from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
		$data = $store->InsertDeleteUpdateQuery($sql);
		if($data == 1)
		{
			$link = ROOT_DOMAIN . '/admin/noidungchiase';
			echo "<script>ThongBaoDongY('Xóa thành công.', '$link');</script>";	
		}
		else
		{
			echo "<script>ThongBaoDongY('Xóa không thành công<br/>Vui Lòng thực hiện lại thao tác.', '$link');</script>";
		}
		
	}
	

}








































