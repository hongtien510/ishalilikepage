// holds an instance of XMLHttpRequest 
var xmlHttp = createXmlHttpRequestObject(); 
 
// creates an XMLHttpRequest instance 
function createXmlHttpRequestObject()  
{ 
  // will store the reference to the XMLHttpRequest object 
  var xmlHttp; 
  // this should work for all browsers except IE6 and older 
  try 
  { 
    // try to create XMLHttpRequest object 
    xmlHttp = new XMLHttpRequest(); 
  } 
  catch(e) 
  { 
    // assume IE6 or older 
    var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0", 
                                    "MSXML2.XMLHTTP.5.0", 
                                    "MSXML2.XMLHTTP.4.0", 
                                    "MSXML2.XMLHTTP.3.0", 
                                    "MSXML2.XMLHTTP", 
                                    "Microsoft.XMLHTTP"); 
    // try every prog id until one works 
    for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++)  
    { 
      try  
      {  
        // try to create XMLHttpRequest object 
        xmlHttp = new ActiveXObject(XmlHttpVersions[i]); 
      }  
      catch (e) {} 
    } 
  } 
  // return the created object or display an error message 
  if (!xmlHttp) 
    alert("Error creating the XMLHttpRequest object."); 
  else  
    return xmlHttp; 
}
 // HAM XU LY CHINH

 function has_added_app(pageid, pagename, userid, appid)
 {
 
//	 alert(taaa.appdomain);

	 document.getElementById('loading').style.display='block';
//	 document.getElementById('title_pages').innerHTML= pagename;
	  var address_hasaddedapp=taaa.appdomain+"/admin/index/installpage?pageid="+pageid+"&userid="+userid+"&pagename="+pagename;
//	  var address_hasaddedapp="admin/hasaddedapp?pageid="+pageid+"&userid="+userid;
//	  alert(address_hasaddedapp);
 	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
							if(response != '1' )
							{
								var tb = "Thêm Trang '"+ pagename + "' vào ứng dụng";
								var r=confirm(tb);
								if (r==true)
								{
									//alert('da them');
									window.open("http://www.facebook.com/add.php?api_key="+appid+"&pages=1&page=" + pageid, "mywindow","menubar=1,resizable=1,width=550,height=400");
									//window.open("http://www.facebook.com/add.php?api_key="+appid+"&pages=1&page=" + pageid,'_blank');
								}
			
							}
							
//							else
//								{
//								show_page_form(pageid, pagename, userid, appid);
//								}
							show_page_form(pageid, pagename, userid, appid);
							//window.location = taaa.fbappdomain + '/admin';
							//window.open = (taaa.fbappdomain + '/admin', '_top');
							
							//location.reload();
		
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address_hasaddedapp , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}
	
 }
 
 function show_page_form(pageid, pagename, userid, appid)
 {
//	 has_added_app(pageid, pagename, userid, appid);
//	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
//	 document.getElementById('title_pages').innerHTML= pagename;
	  var address=taaa.appdomain+"/admin/showpageform?pageid="+pageid+"&userid="+userid+"&appid="+appid;
//	  alert(address);
 	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
//							if(response != '1' )
//							{
//								var tb = "Thêm Trang '"+ pagename + "' vào ứng dụng";
//								var r=confirm(tb);
//								if (r==true)
//							  {
//									//alert('da them');
//								window.open("http://www.facebook.com/add.php?api_key="+appid+"&pages=1&page=" + pageid, "mywindow","menubar=1,resizable=1,width=550,height=400");
//							  }
//			
//							}
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
 }
 
 function inputpageonload( selectname, userid, appid)
 {
	 var i = document.getElementById(selectname).selectedIndex;
	 var pageid = document.getElementById(selectname).value;
	 var pagename = document.getElementById(selectname).options[i].text;
	 has_added_app(pageid, pagename, userid, appid);
//	 alert(pagename);
 }
 
 
function doihinh(tenhinh)
{
// alert(tenhinh);
document.getElementById("img_giaodien").src='public/images/giaodien/'+tenhinh;
}

function show_list_article(pageid, pagename)
{
	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
	  var address=taaa.appdomain+"/admin/article/index?pageid="+pageid+'&pagename='+pagename;
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


function add_article(pageid, pagename, articleid)
{
//	CKEDITOR.replace('noi_dung', {
//        toolbar: 'Content'
//    });
//	
	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
	  var address=taaa.appdomain+"/admin/article/add?pageid="+pageid+'&pagename='+pagename+'&articleid='+articleid;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
							editor_noi_dung();
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}

function chucnang_article(type, pageid, pagename, articleid)
{
	if(type=='edit')
		{
			add_article(pageid, pagename, articleid);	
		}else 
			if(type=='del'){
			delete_article(pageid, pagename, articleid);
		}
}

function delete_article(pageid, pagename, articleid)
{
	var r=confirm("Bạn chắc chắn muốn xóa bài viết này");
	if (r==false)
	  {
			return false;
	  }
	
	document.getElementById('loading').style.display='block';
	document.getElementById('quanlidanhsachtrang').style.display='none';
	var address=taaa.appdomain+"/admin/article/delete?&articleid="+articleid;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							window.top.location = taaa.fbappdomain+'/admin/article';
						//	window.top.location = 'http://apps.facebook.com/tochuccuocthihinh/admin/article';
//							alert(response);
//							document.getElementById('show_pages').innerHTML=response;
//							document.getElementById('loading').style.display='none';
							show_list_article(pageid, pagename)
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


/***************/
/* Thí sinh */

function show_list_thisinh(pageid, pagename)
{
	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
	  var address=taaa.appdomain+"/admin/thisinh/index?pageid="+pageid+'&pagename='+pagename;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
							 common.renderPagingSearch('paging_ajax', 'trang trước', 'trang sau', 'Trang đầu', 'Trang cuối', ' ');
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


function add_thisinh(pageid, pagename, thisinhid)
{
	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
	  var address=taaa.appdomain+"/admin/thisinh/add?pageid="+pageid+'&pagename='+pagename+'&thisinhid='+thisinhid;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
							editor_gioi_thieu();
							editor_mo_ta_bai_thi();
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}

function chucnang_thisinh(type, pageid, pagename, thisinhid)
{
	if(type=='edit')
		{
			add_thisinh(pageid, pagename, thisinhid);	
		}else 
			if(type=='del'){
			delete_thisinh(pageid, pagename, thisinhid);	
		}else 
			if(type=='detail'){
				detail_thisinh(pageid, pagename, thisinhid);	
			}else 
				if(type=='binhchon'){
					show_list_binhchon(pageid, pagename, thisinhid);	
				}
	
	
	
}


function delete_thisinh(pageid, pagename, thisinhid)
{
	var r=confirm("Bạn chắc chắn muốn xóa thí sinh này");
	if (r==false)
	  {
			return false;
	  }

	
	document.getElementById('loading').style.display='block';
	document.getElementById('quanlidanhsachtrang').style.display='none';
	var address=taaa.appdomain+"/admin/thisinh/delete?thisinhid="+thisinhid;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
//							window.top.location = taaa.fbappdomain+'/admin/thisinh';
						//	window.top.location = 'http://apps.facebook.com/tochuccuocthihinh/admin/article';
							
//							document.getElementById('show_pages').innerHTML=response;
//							document.getElementById('loading').style.display='none';
							show_list_thisinh(pageid, pagename)
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


function updatestatus_thisinh(status, idthisinh)
{
//	document.getElementById('loading').style.display='block';
//	document.getElementById('quanlidanhsachtrang').style.display='none';
	var address=taaa.appdomain+"/admin/thisinh/updatestatus?status="+status+"&idthisinh="+idthisinh;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
//							window.top.location = taaa.fbappdomain+'/admin/thisinh';
						//	window.top.location = 'http://apps.facebook.com/tochuccuocthihinh/admin/article';
							
							document.getElementById('an_hien_thisinh_'+idthisinh).innerHTML=response;
//							document.getElementById('loading').style.display='none';
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


function detail_thisinh(pageid, pagename, thisinhid)
{
	document.getElementById('loading').style.display='block';
	document.getElementById('quanlidanhsachtrang').style.display='none';
	var address=taaa.appdomain+"/admin/thisinh/detail?thisinhid="+thisinhid+"&page_name="+pagename;
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
//							window.top.location = taaa.fbappdomain+'/admin/thisinh';
						//	window.top.location = 'http://apps.facebook.com/tochuccuocthihinh/admin/article';
							
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
//							show_list_thisinh(pageid, pagename)
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}



function editor_noi_dung()
{
	CKEDITOR.replace('noi_dung', {
		  toolbar: 'Content'
		});
}

function editor_gioi_thieu()
{
	CKEDITOR.replace('gioi_thieu', {
		  toolbar: 'Content'
		});
}

function editor_mo_ta_bai_thi()
{
	CKEDITOR.replace('mo_ta_bai_thi', {
		  toolbar: 'Content'
		});
}


function show_list_binhchon(pageid, pagename, thisinhid)
{
	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
	  var address=taaa.appdomain+"/admin/thisinh/binhchon?pageid="+pageid+'&pagename='+pagename+"&thisinhid="+thisinhid+"&isajax=1";
//	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
//							alert(response);
							var searchpage = "pageid="+pageid+'&pagename='+pagename+"&thisinhid="+thisinhid;
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
							 common.renderPagingSearch('paging_ajax_bc', 'trang trước', 'trang sau', 'Trang đầu', 'Trang cuối', searchpage);
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


function moithamgia(pageid, pagename)
{
	 document.getElementById('loading').style.display='block';
	 document.getElementById('quanlidanhsachtrang').style.display='none';
	  var address=taaa.appdomain+"/admin/moithamgia/index?pageid="+pageid+'&pagename='+pagename;
	  alert(address);
	if(xmlHttp)
	{
		try
		{
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4)  { 
				    if (xmlHttp.status == 200) {
						try {
							var response = xmlHttp.responseText;
							alert(response);
							document.getElementById('show_pages').innerHTML=response;
							document.getElementById('loading').style.display='none';
						}
						catch(e){
							alert("Error reading the response: " + e.toString());
						}
					}
				}
			}			
			xmlHttp.open("GET",address , true);
			xmlHttp.send(null);		
		}
		catch(e)
		{
			alert("Không thể try câp server: " + e.toString()); 
		}
	}	
}


