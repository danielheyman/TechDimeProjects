$("#selection").change(function() {
	init();
});
function init()
{
	$("#text form").html( $(".hidden[name=" + $("#selection").val() + "]").html() );
	$("#text textarea").elastic();
}
init();