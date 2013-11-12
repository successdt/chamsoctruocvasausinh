function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value + ";domain=;path=/";
}
jQuery(document).ready(function($){
	$(".layout_picker_content .layout_picker_layout_list a").click(function(event){
		event.preventDefault();
		$(".layout_picker_content .layout_picker_layout_list a").removeClass("selected");
		$(this).addClass("selected");
		$(".site_container").removeClass("layout_picker_no_transition");
		if($(this).attr("id")=="layout_picker_bx")
		{
			$(".site_container").addClass("boxed");
			setCookie("mc_layout", "boxed");
		}
		else
		{
			$(".site_container").removeClass("boxed");
			setCookie("mc_layout", "");
		}
		
		var steps = 11;
		var idSliderInt = setInterval(function(){
			steps--;
			$(".slider").trigger("updateSizesCustom");
			if(steps==0)
				clearInterval(idSliderInt);
		}, 100);
	});
});