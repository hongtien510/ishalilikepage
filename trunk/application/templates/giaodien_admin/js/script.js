	
$(document).ready(function(){
    
	if(getParameterValue('result') == 1)
		ThongBao("Thêm mới thành công",2000);
	if(getParameterValue('result') == 2)
		ThongBao("Chỉnh sửa thành công",2000);
	if(getParameterValue('result') == 3)
		ThongBao("Xóa thành công",2000);
        
  
    $('.dangxuatadmin').click(function(){
        alert('bb');
        /*
        $.ajax({
		url:taaa.appdomain + '/admin/loginadmin/xulydangxuat',
		type:'post',
		data:{},
		success:function(data){
		  //alert(data);
            alert("Đăng xuất thành công");
            window.location="../admin";
		}
	   });
       */	
    });
    
    $('.close_thongbao').live('click',function(){
        $('#thongbao').hide(); 
        $('#bg_thongbao').hide();
    });
	
	$('.close_thongbao2').live('click',function(){
		$('#thongbao').hide(); 
        $('#bg_thongbao').hide();
		var link = taaa.appdomain+'/admin/login/';
		window.location = link;
    });
	
	$('.close_thongbao3').live('click',function(){
		$('#thongbao').hide(); 
        $('#bg_thongbao').hide();
		var link = taaa.appdomain+'/admin/config/';
		window.location = link;
    });

});

function ChangeListPage(idpage)
{
	if(idpage != 0)
		window.location = "?idpage="+idpage;
}

/*
function LoginAdmin(ops)
{
    UserAdmin = ops.useradmin;
    PassAdmin = ops.passadmin;
    
    //alert(UserAdmin);
    //alert(PassAdmin);
    
    $.ajax({
		url:taaa.appdomain + '/admin/login/xulylogin',
		type:'post',
		data:{useradmin: UserAdmin, passadmin:PassAdmin},
		success:function(data){
			if(data==1)
            {
                alert("Đăng nhập thành công");
				var link = taaa.appdomain+'/admin/category/';
				window.location = link;
            }
            else
                alert("Đăng nhập không thành công");
		}
	});	
}
*/

function checkmail(email){
	var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
	var returnval=emailfilter.test(email)
	return returnval;
}

//Kiem tra SDT
function checkphone(phone)
{
	if(phone.length<10)
		return false;
	var phonefilter = /^[0-9]+$/;
	var returnval = phonefilter.test(phone);
		return returnval;
}




function RegisterAdmin(ops)
{

	IdUserFb = ops.iduser_fb;
	UserAdmin = ops.useradmin;
    PassAdmin = ops.passadmin;
    RePassAdmin = ops.repassadmin;
    HoTenAdmin = ops.hotenadmin;
    EmailAdmin = ops.emailadmin;
    DienThoaiAdmin = ops.dienthoaiadmin;
	

    //alert(UserAdmin);
    // alert(PassAdmin);
    // alert(RePassAdmin);
    // alert(HoTenAdmin);
    // alert(EmailAdmin);
    // alert(DienThoaiAdmin);

	if(UserAdmin=="" || PassAdmin=="" || RePassAdmin=="" || HoTenAdmin=="" || EmailAdmin=="" || DienThoaiAdmin=="")
	{
		document.getElementById('warning_register').innerHTML = "Vui lòng nhập đủ thông tin.";
		return false;
	}
	else
	{
		if(PassAdmin.length < 6)
		{
			document.getElementById('warning_register').innerHTML = "Mật khẩu nhập tối thiểu 6 ký tự.";
			return false;
		}
		else
			if(PassAdmin != RePassAdmin)
			{
				document.getElementById('warning_register').innerHTML = "2 mật khẩu không giống nhau.";
				return false;
			}
			else
				if(checkmail(EmailAdmin)==false)
				{
					document.getElementById('warning_register').innerHTML = "Email chưa đúng định dạng.";
					return false;
				}
				else
					if(checkphone(DienThoaiAdmin)==false)
					{
						document.getElementById('warning_register').innerHTML = "Số điện thoại chưa đúng định dạng.";
						return false;
					}
					else
					{
						document.getElementById('warning_register').innerHTML = "";
					}
	}
	
	kiemtraTenDangNhap(UserAdmin);

}

function kiemtraTenDangNhap(UserName)
{

	$.ajax({
		url:taaa.appdomain + '/admin/register/kiemtratendangnhap',
		type:'post',
		data:{username: UserName},
		success:function(data){
			if(data==0)
			{
				document.getElementById('warning_register').innerHTML = "Tên đăng nhập này đã có người đăng ký.";
				return false;
			}
			else
			{
				$.ajax({
				url:taaa.appdomain + '/admin/register/xulyregister',
				type:'post',
				data:{iduserfb:IdUserFb, useradmin: UserAdmin, passadmin:PassAdmin, hotenadmin:HoTenAdmin, emailadmin:EmailAdmin, dienthoaiadmin:DienThoaiAdmin},
				success:function(data){
						if(data==1)
						{
							ThongBaoLoi2("Đăng ký thành công");
						}
						else
							ThongBaoLoi("Đăng ký không thành công");
					}
				});

			}
			
		}
	});

}

function kiemtraIdUserFB(IdUserFB)
{
	$.ajax({
		url:taaa.appdomain + '/admin/register/kiemtraiduserfb',
		type:'post',
		data:{IdUserFB: IdUserFB},
		success:function(data){
			if(data!=1)
            {
				ThongBaoLoi2("IDFB : "+data+"<br/>Tài khoản FB này đã tạo tài khoản<br/>Nếu bạn quên mật khẩu hãy liên hệ với Admin");
            }
		}
	});
}




function getParameterValue(name)
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null ) return "";
	else return results[1];
}


function ThongBao(nd,time)
{
	$('#bg_thongbao').show();
	$('#thongbao').show();
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'>"+nd+"</div>");
	myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}

function ThongBaoLoi(nd)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao close_thongbao'>Đóng</p>");
	//myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}

function ThongBaoLoi2(nd)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao close_thongbao2'>Đóng</p>");
	//myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}

function ThongBaoLoi3(nd)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao close_thongbao3'>Đóng</p>");
	//myVar = setTimeout(function(){$('#thongbao').hide(); $('#bg_thongbao').hide();return false},time);
}

function ThongBaoDongY(nd, link)
{
    $('#bg_thongbao').show();
	$('#thongbao').show(); 
	$('#thongbao').html("<p class='title_tb'>Thông Báo</p><div class='content_tb'><p>" +nd+ "</p><p class='dong_thongbao' onclick=\"CloseThongBaoDongY('"+link+"')\">Đóng</p>");
}

function CloseThongBaoDongY(link)
{
	$('#thongbao').hide(); 
	$('#bg_thongbao').hide();
	//window.location = link;
	top.location.href = link;
}

function ThemLoaiSanPham(tenlsp, vitri, anhien)
{
    if(anhien==true) anhien=1; else anhien = 0;

    if(tenlsp=="")
    {
        ThongBaoLoi('Tên loại sản phẩm không được để trống');
        return false;
    }
    $.ajax({
        url:taaa.appdomain+'/admin/category/xulyadd',
        type:'post',
        data:{tenlsp:tenlsp, vitri:vitri, anhien:anhien},
        success:function(data){
            if(data==1)
            {
                ThongBao('Thêm mới loại sản phẩm thành công',2000);
                window.location = '../category';
            }
            else
                ThongBaoLoi('Thêm mới không thành công');
        }
        
    });

   
}

function CapNhatLoaiSanPham(idcategory, tenlsp, vitri, anhien)
{
    if(anhien==true) anhien=1; else anhien = 0;
    
    if(tenlsp=="")
    {
        ThongBaoLoi('Tên loại sản phẩm không được để trống');
        return false;
    }
    $.ajax({
        url:taaa.appdomain+'/admin/category/xulyupdate',
        type:'post',
        data:{idcategory:idcategory, tenlsp:tenlsp, vitri:vitri, anhien:anhien},
        success:function(data){
            //alert(data);
           
            if(data==1)
            {
                ThongBao('Cập nhật loại sản phẩm thành công',2000);
                
            }
            else
                ThongBaoLoi('Cập nhật không thành công');
            
        }
        
    });
}

function ThemMoiSanPham(masp, tensp, thuocloaisp, giaban, string_img_upload, string_img_upload_ch, mota, chitiet, hethang, anhien, showindex, titlefb, metafb)
{
    /*
    alert(masp);
    alert(tensp);
    alert(thuocloaisp);
    alert(giaban);
    alert(string_img_upload);
    alert(string_img_upload_ch);
    alert(mota);
    alert(chitiet);
    alert(hethang);
    alert(anhien);
    alert(showindex);
    alert(titlefb);
    alert(metafb);
    */
    if(anhien==true) anhien=1; else anhien = 0;
    if(hethang==true) hethang=1; else hethang = 0;
    if(showindex==true) showindex=1; else showindex = 0;

    
    if(tensp == "")
    {
        document.getElementById('tensp').focus();
        ThongBaoLoi('Tên sản phẩm không được để trống');
		return false;
    }
    if(thuocloaisp == 0)
    {
        document.getElementById('thuocloaisp').focus();
        ThongBaoLoi('Chọn loại sản phẩm');
		return false;
    }
    if(giaban == "")
    {
        document.getElementById('giaban').focus();
        ThongBaoLoi('Giá bán không được để trống');
		return false;
    }
    
    $.ajax({
        url:taaa.appdomain+'/admin/product/xulyadd',
        type:'post',
        data:{masp:masp, tensp:tensp, thuocloaisp:thuocloaisp, giaban:giaban ,string_img_upload:string_img_upload, string_img_upload_ch:string_img_upload_ch, mota:mota, chitiet:chitiet, hethang:hethang, anhien:anhien, showindex:showindex, titlefb:titlefb, metafb:metafb},
        success:function(data){
            if(data==1)
            {
                ThongBao('Thêm mới sản phẩm thành công',2000);
                window.location = '../product';    
            }
            else
                ThongBaoLoi('Thêm mới không thành công');
            
        }
        
    });
  
    
}


function CapNhatSanPham(idsp, masp, tensp, thuocloaisp, giaban, string_img_upload, string_img_upload_ch, mota, chitiet, hethang, anhien, showindex, titlefb, metafb)
{
    if(anhien==true) anhien=1; else anhien = 0;
    if(hethang==true) hethang=1; else hethang = 0;
    if(showindex==true) showindex=1; else showindex = 0;
    /*
    alert(masp);
    alert(tensp);
    alert(thuocloaisp);
    alert(giaban);
    alert(string_img_upload);
    alert(string_img_upload_ch);
    alert(mota);
    alert(chitiet);
    alert(hethang);
    alert(anhien);
    alert(showindex);
    alert(titlefb);
    alert(metafb);
    */
    
    if(tensp == "")
    {
        document.getElementById('tensp').focus();
        ThongBaoLoi('Tên sản phẩm không được để trống');
		return false;
    }
    if(thuocloaisp == 0)
    {
        document.getElementById('thuocloaisp').focus();
        ThongBaoLoi('Chọn loại sản phẩm');
		return false;
    }
    if(giaban == "")
    {
        document.getElementById('giaban').focus();
        ThongBaoLoi('Giá bán không được để trống');
		return false;
    }
    
    $.ajax({
        url:taaa.appdomain+'/admin/product/xulyupdate',
        type:'post',
        data:{idsp:idsp, masp:masp, tensp:tensp, thuocloaisp:thuocloaisp, giaban:giaban ,string_img_upload:string_img_upload, string_img_upload_ch:string_img_upload_ch, mota:mota, chitiet:chitiet, hethang:hethang, anhien:anhien, showindex:showindex, titlefb:titlefb, metafb:metafb},
        success:function(data){
            if(data==1)
            {
                ThongBao('Cập nhật sản phẩm thành công',2000);
				 window.location = taaa.appdomain+'/admin/product';
            }
            else
                ThongBaoLoi('Cập nhật không thành công');
                
            document.getElementById('string_img_upload').value = "";
            document.getElementById('string_img_upload_ch').value = "";
            //location.reload();
           
        }
        
    });
}

function DeleteProduct(idsp)
{
    var flag = confirm('Bạn có chắc chắn muốn xóa sản phẩm này');
    if(flag==true)
    {
        $.ajax({
            url:taaa.appdomain+'/admin/product/xulydelete',
            type:'post',
            data:{idsp:idsp},
            success:function(data){
               
                if(data==1)
                    ThongBao('Xóa sản phẩm thành công',2000);
                else
                    ThongBaoLoi('Xóa không thành công');
                    
                location.reload();
                
            }
            
        });
    }
    else
        return false;
}

function SearchCategory(idcat)
{
    if(idcat == -1)
    {
        return false;
    }
    if(idcat == 0)
    {
        window.location = 'product';
    }
    else
        window.location = 'product?idcat=' + idcat;
}

//Get URL
function getParameterValue(name)
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null ) return "";
	else return results[1];
}

function LoginAdmin(user, pass)
{
    //alert(user);
    //alert(pass);

    $.ajax({
        url:taaa.appdomain+'/admin/login/xulylogin',
        type:'post',
        data:{user:user, pass:pass},
        success:function(data){
            if(data==1)
            {
                ThongBao('Đăng nhập thành công',2000);
				var link = taaa.fbappdomain+'/admin/';
                //window.location = link;
				top.location.href = link;
            }
            else
            {
                ThongBaoLoi('Đăng nhập không thành công');
                return false;    
            }
        }
    });
}

function DangXuat()
{
    var flag = confirm('Bạn có chắc chắn muốn đăng xuất');
    if(flag==true)
        window.location = taaa.appdomain+'/admin/login/dangxuat';
    else
        return false;
}


function ChangePass(iduserfb, oldpass, newpass, newrepass)
{
	//alert(iduserfb);
	//alert(oldpass);
	//alert(newpass);
	//alert(newrepass);
	
	if(oldpass == "" || newpass == "" || newrepass == "")
	{
		document.getElementById('warning').innerHTML = 'Vui lòng nhập đủ thông tin.';
		return false;
	}
	else
	{
		if(newpass.length<6)
		{
			document.getElementById('warning').innerHTML = 'Mật khẩu mới tối thiểu 6 ký tự.';
			return false;
		}
		else
		{
			if(newpass != newrepass)
			{
				document.getElementById('warning').innerHTML = 'Nhập lại mật khẩu mới chưa giống nhau.';
				return false;
			}
		}
	}
	
	$.ajax({
        url:taaa.appdomain+'/admin/changepass/xulychangepass',
        type:'post',
        data:{iduserfb:iduserfb, oldpass:oldpass, newpass:newpass, newrepass:newrepass},
        success:function(data){
            if(data==-1)
			{
				document.getElementById('warning').innerHTML = 'Mật khẩu cũ chưa đúng.';
				return false;
			}
			if(data==0)
			{
				document.getElementById('warning').innerHTML = 'Đổi mật khẩu chưa thành công, vui lòng thực hiện lại thao tác.';
				return false;
			}
			if(data==1)
			{
				ThongBaoLoi2("Thay đổi mật khẩu thành công.<br/>Bạn cần phải đăng nhập lại");
				return false;
			}
			
        }
    });
	
}

function LuuThongTinSP(idsp, keytab, noidung)
{
	alert(idsp);
	alert(keytab);
	alert(noidung);
	//alert('12345679');
	//return false;
}

function customerLoadWindow(pageURL, title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}







