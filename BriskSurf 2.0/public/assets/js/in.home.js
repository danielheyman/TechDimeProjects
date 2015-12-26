function init_deals()
{
	var element = $(".deal[name=" + $(".circle.active").attr("name") + "]");
	var done = false;
	$(".deal").each(function() {
		if( $(this).css("display") == "block")
		{
			var height = $(this).height();
			$(this).animate({ "height": element.outerHeight(), "opacity": 0 }, 300, function() {
				element.fadeIn(300);
				$(this).hide();
				$(this).css("opacity", "1");
				$(this).height( height );
			});
			done = true;
		}
	});
	if(!done) element.show();
}

function change()
{
	changing = true;
	if( $(".circle.active").next().length == 0)
	{
		$(".circle").first().click();
	}
	else $(".circle.active").next().click();
	changing = false;
}

var changing = false;
var changer = setInterval(change, 5000);

$(".circle").click(function() {
	if(!changing) clearInterval(changer);
	$(".circle").removeClass("active");
	$(this).addClass("active");
	init_deals();
	//if(!changing) changer = setInterval(change, 5000);
});
init_deals();