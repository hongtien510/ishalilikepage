<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontController
 *
 * @author root
 */
class App_Controller_FrontController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function preDispatch() {
        $request = $this->getRequest();
        $facebook = new Ishali_Facebook();
		
		
		/*
http://www.facebook.com/pages/HCM/448507661830693?sk=app_121397851394173&app_data=index/detail?id=109

		$pagedata  = $facebook->getpagearr();
		echo "<pre>";
		print_r($pagedata['app_data']);
		echo "</pre>";
//exit;
*/	
		
		
		
		
		
        if(isset($_GET['request_ids']))
        {
        	$ts = $_GET['request_ids'];
        }else {
        	$ts =0;
        }
		$facebook->begins_works($ts);
		
		
		
        $this->view->id_fb_page = $facebook->getpageid();
        $this->view->id_user   = $facebook->getuserfbid();
 // TODO:       
//        $this->view->id_fb_page = 123453;
//        $this->view->id_fb_page ='388347091211147';
//        $this->view->id_user = 9999;
        /*
         * get page info
         */
   
		// exit;	
         if($this->view->id_fb_page <= 0)
         {
       		   $this->view->id_fb_page =  $_SESSION['idpage'];
         }else 
         {
        	  $_SESSION['idpage'] =  $this->view->id_fb_page;
         }
         
//         echo $_SESSION['idpage'];
        $page = new App_Entities_Pages();
        $page = App_Models_PagesModel::getInstance()->getDetail($this->view->id_fb_page);
//        echo $page->an_hien;
//        exit;
//$this->_redirect('/home/index');
        if ($page->an_hien == 0) {
         //   $this->_redirect('/thongbao');
        }

//         echo $page->templates;
        /*
         * init layout
         */
        /*End thiet lap nhan tin*/
		$fb = $facebook->getFB();			
		
		if(isset($_GET['request_ids'])){                         
		 $reqId = $_GET['request_ids'];
		 $requests = $fb->api('/me/apprequests/?request_ids='.$reqId);    

		 $itemData = $requests['data'][0]['data'];
//		 echo "<pre>";
//		 print_r($requests);
//		 echo "</pre>";
//		 exit;	
		 if(isset($itemData) && $itemData !=""){
			echo "<script language='javascript'>top.location.href='" . $itemData . "'</script>";
			exit(0);
		 }else
			 if(isset($requests['data'][1]['data']) && $requests['data'][1]['data'] !=""){
				echo "<script language='javascript'>top.location.href='" . $requests['data'][1]['data'] . "'</script>";
				exit(0);
			 }else
			 if(isset($requests['data'][2]['data']) && $requests['data'][2]['data'] !=""){
				echo "<script language='javascript'>top.location.href='" . $requests['data'][2]['data'] . "'</script>";
				exit(0);
			 }
		}
		/*End thiet lap nhan tin*/
        
        
        $option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/' . $page->templates);
        Zend_Layout::startMvc($option);


        /*
         * get menu
         */
        $listMenu = App_Models_ArticleModel::getInstance()->getListByFbPage($this->view->id_fb_page);


        /*
         * assign param
         */
        $this->view->page = $page;
        $this->view->appTitle = $page->page_name;
        $this->view->appFooter = $page->footer;
        $this->view->bodystyle = "font-size:$page->font_size;";
        $this->view->bodystyle .= 'color:' . $page->color . ';';

        if ($page->background_images != null && $page->background_images != '') {
        	$page_background = APP_DOMAIN.'/public/images/background_images/'. $page->background_images;
            $this->view->bodystyle .='background-image: url(' . $page_background . ');';
        } else {
            if ($page->background_color != null && $page->background_color != '') {
                $this->view->bodystyle .='background-color:' . $page->background_color . ';';
            }
        }
        $this->view->listMenu = $listMenu;
    }

    public function postDispatch() {
        
    }

}

