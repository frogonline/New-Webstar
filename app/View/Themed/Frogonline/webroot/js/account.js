var Account = function () {
	var LoginForm = function() {
		var form3 = $('#login_form');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Member][email_id]': {
					required: true,
					email: true
				},
				'data[Member][password]': {
					required: true,
				}
			},
			errorPlacement: function (error, element) { // render error placement for each input type
				if (element.attr("data-error-container")) { 
					error.appendTo(element.attr("data-error-container"));
				} else {
					error.insertAfter(element); // for other inputs, just perform default behavior
				}
			},
		});
					
		$('#login_form').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				var data = $(this).serialize();
				var submiturl = $('#submitLoginUrl').val();
				var redirecturl = $('#redirectLoginUrl').val();
				$.ajax({
					type:'POST',
					url:submiturl,
					data:data,
					success:function(result){
						
						if(result.trim()=='1'){
							window.location.href = redirecturl;
						} else if(result.trim()=='2') {
							$('#loginErr').html('<i class="fa fa-exclamation-circle pull-left"></i> Password does not match.').show();
						} else if(result.trim()=='3') {
							$('#loginErr').html('<i class="fa fa-exclamation-circle pull-left"></i> Your account is still inactive. Please active your account.').show();
						} else if(result.trim()=='4') {
							$('#loginErr').html('<i class="fa fa-exclamation-circle pull-left"></i> There is no account with this email id.').show();
						} else if(result.trim()=='5') {
							$('#loginErr').html('<i class="fa fa-exclamation-circle pull-left"></i> Please enter all required fields.').show();
						}
						
					}
				});
			}
		});
	}
	
	
    return {
        init: function () {
            LoginForm();
        },
		
    };

}();