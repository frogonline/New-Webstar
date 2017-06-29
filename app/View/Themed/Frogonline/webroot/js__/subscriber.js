 $(function(){
	var form3 = $('#subscriberForm');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	var validator = form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[Subscriber][subscriber_email]': {
				required: true,
				email:true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
		},

		highlight: function (element) { // hightlight error inputs
		   $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error'); // set success class to the control group
		}

	});
	
	
	$('#subscriberForm').submit(function(e){
		e.preventDefault();
		
		if(validator.form()){
			var data = $(this).serialize();
			var urldata = $('#submitUrl').val();
			$.ajax({
				type:'POST',
				url:urldata,
				data:data,
				success:function(result){
					if(result== '1')
					{
						$('#errSubscriber').html('Thank you for subscribing');
					}
					else if(result == '0')
					{
						$('#errSubscriber').html('Failed to subscribe your Email id');
					}
					else if(result == '-1')
					{
						$('#errSubscriber').html('Your Email id already subscribed');
					}
				}
			});
		}
	});

});