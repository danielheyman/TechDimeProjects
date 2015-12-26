$("#hours, #days").each(function() {
	var value = $(this).find("input[type=hidden]").val().split(",");
	if(value != "")
	{
		$(this).find("button").each(function() {
			if(value.indexOf($(this).html().toLowerCase()) > -1)
			{
				$(this).removeClass("btn-primary");
				$(this).addClass("btn-danger");
			}
		});
	}
});

$(".enabled-description button").click(function(e) {
	e.preventDefault();
});

$("#enabled").click(function(e) {
	e.preventDefault();
	if($(this).html() == "Rotating")
	{
		$("input[name=enabled]").val(0);
		$(this).css("color", "#e74c3c");
		$(this).html("Paused");
	}
	else
	{
		$(this).css("color", "#1abc9c");
		$("input[name=enabled]").val(1);
		$(this).html("Rotating");
	}
});

$("#hours button, #days button").click(function(e) {
	e.preventDefault();
	if(!targeting)
	{
		$("#modal .modal-title").html('Targeting');
		$("#modal .modal-body p").html("Sorry, you must be upgraded to target your ads. Click  <a href='" + url + "'>here</a> to view upgrades." );
		$("#modal .modal-footer").html('<a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-primary">Close</a>')
		$('#modal').modal();
		return;
	}
	if($(this).hasClass("btn-primary"))
	{
		$(this).removeClass("btn-primary");
		$(this).addClass("btn-danger");
	}
	else
	{
		$(this).removeClass("btn-danger");
		$(this).addClass("btn-primary");
	}
	var disabled = [];
	$(this).parent().find(".btn-danger").each(function() {
		disabled.push($(this).html().toLowerCase());
	});
	$(this).parent().find("input[type=hidden]").val(disabled.join(","));
});