$("select[name=type]").change(function() {
	init();
});

$("select[name=renew2]").change(function() {
	init();
});

$("select[name=trial2]").change(function() {
	init();
});

init();

function init()
{
	if( $("select[name=type]").val() == "membership" )
	{
		$(".membership").show();
		$(".credit").hide();
	}
	else
	{
		$(".membership").hide();
		$(".credit").show();
	}
	
	if( $("select[name=renew2]").val() == "none" )
	{
		$("select[name=renew2]").removeClass("half");
		$("input[name=renew1]").hide();
	}
	else
	{
		$("select[name=renew2]").addClass("half");
		$("input[name=renew1]").show();
	}
	
	if( $("select[name=trial2]").val() == "none" )
	{
		$("select[name=trial2]").removeClass("half");
		$("input[name=trial1]").hide();
	}
	else
	{
		$("select[name=trial2]").addClass("half");
		$("input[name=trial1]").show();
	}
}