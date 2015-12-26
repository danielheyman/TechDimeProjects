addthis.toolbox('.addthis_toolbox');
setTimeout(function() { $('.addthis_toolbox').css('display','inline-block'); addthis.addEventListener('addthis.menu.share', shareEventHandler);}, 1000);

function shareEventHandler(evt) { 
	if (evt.type == 'addthis.menu.share') { 
		social = true;
	}
}

if($(".error").length != 0)
{
	$(".error").css("left", ($(window).outerWidth() - $(".error").outerWidth()) / 2).show().delay(3000).fadeOut(2000);
}

$("#rating span").hover(function() {
	$("#rating span").css("color", "#34495e");
	$("#rating span:lt(" + ($(this).index() + 1) + ")").css("color", "#d9534f");
});

$("#rating span").click(function() {
	if($("#form input[name=rating]").length == 0) $("#form").append("<input type='hidden' name='rating' value='" + ($(this).index() + 1) + "'/>");
	$("#form button").click();
});

function count() {
	if($("#counter").html() == "1")
	{
		if(type == "hover")
		{
			$("#counter").html("GO");
			$("#counter").click(function() {
				$('#modal').modal('show');
			});
		}
		else if(type == "classic")
		{
			$("#counter").html("RATE:");
			$("#rating").show();
		}
		return;
	}
	$("#counter").html($("#counter").html() - 1);

	if(type == "hover")
	{
		$('#counter').animate({
			padding: '10px 21px 10px 68px',
			top: "24px",
			right: "24px"
		}, 100, function() {
			$('#counter').animate({
			padding: '14px 23px 14px 74px',
				top: "20px",
				right: "20px"
			}, 100);
		});
	}

	

	if($("#counter").html() == "1")
	{
		setTimeout(function() {
			$('#counter').animate({
				backgroundColor: '#2ecc71'
			}, 400);
		}, 400);
	}

	setTimeout(count, 1000);
}
setTimeout(count, 1000);