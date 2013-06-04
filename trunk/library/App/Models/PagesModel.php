<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleModel
 *
 * @author root
 */
class App_Models_PagesModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_PagesModel();
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
	
	public function getInfoPage($idpage)
	{
		$sql = "select * from ishali_pages where id_fb_page = '". $idpage ."'";
		$data = $this->SelectQuery($sql);
		return $data;
	}
	
	public function getList($idUserFB)
	{
		$sql = "select id_pages, id_fb_page, page_name, date_create FROM ishali_pages where an_hien = 1 and id_fb = '". $idUserFB ."'";
		$data = $this->SelectQuery($sql);
		return $data;
	}
	
	
	
}

