$("#save").click(function() {
	var data = [];
	$(".options").each(function() {
		var inner_data = [];
		$(this).find(".section").each(function() {
			var condition = {};
			if($(this).hasClass('attribute'))
			{
				condition["type"] = "attribute";
				condition["field"] = $(this).find(".field").val();
				condition["comparison"] = $(this).find(".comparison").val();
				condition["value"] = $(this).find(".value").val();
			}
			else
			{
				condition["type"] = "action";
				condition["performed"] = $(this).find(".performed").val() == "have" ? true : false;
				condition["field"] = $(this).find(".field").val();
				condition["frequency"] = parseInt($(this).find(".frequency").val());
				condition["within"] = parseInt($(this).find(".within_value").val());
			}
			inner_data.push(condition);
		});
		data.push(inner_data);
	});
	$("#saveform input[name=data]").val(JSON.stringify(data));
	$("#saveform").submit();
});

$("#delete").click(function() {
	var del = prompt("Enter the words 'Delete Me'");
	if (del != null && del == "Delete Me") {
	    	$("#deleteform").submit();
	}
});


$(".section").each(function() {
	init_all($(this));
});


$(".and").click(function() {
	$(this).before('<div class="options"><div class="or">+ OR Filter</div></div>');
	reloadAnd();
	$(this).parent().find(".options:last .or").click();
});

$(".options").each(function() {
	reloadOr($(this));
});

reloadAnd();

$(".section:first .title").click();

function reloadOr(options)
{
	options.find(".section").addClass("orText");
	options.find(".section:first").removeClass("orText");
}

function reloadAnd()
{
	$(".options").addClass("andText");
	$(".options:first").removeClass("andText");

	$(".or").click(function() {
		$(this).before('<div class="section attribute"><div class="title"><div class="desc"></div><a class="delete" href="javascript:void();">delete</a></div><div class="inner">' 
			+ '<p>Filter users by:</p><select class="type"><option value="attribute">Attribute</option><option value="action">Action</option></select><div class="data">'
			+ $("#attribute_data").html() + '</div></div></div>');
		init_all($(this).parents(".options").find(".section:last"));
		$(this).parents(".options").find(".section:last .title").click();
		reloadOr($(this).parents(".options"));
	});
}

function init_all(section)
{
	section.find(".title").click(function() {
		if($(this).parents(".section").hasClass("show")) $(this).parents(".section").removeClass("show");
		else
		{
			$(".section").removeClass("show");
			$(this).parents(".section").addClass("show");
		}
	});

	section.find("input, select").change(function() {
		change_title($(this).parents(".section"));
	});

	section.find(".delete").click(function() {
		if($(this).parents(".options").find(".section").length == 1)
		{
			$(this).parents(".options").remove();
			reloadAnd();
		}
		else
		{
			options = $(this).parents(".options");
			$(this).parents(".section").remove();
			reloadOr(options);
		}
	});

	section.find(".type").change(function() {
		$(this).parents(".section").removeClass("action");
		$(this).parents(".section").removeClass("attribute");
		$(this).parents(".section").addClass($(this).val());

		if($(this).val() == "action") $(this).parents(".section").find(".data").html($("#action_data").html());
		else $(this).parents(".section").find(".data").html($("#attribute_data").html());

		init_all($(this).parents(".section"));
	});

	if(section.hasClass("action"))
	{
		section.find(".within").change(function() {
			init_within($(this));
		});

		init_within(section.find(".within"));
	}
	else
	{
		section.find(".field").change(function() {
			init_field($(this));
		});

		section.find(".comparison").change(function() {
			init_comparison($(this));
		});

		init_field(section.find(".field"))

	}

	change_title(section);
}

function change_title(section)
{
	if(section.hasClass("attribute"))
	{
		section.find(".title .desc").html("<b>" + section.find(".field").val() + "</b> " + section.find(".comparison").val() + " " + 
			(section.find(".value").val() != "false" ? section.find(".value").val() : '') + " " + section.find(".info").html())
	}
	else
	{
		section.find(".title .desc").html(section.find(".performed").val() + " performed the action <b>" + section.find(".field").val() + "</b> at least " + 
			section.find(".frequency").val() + " times " + section.find(".within").val() + " " + (section.find(".within_value").val() != "start" ? section.find(".within_value").val() : '') + " " + section.find(".info").html())
	}
}

function init_within(within)
{
	if(within.val() == "since signing up")
	{
		within.parent().find(".within_value").val("start");
		within.parent().find(".within_value").hide();
		within.parent().find(".info").html("");
		within.parent().find(".info").hide();
	}
	else
	{
		var value = (within.parent().find(".within_value").attr("default") != undefined) ? within.parent().find(".within_value").attr("default") : "30";
		if(value != '30') within.parent().find(".within_value").removeAttr("default");

		within.parent().find(".within_value").val(value);
		within.parent().find(".within_value").show();
		within.parent().find(".info").html(" days");
		within.parent().find(".info").show();
	}
	change_title(within.parents(".section"));
}

function init_field(field)
{
	var type = field.find("option[value=" + field.val() + "]").attr("type");
	if(type == "string") comparisons = ["is equal to", "is not equal to"];
	else if(type == "bool") comparisons = ["is true", "is false"];
	else if(type == "number") comparisons = ["is equal to", "is not equal to", "is greater than", "is less than"];
	else if(type == "date") comparisons = ["is a timestamp after", "is a timestamp before"];
	else comparisons = [];
	comparisons.push("exists");
	comparisons.push("does not exist");

	var comparisons_string = "";
	for(var i in comparisons)
	{
		var selected = (field.parent().find(".comparison").attr("default") == comparisons[i]) ? 'selected' : '';
		comparisons_string += "<option " + selected + ">" + comparisons[i] + "</option>";

		if(selected != '') field.parent().find(".comparison").removeAttr("default");
	}

	field.parent().find(".comparison").html(comparisons_string);

	init_comparison(field.parent().find(".comparison"));

	change_title(field.parents(".section"));
}

function init_comparison(comparison)
{
	var type = comparison.val();
	var value = false;
	var info = false;

	switch(type)
	{
		case("is equal to"):
			value = "0";
			break;
		case("is not equal to"):
			value = "0";
			break;
		case("is greater than"):
			value = "0";
			break;
		case("is less than"):
			value = "0";
			break;
		case("is a timestamp after"):
			value = "30";
			info = "days ago"
			break;
		case("is a timestamp before"):
			value = "30";
			info = "days ago"
			break;
	}

	if(comparison.parent().find(".value").attr("default"))
	{
		value = comparison.parent().find(".value").attr("default");
		comparison.parent().find(".value").removeAttr("default");
	}

	comparison.parent().find(".value").val(value);
	if(value) comparison.parent().find(".value").show();
	else comparison.parent().find(".value").hide();

	comparison.parent().find(".info").html(info);
	if(info) comparison.parent().find(".info").show();
	else comparison.parent().find(".info").hide();
}

