<?php
//$this->_SESSION=new Zend_Session_Namespace();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BangmauModel
 *
 * @author root
 */
class App_Models_PagelikeModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_PagelikeModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }

	public function getPage()
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "select id_fb_page, page_name from ishali_pages where an_hien = 1 order by id_pages desc";
		$data = $store->SelectQuery($sql);
		if(count($data)>0)
			return $data;
		else
			return "";
	}
	
	public function thongTinTrang($idpage)
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "select page_name, link_page from ishali_pages where id_fb_page = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		return $data;
	}
	
	public function xoaPageLike()
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "DELETE FROM ishali_pages_like WHERE idpagelike > 0";
		$data = $store->InsertDeleteUpdateQuery($sql);
		return $data;
	}
	
	public function luuPageLike($listPage)
	{
		$this->xoaPageLike();
		
		$store = App_Models_StoreModel::getInstance();
		for($i=0; $i<count($listPage); $i++)
		{
			$idPage = $listPage[$i];
			$info = $this->thongTinTrang($idPage);
			$namePage = $info[0]['page_name'];
			$linkPage = $info[0]['link_page'];
			
			$sql = "insert into ishali_pages_like(idpage, pagename, linkpage, thutu) values ('". $idPage ."', '". $namePage ."', '". $linkPage ."', '". ($i+1) ."')";
			$data = $store->InsertDeleteUpdateQuery($sql);
			if($data == 0)
				return 0;
		}
		return 1;
	}
	

	public function getPageLike()
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "select idpage, pagename, linkpage, thutu from ishali_pages_like order by thutu";
		$data = $store->SelectQuery($sql);
		if(count($data)>0)
			return $data;
		else
			return "";
	}

	
	public function checkPagelike($idpage)
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "select 1 from ishali_pages_like where idpage = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		if(count($data)>0)
			return 1;
		else
			return 0;
	}
	
	public function addUserLikepage($iduserfb, $idpage)
	{
		$store = App_Models_StoreModel::getInstance();
		$datenow = date("Y-m-d");
		$sql = "insert into ishali_user_like(iduserfb, idpage, datelike) values('$iduserfb', '$idpage', '$datenow')";
		$data = $store->InsertDeleteUpdateQuery($sql);
		return $data;
	}
	
	
	
	public function kiemTraSoLuongLikeUser($iduserfb)
	{
		$store = App_Models_StoreModel::getInstance();
		$datenow = date("Y-m-d");
		$sql = "select iduserlike from ishali_user_like where iduserfb = '". $iduserfb ."' and datelike = '". $datenow ."'";
		$data = $store->SelectQuery($sql);
		return count($data);
	}
	
	public function getConfig()
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "select * from ishali_config";
		$data = $store->SelectQuery($sql);
		return $data[0];
	}
	
	public function getLinkNoiDung($idnoidung)
	{
		$store = App_Models_StoreModel::getInstance();
		$idnoidung = base64_decode(base64_decode($idnoidung));
		$sql = "select linktintuc from ishali_noidung_chiase where idnoidung = '". $idnoidung ."'";
		$data = $store->SelectQuery($sql);
		if(count($data)==0)
			return "";
		else
			return $data[0]['linktintuc'];
	}
	
	public function soLuotLikeTrongNgay()
	{
		$store = App_Models_StoreModel::getInstance();
		$macAdress = $this->getMacAddress();
		$datenow = date("Y-m-d");
		
		$sql = "select iduserlike from ishali_user_like where iduserfb = '". $macAdress ."' and datelike = '". $datenow ."'";
		$data = $store->SelectQuery($sql);
		return count($data);
		
	}
	
	public function checkLikePage($idpage)
	{
		$store = App_Models_StoreModel::getInstance();
		$macAdress = $this->getMacAddress();
		$datenow = date("Y-m-d");
		$sql = "select iduserlike from ishali_user_like where iduserfb = '". $macAdress ."' and idpage = '". $idpage ."'";
		$data = $store->SelectQuery($sql);
		if(count($data)==0)
			return 1;
		return 0;
	}
	
	//Luu dia chi mac va Idpage vao page ishali_user_like
	public function luuMacAdressLikePage($idpage)
	{
		$store = App_Models_StoreModel::getInstance();
		$macAdress = $this->getMacAddress();
		$datenow = date("Y-m-d");
		
		$sql = "insert into ishali_user_like(iduserfb, idpage, datelike) values('$macAdress', '$idpage', '$datenow')";
		$data = $store->InsertDeleteUpdateQuery($sql);
		return $data;
	}
	
	
	public function getMacAddress()
	{
		ob_start(); // Turn on output buffering
		system('ipconfig /all'); //Execute external program to display output
		$mycom=ob_get_contents(); // Capture the output into a variable
		ob_clean(); // Clean (erase) the output buffer

		$findme = "Physical";
		$pmac = strpos($mycom, $findme); // Find the position of Physical text
		$mac=substr($mycom,($pmac+36),17); // Get Physical Address
		return $mac;
	}
	
	//Tra ve dia chi Mac
	public function saveUserLikeByMacId($macId, $idPage)
	{
		$store = App_Models_StoreModel::getInstance();
		$sql = "insert into ishali_user_like(iduserfb, datelike, idpage) values('$macId', now(), '$idPage')";
		$data = $store->InsertDeleteUpdateQuery($sql);
		return $data;
	}
	
	
}





























