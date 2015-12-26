if($(".error").length != 0)
{
	$(".error").css("left", ($(window).outerWidth() - $(".error").outerWidth()) / 2).show().delay(3000).fadeOut(2000);
}

function done()
{
	$("#counter").fadeIn();
}