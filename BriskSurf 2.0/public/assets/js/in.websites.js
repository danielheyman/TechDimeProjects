$(".graph").click(function(e) {
	e.preventDefault();
	$("#modal .modal-title").html('Website Stats');
	$("#modal .modal-body p").html("<iframe scrolling='no' style='border:none; width:100%; height: 720px; overflow:hidden;' src='" + $(this).prop("href") + "'/>" );
	$("#modal .modal-footer").html('<a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-primary">Close</a>')
	$('#modal').modal();
});

$("#open-quick-assign").click(function(e) {
	e.preventDefault();
	if($(this).html() == "Open Quick Assign") $(this).html("Close Quick Assign");
	else $(this).html("Open Quick Assign");
	$("#quick-assign").toggleClass("hidden");
});

$(".website_url").mousemove(function(e) {
	if(e.pageX > $(this).offset().left + $(this).outerWidth()) $(this).find("a").css("width", "200px");
	else $(this).find("a").css("width", "auto");
});

$(".website_url").mouseout(function() {
	$(this).find("a").css("width", "200px");
});