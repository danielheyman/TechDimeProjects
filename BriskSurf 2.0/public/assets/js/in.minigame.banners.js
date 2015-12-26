function init() {
	var height = ($(window).outerHeight() - $(".header-8-sub").outerHeight() - 30) / Math.ceil($(".banners .col-sm-6").length / 2);
	if(height < 65) height = 65;
	if(height > 80) height  = 80;
	margintop = (height - 60) / 2;

	$(".banners .col-sm-6").height(height - margintop);
	$(".banners .col-sm-6").css("margin-top", margintop);

	if($(window).outerWidth() <= 500 * 2)
	{
		$(".banners .col-sm-6").addClass("width-100");
		$(".banners .col-sm-6").css("text-align", "center");
	}
	else
	{
		$(".banners .col-sm-6").removeClass("width-100");
		$(".banners .col-sm-6:even").css("text-align", "right");
		$(".banners .col-sm-6:odd").css("text-align", "left");
	}
}
init();

$(window).resize(function() {
	init();
});

var banner = false;

$(".banners .banner").mouseenter(function() {
	banner = $(this);
	$("#overlay").height($(this).outerHeight());
	$("#overlay").width($(this).outerWidth());
	$("#overlay .image").attr("src", $(this).attr("link"));
	$("#overlay .select").html($(this).hasClass("selected") ? "Unpick Me" : "Pick Me");
	$("#overlay .select, #overlay .visit").css("line-height", ($(this).outerHeight()) + "px");
	$("#overlay").css("left", $(this).offset().left);
	$("#overlay").css("top", $(this).offset().top);
	$("#overlay").show();
});

$("#overlay .select").click(function(e) {
	e.preventDefault();
	if($(".banner.selected").length == counter && !banner.hasClass("selected")) return;

	banner.toggleClass("selected");
	$("#overlay .select").html(banner.hasClass("selected") ? "Unpick Me" : "Pick Me");

	if($(".banner.selected").length == counter)
	{
		var ids = "";
		$(".banner.selected").each(function() {
			if(ids != "") ids += ",";
			ids += $(this).attr("id");
		});

		$("input[name=banner_ids]").val(ids);
		$("#continue").show();
		$("#overlay").hide();
		$("#counter").hide();
	}
	else
	{
		$("#counter").show();
		$("#counter").html((counter - $(".banner.selected").length) + " left");
		$("#continue").hide();
		$("#overlay").hide();
	}
});

$("#overlay").mouseleave(function() {
	$("#overlay").hide();
});

$("body").hover(function() {
	$("#overlay").hide();
});