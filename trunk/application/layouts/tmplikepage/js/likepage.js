function chuyenTrang(link)
{
	//alert(link);
	top.location.href = link;
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