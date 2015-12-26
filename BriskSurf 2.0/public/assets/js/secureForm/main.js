(function($) {
	if($("#insertSecurityHere").length == 0)
	{
		$('body').append('<div class="modal fade"  id="securityCheck" >'
		+	  '<div class="modal-dialog">'
		+		'<div class="modal-content">'
		+			'<div style="display:none;" class="securityID"></div>'
		+		  	'<div class="modal-header">'
		+				'<button type="button" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>'
		+				'<h4 class="modal-title">Human Checker</h4>'
		+		  	'</div>'

		+		  	'<div class="modal-body">'
		+				'<p>We need to make sure you are human. Please select the button that does not match:</p><div class="row demo-tiles">'
		+				'<div class="col-xs-3"><a href="#" type="1" class="answer1 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+				'<div class="col-xs-3"><a href="#" type="2" class="answer2 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+				'<div class="col-xs-3"><a href="#" type="3" class="answer3 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+				'<div class="col-xs-3"><a href="#" type="4" class="answer4 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+		  	'</div></div>'

		+		  	'<div class="modal-footer">'
		+				'<a class="closeSecurity" href="javascript:return false;" class="btn btn-default btn-wide">Cancel</a>'
		+		  	'</div>'
		+		'</div>'
		+	  '</div>'  
		+	'</div>');
		$("form input[name=security]").each(function() {
			$(this).parent().find('button').click(function(e) {
				e.preventDefault();
				var url = $(this).parent().find("input[name=securityURL]").val();
				var id = $(this).parent().find("input[name=securityID]").val();
				$("#securityCheck .securityID").html(id);
				$("#securityCheck .answer1").css("background-image", "url(" + url + "/1)");
				$("#securityCheck .answer2").css("background-image", "url(" + url + "/2)");
				$("#securityCheck .answer3").css("background-image", "url(" + url + "/3)");
				$("#securityCheck .answer4").css("background-image", "url(" + url + "/4)");
				$('#securityCheck').modal('show');
			});
		});

		$("#securityCheck .modal-body a").click(function(e) {
			e.preventDefault();
			$('#securityCheck').modal('hide');
			var type = $(this).attr("type");
			var id = $("#securityCheck .securityID").html();
			$("form input[name=securityID][value=" + id + "]").parent().find('input[name=security]').val(type);
			$("form input[name=securityID][value=" + id + "]").parent().submit();
		});

		$(".closeSecurity").click(function() {
			$('#securityCheck').modal('hide');
		});
	}
	else
	{
		$("#insertSecurityHere").hide();
		$("#insertSecurityHere").html('<p>We need to make sure you are human. Please select the button that does not match:</p><div style="display:none;" class="securityID"></div><div class="row demo-tiles">'
		+		'<div class="col-xs-3"><a href="#" type="1" class="answer1 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+		'<div class="col-xs-3"><a href="#" type="2" class="answer2 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+		'<div class="col-xs-3"><a href="#" type="3" class="answer3 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+		'<div class="col-xs-3"><a href="#" type="4" class="answer4 btn btn-wide" style="background:#fff; min-width:1px; width:100%;">&nbsp;</a></div>'
		+	'</div><br>');

		$("form input[name=security]").each(function() {
			$(this).parent().find('button').click(function(e) {
				e.preventDefault();

				$("#insertSecurityHere").show();

				var url = $(this).parent().find("input[name=securityURL]").val();
				var id = $(this).parent().find("input[name=securityID]").val();
				$("#insertSecurityHere .securityID").html(id);
				$("#insertSecurityHere .answer1").css("background-image", "url(" + url + "/1)");
				$("#insertSecurityHere .answer2").css("background-image", "url(" + url + "/2)");
				$("#insertSecurityHere .answer3").css("background-image", "url(" + url + "/3)");
				$("#insertSecurityHere .answer4").css("background-image", "url(" + url + "/4)");

				$("#insertSecurityHere a.btn").click(function() {
					var type = $(this).attr("type");
					var id = $("#insertSecurityHere .securityID").html();
					$("form input[name=securityID][value=" + id + "]").parent().find('input[name=security]').val(type);
					$("form input[name=securityID][value=" + id + "]").parent().submit();
				});
			});
		});
	}
})(jQuery);