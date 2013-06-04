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
class App_Models_StoreModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_StoreModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }
	
	public function SelectQuery($sql)
	{
        $data = $this->_db->executeReader($sql);
  			return $data;
	}
    
    public function InsertDeleteUpdateQuery($sql)
	{
        $data = $this->_db->executeReader($sql); 
  			if(!isset($data))
                return 0;
            else
                return 1;
	}
    
    public function CatChuoi($str)
    {
        return explode(',', $str);
    }
    
    public function GetidCategory($idpage)
    {
        $sql = "Select idloaisp, tenloaisp ";
        $sql.= "From ishali_loaisp ";
        $sql.= "Where anhien = 1 and idpage = ". $idpage ." order by vitri";
        $data = $this->SelectQuery($sql);
        return $data;
    }
	
	public function GetPageFbByIdUserFB()
	{
		$facebook = new Ishali_Facebook();
        $iduser_fb = $facebook->getuserfbid();
		$sql = "select id_pages, id_fb_page, page_name ";
		$sql.= "from ishali_pages ";
		$sql.= "where id_fb = " . $iduser_fb;
			$lpage = $this->SelectQuery($sql);
			return $lpage;
	}

	public function GetBanner($idPage)
	{
		$sql = "select banner from ishali_config where idpage = '".$idPage."'";
		$data = $this->SelectQuery($sql);
        return $data;
	}
	
	public function GetColor($idPage)
	{
		$sql = "select bg_color_menu, color_text_menu, bg_color_menu_act, color_text_menu_act from ishali_config where idpage = '".$idPage."'";
		$data = $this->SelectQuery($sql);
		if(count($data)==0)
		{
			$color['bg_color_menu'] = "EFEFEF";
			$color['color_text_menu'] = "000000";
			$color['bg_color_menu_act'] = "3B5998";
			$color['color_text_menu_act'] = "FFFFFF";
		}
		else
		{
			if($data[0]['bg_color_menu']!="") {$color['bg_color_menu'] = $data[0]['bg_color_menu'];} else {$color['bg_color_menu'] = "EFEFEF";}
			if($data[0]['color_text_menu']!="") {$color['color_text_menu'] = $data[0]['color_text_menu'];} else {$color['color_text_menu'] = "000000";}
			if($data[0]['bg_color_menu_act']!="") {$color['bg_color_menu_act'] = $data[0]['bg_color_menu_act'];} else {$color['bg_color_menu_act'] = "3B5998";}
			if($data[0]['color_text_menu_act']!="") {$color['color_text_menu_act'] = $data[0]['color_text_menu_act'];} else {$color['color_text_menu_act'] = "FFFFFF";}
        }
		return $color;
	}
	
	public function KiemTraSessionIdPage($sessionIdPage)
	{
		$facebook = new Ishali_Facebook();
		$idUserFB = $facebook->getuserfbid();
		
		$sql = "select 1 from ishali_pages where id_fb_page = '". $sessionIdPage ."' and id_fb = '". $idUserFB ."'";
		$data = $this->SelectQuery($sql);
		return count($data);
	}
	
	//Chua su dung
	public function chuyenLinkThanhHttps($idpage)
	{
		if($_SERVER["HTTPS"] != "on")//Link ko phai la https
		{
			$facebook = new Ishali_Facebook(); 
			$fb = $facebook->getFB();
			$id_fb_page = '/'.$idpage;
			$pages_fb =  $fb->api($id_fb_page);
			$linkPage = $pages_fb['link'];//http://www.facebook.com/Phtpht
			
			$lPage = substr($linkPage,4);
			$linkHttps = 'https'.$lPage.'/app_'.APP_ID;
			return $linkHttps;
		}
		else
			return true;
	}
	
	public function getLinkPage($idpage)
	{
		$sql = "select link_page from ishali_pages where id_fb_page = '". $idpage ."'";
		$data = $this->SelectQuery($sql);
		return $data[0]['link_page'];
	}
	
}





























