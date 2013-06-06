function chuyenTrang(link)
{
	//alert(link);
	$.ajax({
		//url: taaa.appdomain + '/index/luotlikeuser',
		url:'/appfb/ishalilikepage/index/luotlikeuser',
		type:'post',
		data:{},
		success:function(data){
			top.location.href = link;
		}
	});
}

function danglentuong(title, cap, des, link, pic) {
	FB.ui(
	  {
		method: 'feed',
		name: title,
		link: link,
		caption: cap,
		picture: pic,
		message: 'Message',
		description: des
	  }
	);
}