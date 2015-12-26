$("#save").click(function() {
	$("#saveform input[name=action]").val($("#action").val());
	var filter = [];
	$(".filter").each(function() {
		var inner_filter = [];
		$(this).find(".list").each(function() {
			inner_filter.push($(this).attr("value"));
		});
		filter.push(inner_filter);
	});
	$("#saveform input[name=filters]").val(JSON.stringify(filter));
	var results = [];
	$(".email").each(function() {
		results.push(["email", $(this).attr("value"), $(this).find("select").val()]);
	});
	$(".notification").each(function() {
		results.push(["notification", $(this).attr("value"), $(this).find("select").val()]);
	});
	$("#saveform input[name=results]").val(JSON.stringify(results));
	$("#saveform").submit();
});

$("#delete").click(function() {
	var del = prompt("Enter the words 'Delete Me'");
	if (del != null && del == "Delete Me") {
	    	$("#deleteform").submit();
	}
});

$("#add_email").click(function() {
	$(this).parents("tr").before('<tr value="new" class="email"><td class="auto">New Email</td><td><select><option value="draft">Draft</option><option value="auto">Automatic</option><option value="off">Off</option></select></td><td>0</td><td>0</td><td><a href="javascript:void(0);" class="delete_email">Delete</a></td></tr>');
	init_email_and_notification();
});

$("#add_notification").click(function() {
	$(this).parents("tr").before('<tr value="new" class="notification"><td class="auto">New Notification</td><td><select><option value="auto">Automatic</option><option value="off" selected>Off</option></select></td><td>0</td><td><a href="javascript:void(0);" class="delete_notification">Delete</a></td></tr>');
	init_email_and_notification();
});

init_email_and_notification();

function init_email_and_notification()
{
	$(".delete_email, .delete_notification").click(function() {
		$(this).parents("tr").remove();
	});
}

var target = false;

$("#actions div").click(function() {
	console.log($(this).attr("value"));
	if(target.find("div[value=" + $(this).attr("value") + "]").length == 0)
		target.append('<div class="list" value="' + $(this).attr("value") + '"><div class="inner"><div class="filter_name">' + $(this).html() + '</div><div class="delete">X</div></div></div>');
	init();
});

$(window).click(function(e) {
	if(!$(e.target).hasClass("filter_inner") && $(e.target).attr("id") != "and")
	{
		if($("#actions").css("display") != "none")
		{
			$("#actions").hide();
			if(target.find(".list").length == 0) target.parents(".filter").remove();
		}
	}
});

$("#and").click(function() {
	$(".filters").append('<div class="filter"><div class="filter_inner"></div></div>');
	init();
	$(".filter:last .filter_inner").click();
});

function init()
{
	$(".filter").addClass("and");
	$(".filter:first").removeClass("and");

	$(".filter_inner").click(function(e) {
		if($(e.target).hasClass("filter_inner"))
		{
			target = $(this);
			$("#actions").css("top", $(this).offset().top + 36);
			$("#actions").show();
		}
	});

	$(".filter .delete").click(function() {
		if($(this).parents(".filter").find(".list").length == 1) $(this).parents(".filter").remove();
		else $(this).parents(".list").remove();
		init();
	});
}
init();