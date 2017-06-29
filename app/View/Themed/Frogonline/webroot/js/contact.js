	/* var form3 = $('#contact_usform');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
	
	var validator = form3.validate({
		rules: {
			'data[Page][name]': {
				required: true
			},
			'data[Page][email]': {
				required: true,
				email: true
			},
			'data[Page][message]': {
				required: true
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
	 */
	
	$('.contact_usform').submit(function(e){
		e.preventDefault();
		var name = $('#name').val();
		var email = $('#contacts-email').val();
		var message = $('#contacts-message').val();
		var path = $('#hidden').val();
		
		if(name == '' && email == '' && message == ''){
		$('#contact_msg').html('<p style="color:red" class="alert alert-danger">Please fill out all fields.</p>');
		return false;
		}else if(name == ''){
		$('#contact_msg').html('<p style="color:red" class="alert alert-danger">Name field is required.</p>');
		return false;
		}else if(email == ''){
		$('#contact_msg').html('<p style="color:red" class="alert alert-danger">Email field is required.</p>');
		return false;
		}else if(message == ''){
		$('#contact_msg').html('<p style="color:red" class="alert alert-danger">Message field is required.</p>');
		return false;
		}else{
				$.ajax({
					type:'POST',
					url:path,
					data:{ name : name, email : email, message : message },
					beforeSend : function(res){
						$(".ajaxLayout").show(); 
					},
					complete: function() {
						$(".ajaxLayout").hide(); 
					},
					success:function(result){
					 //alert(result);
							/*$('#contact_usform')[0].reset(); */
						if(result == 4){
							$('#contact_msg').html('<p style="color:red" class="alert alert-success">Contact details has been sent.</p>');
							//$('#contact_usform')[0].reset();
							return false;
						} else if(result == 3) {
							$('#contact_msg').html('<p class="alert alert-danger">Failed to send mail.</p>');
						} else if(result == 1) {
							$('#contact_msg').html('<p class="alert alert-danger">Please fill all fields.</p>');
						}
					}
				});

		}

	});
	
	$('#contact_msg').click(function(e){
		e.preventDefault();
		$(this).find('p').remove();
	});
 

/* });  */