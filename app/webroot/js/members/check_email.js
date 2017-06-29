$(document).ready(function() {
	$("#MemberEmailId").focusout(function() {
		$(".ajax_status").css('display','inline');
		$("#email_ajax_result").css('display','none');
		var $email_id = $("#MemberEmailId").val();
		$.post("/ajax/members/check_email/", {data:{Member:{email_id:$email_id}}}, function(data) {
			$(".ajax_status").css('display', 'none');
			if (data == 1) {
				$("#email_ajax_result").attr('class','ajax_success');
				$("#email_ajax_result").text('Email is available');
			} else {
				$("#email_ajax_result").attr('class', 'ajax_error');
				$("#email_ajax_result").text('Email is already in use');
			}
			$("#email_ajax_result").css('display','inline');
                });
        });
});