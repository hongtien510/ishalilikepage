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