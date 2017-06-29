var Register = function () {
	var RegisterForm = function() {
		var form3 = $('#register_form');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Member][firstname]': {
					required: true,
				},
				'data[Member][lastname]': {
					required: true,
				},
				'data[Member][email_id]': {
					required: true,
					email: true
				},
				'data[Member][telephone]': {
					required: true,
				},
				'data[Member][address]': {
					required: true,
				},
				'data[Member][country]': {
					required: true,
				},
				'data[Member][state]': {
					required: true,
				},
				'data[Member][city]': {
					required: true,
				},
				'data[Member][postcode]': {
					required: true,
				},
				'data[New][password]': {
					required: true,
				},
				'data[New][con_password]': {
					required: true,
					equalTo: '#password'
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
					
		$('#register_form').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				var data = $(this).serialize();
				var dataemailurl = $('#email_id').attr('data-url');
				var dataurl = $('#formUrl').val();
				var redirecturl = $('#formredirectUrl').val();
				var email = $('#email_id').val();
				$.ajax({
					type:'POST',
					url:dataemailurl,
					data:{email_id:email},
					success:function(result){
						if(result.trim()=='0'){
							$.ajax({
								type:'POST',
								url:dataurl,
								data:data,
								success:function(result){
									window.location.href=redirecturl;
								}
							});
						} else {
							$('.email-required').html(email+' email id already exists.');
						}
					}
				});
			} else {
				//alert();
			}
		});
	}
	
	var PersonalInfo = function(){
		$('#info_display').click(function(e){
			e.preventDefault();
			var url = $(this).attr('data-ajaxurl');
			$.ajax({
				type:'POST',
				data:{mode:'edit'},
				url:url,
				success:function(result){
					$("#personal_info_div").html(result);
					//alert(result);
				}
			});
		});
	}
	
	var AddressInfo = function(){
		$('#address_display').click(function(e){
			e.preventDefault();
			var url = $(this).attr('data-ajaxurl');
			$.ajax({
				type:'POST',
				data:{mode:'edit'},
				url:url,
				success:function(result){
					$("#address_info_div").html(result);
					//alert(result);
				}
			});
		});
	}
	
    return {
        init: function () {
            RegisterForm();
            PersonalInfo();
            AddressInfo();
			
        },
		
		initState: function(){
			$('#register_country').change(function(){
				var id = $(this).val(); //alert(id);
				var dataurl = $(this).attr('data-url'); //alert(dataurl);
				if(id==''){
					id=0;
				}
				$.ajax({
					type:'POST',
					url:dataurl,
					data:{id:id},
					success:function(result){
						//alert(result);
						$('#register_state_div').html(result);
					}
				});
			});
		},
		
		initCity: function(){
			$('#register_state').change(function(){
				var id = $(this).val(); //alert(id);
				var dataurl = $(this).attr('data-url'); //alert(dataurl);
				if(id==''){
					id=0;
				}
				$.ajax({
					type:'POST',
					url:dataurl,
					data:{id:id},
					success:function(result){
						//alert(result);
						$('#register_city_div').html(result);
					}
				});
			});
		},
		
		personalInfoSubmit: function(){
			var form3 = $('#pinfo_form');
			var error3 = $('.alert-danger', form3);
			var success3 = $('.alert-success', form3);
			
			var validator = form3.validate({
				rules: {
					'data[Member][firstname]': {
						required: true,
					},
					'data[Member][lastname]': {
						required: true,
					},
					'data[Member][telephone]': {
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
			
			$('#pinfo_form').submit(function(e){
				e.preventDefault();
				var data = $(this).serialize();
				var submiturl = $("#pinfosubmiturl").val();
				var returnurl = $("#pinforeturnurl").val();
				if(validator.form()){
					$.ajax({
						type:'POST',
						url:submiturl,
						data:data,
						success:function(result){
							if(result.trim() == 1){
								$.ajax({
									type:'POST',
									url:returnurl,
									data:{mode:"view"},
									success:function(result){
										$("#personal_info_div").html(result);
									}
								});
							}
						}
					});
				}
			});
		},
		
		initmyState: function(){
			$('#mycountry').change(function(){
				var id = $(this).val(); //alert(id);
				var dataurl = $(this).attr('data-url'); //alert(dataurl);
				if(id==''){
					id=0;
				}
				$.ajax({
					type:'POST',
					url:dataurl,
					data:{id:id},
					success:function(result){
						//alert(result);
						$('#mystate_div').html(result);
					}
				});
			});
		},
		
		initmyCity: function(){
			$('#mystate').change(function(){
				var id = $(this).val(); //alert(id);
				var dataurl = $(this).attr('data-url'); //alert(dataurl);
				if(id==''){
					id=0;
				}
				$.ajax({
					type:'POST',
					url:dataurl,
					data:{id:id},
					success:function(result){
						//alert(result);
						$('#mycity_div').html(result);
					}
				});
			});
		},
		
		addressInfoSubmit: function(){
			var form3 = $('#ainfo_form');
			var error3 = $('.alert-danger', form3);
			var success3 = $('.alert-success', form3);
			
			var validator = form3.validate({
				rules: {
					'data[Member][country]': {
						required: true,
					},
					'data[Member][state]': {
						required: true,
					},
					'data[Member][city]': {
						required: true,
					},
					'data[Member][postcode]': {
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
			
			$('#ainfo_form').submit(function(e){
				e.preventDefault();
				var data = $(this).serialize();
				var submiturl = $("#ainfosubmiturl").val();
				var returnurl = $("#ainforeturnurl").val();
				if(validator.form()){
					$.ajax({
						type:'POST',
						url:submiturl,
						data:data,
						success:function(result){
							if(result.trim() == 1){
								$.ajax({
									type:'POST',
									url:returnurl,
									data:{mode:"view"},
									success:function(result){
										$("#address_info_div").html(result);
									}
								});
							}
						}
					});
				}
			});
		},
    };

}();