
$("#tasks").click(function() {
	if($(window).width() <= 1500) $("#tasks_sidebar").toggleClass('pop');
});

$("#tasks_menu").click(function() {
	if($(window).width() <= 1500) $("#tasks_sidebar").toggleClass('pop');
});

$("#messages").click(function() {
	if($(window).width() <= 1500) $("#messages_sidebar").toggleClass('pop');
});

$("#notifications_menu").click(function() {
	if($(window).width() <= 1500) $("#messages_sidebar").toggleClass('pop');
});

var index = 0;

$("#messages_sidebar .item").click(function(e) {
	if($(e.target).hasClass("seen")) return;
	if($(this).find(".type_data").length != 0)
	{
		if($(this).find(".type_data").attr("value") == "link")
		{
			window.location.href = $(this).find(".type_data").attr("srcdoc");
		}
		else
		{
			$("#modal .modal-title").html($(this).find(".type_data_title").attr("srcdoc"));
			$("#modal .modal-body p").html($(this).find(".type_data").attr("srcdoc"));
			$("#modal .modal-footer").html('<a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-default">Close</a><a href="javascript:return false;" class="btn btn-wide btn-primary seen">Mark Seen</a>');
			index = $(this).index();
			$("#modal .seen").click(function() {
				$("#modal").modal("hide");
				seenNotification($($("#messages_sidebar .item").get(index)));
			});
			$('#modal').modal();
		}
	}
});

$(".seen").click(function(e) {
	e.preventDefault();
	seenNotification($(this).parents(".item"));
});

function seenNotification(element)
{
	element.find(".seen").hide();
	$.ajax({
                    	type: "POST",
                    	url : element.attr("url"),
                    	data : 'id=' + element.attr("id"),
                    	success : function(data){
                        	if(data.notification_id)
                        	{
                        		$("#" + data.notification_id).remove();
                        		if($("#messages_sidebar .item").length == 1)
                        		{
                        			$("#messages_sidebar .caughtup").removeClass("hidden");
                        		}
                        	}
                        	else
                        	{
                        		$("#" + data.notification_id).find(".seen").show();
                        	}
                    }
        	},"json");
}