var Checkout = function () {
	var CheckoutOption = function() {
		var form3 = $('#chkopt');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[checkout][account]': {
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
					
		$('#chkopt').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				
				var data = $(this).serialize();
				var dataurl = $('#paymentaddressurl').val();
				$.ajax({
					url:dataurl,
					type:'POST',
					data:data,
					success:function(result){
						//alert(result);
						$('#payment-address-content').html(result);
						$('#checkout-content').removeClass('in');
						$('#payment-address-content').addClass('in');
						$('#payment-address-content').css('height','auto');
					}
				});
				
			} else {
				$('#checkout-content').addClass('in');
				$('#checkout-content').css('height','auto');
				$('#payment-address-content').removeClass('in');
			}
			
		});
		
		$('#checkout').on('change', '#checkout-content input[name="data[checkout][account]"]', function() {
			var title = '';

			if ($(this).attr('value') == 'register') {
			title = 'Step 2: Account &amp; Billing Details';
			} else {
			title = 'Step 2: Billing Details';
			}    

			$('#payment-address .accordion-toggle').html(title);
		});
	}
	
	var ReturnCustomer = function() {
		var form3 = $('#chklogin');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Member][email_id]': {
					required: true,	
					email: true
				},
				'data[Member][password]': {
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
		
		$('#chklogin').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				
				var data = $(this).serialize();
				var dataurl = $('#returnuserurl').val();
				$.ajax({
					url:dataurl,
					type:'POST',
					data:data,
					success:function(result){
						//alert(result);
						if(result.trim() == 1){
							var redirect = window.location.href;
							window.location.assign(redirect);
						} else {
							$('#checkout-content').addClass('in');
							$('#checkout-content').css('height','auto');
							$('#payment-address-content').removeClass('in');
							if(result.trim()==2){
								$('#loginmsg').html('<div class="note note-danger"><p>You have entered wrong password.</p></div>');
							} else if(result.trim()==3) {
								$('#loginmsg').html('<div class="note note-danger"><p>Username and password combination does not match.</p></div>');
							} else if(result.trim()==4) {
								$('#loginmsg').html('<div class="note note-danger"><p>Please enter all fields.</p></div>');
							}
							
						}
					}
				});
				
			} else {
				$('#checkout-content').addClass('in');
				$('#checkout-content').css('height','auto');
				$('#payment-address-content').removeClass('in');
			}
			
		});
		
		$('#checkout').on('change', '#checkout-content input[name="data[checkout][account]"]', function() {
			var title = '';

			if ($(this).attr('value') == 'register') {
			title = 'Step 2: Account &amp; Billing Details';
			} else {
			title = 'Step 2: Billing Details';
			}    

			$('#payment-address .accordion-toggle').html(title);
		});
	}
	
	BillingDetail = function(){
		var form3 = $('#billingForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Order][firstname]': {
					required: true
				},
				'data[Order][lastname]': {
					required: true
				},
				'data[Order][email_id]': {
					required: true
				},
				'data[Order][telephone]': {
					required: true
				},
				'data[Order][address]': {
					required: true
				},
				'data[Order][country]': {
					required: true
				},
				'data[Order][state]': {
					required: true
				},
				'data[Order][city]': {
					required: true
				},

				'data[Order][postcode]': {
					required: true
				},
				'data[Order][password]': {
					required: true
				},
				'data[Order][password_confirm]': {
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
		
		$('#billingForm').submit(function(e){
			e.preventDefault();
			
			var mode	=	$('#mode').val();
			if(mode=='register'){
			   
				var g_recaptcha	=	$('#billingForm [name="g-recaptcha-response"]').val();
				if(g_recaptcha!=""){
					if(validator.form()){
						var data = $(this).serialize();
						var dataurl = $('#shippingaddressurl').val();
						$.ajax({
							url:dataurl,
							type:'POST',
							data:data,
							success:function(result){
								//alert(result);
								$('#shipping-address-content').html(result);
								$('#payment-address-content').removeClass('in');
								$('#shipping-address-content').addClass('in');
								$('#shipping-address-content').css('height','auto');
							}
						});
					} else {
						$('#payment-address-content').addClass('in');
						$('#payment-address-content').css('height','auto');
						$('#shipping-address-content').removeClass('in');
					}
				} else {
					$('#claptchamsg').html('This field is required.');
					$('#payment-address-content').addClass('in');
					$('#payment-address-content').css('height','auto');
					$('#shipping-address-content').removeClass('in');
				}
				
				
				
			} else {
				if(validator.form()){
					var data = $(this).serialize();
					var dataurl = $('#shippingaddressurl').val();
					$.ajax({
						url:dataurl,
						type:'POST',
						data:data,
						success:function(result){
							//alert(result);
							$('#shipping-address-content').html(result);
							$('#payment-address-content').removeClass('in');
							$('#shipping-address-content').addClass('in');
							$('#shipping-address-content').css('height','auto');
						}
					});
				} else {
					$('#payment-address-content').addClass('in');
					$('#payment-address-content').css('height','auto');
					$('#shipping-address-content').removeClass('in');
				}
			}
		});
		
	}
	
	ShipingDetail = function(){
		var form3 = $('#shippingForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Order][ship_firstname]': {
					required: true
				},
				'data[Order][ship_lastname]': {
					required: true
				},
				'data[Order][ship_email_id]': {
					required: true
				},
				'data[Order][ship_telephone]': {
					required: true
				},
				'data[Order][ship_address]': {
					required: true
				},
				'data[Order][ship_country]': {
					required: true
				},
				'data[Order][ship_state]': {
					required: true
				},
				'data[Order][ship_city]': {
					required: true
				},
				
				'data[Order][ship_postcode]': {
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
		
		$('#shippingForm').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				var data = $(this).serialize();
				var dataurl = $('#shippingmethodurl').val();
				$.ajax({
					url:dataurl,
					type:'POST',
					data:data,
					success:function(result){
						//alert(result);
						$('#shipping-method-content').html(result);
						$('#shipping-address-content').removeClass('in');
						$('#shipping-method-content').addClass('in');
						$('#shipping-method-content').css('height','auto');
					}
				});
			} else {
				$('#shipping-address-content').addClass('in');
				$('#shipping-address-content').css('height','auto');
				$('#shipping-method-content').removeClass('in');
			}
		});
		
	}
	
	ShipingMethod = function(){
		var form3 = $('#shippingmethodForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Order][shipping_rate]': {
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
		
		$('#shippingmethodForm').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				var data = $(this).serialize();
				var dataurl = $('#paymentmethodsurl').val();
				$.ajax({
					url:dataurl,
					type:'POST',
					data:data,
					success:function(result){
						//alert(result);
						$('#payment-method-content').html(result);
						$('#shipping-method-content').removeClass('in');
						$('#payment-method-content').addClass('in');
						$('#payment-method-content').css('height','auto');
					}
				});
			} else {
				$('#shipping-method-content').addClass('in');
				$('#shipping-method-content').css('height','auto');
				$('#payment-method-content').removeClass('in');
			}
		});
		
	}
	
	PaymentMethod = function(){
		var form3 = $('#paymentmethodForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
		
		var validator = form3.validate({
			rules: {
				'data[Order][payment_method]': {
					required: true
				},
				'data[Order][credit_cardno]': {
					required: true
				},
				'data[Order][cvv_no]': {
					required: true
				},
				'data[Order][month]': {
					required: true
				},
				'data[Order][year]': {
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
		
		$('#paymentmethodForm').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				var data = $(this).serialize();
				
				var shipping_cost= $("#shipping_cost").val();
				data += '&data[Order][shipping_cost]='+shipping_cost;
				var dataurl = $('#confirmordersurl').val();
				$.ajax({
					url:dataurl,
					type:'POST',
					data:data,
					success:function(result){
						//alert(result);
						$('#confirm-content').html(result);
						$('#payment-method-content').removeClass('in');
						$('#confirm-content').addClass('in');
						$('#confirm-content').css('height','auto');
					}
				});
			} else {
				$('#payment-method-content').addClass('in');
				$('#payment-method-content').css('height','auto');
				$('#confirm-content').removeClass('in');
			}
		});
		
		$('.paymentMethod').click(function(e){
			if($(this).is(':checked')){
				var mode = $(this).val();
				if(mode.trim()=='EWAY'){
					$('#ewayDiv').show();
				} else {
					$('#ewayDiv').hide();
				}
				
			}
		});
		
		/* $('#creditCardNo').keyup(function(){
			var val = $(this).val();
			var dupval = val.replace("-", "");
			if(dupval.trim()!=''){
				if((dupval.length % 4) == 0){
					val = val+'-';
					$(this).val(val);
				}
			}
		}); */
		
	}
	
	OrderConfirm = function(){
		
		$('#orderconfirmForm').submit(function(e){
			e.preventDefault();
			var data = $(this).serialize();
			$('#billingForm').submit();
			var data1 = $('#billingForm').serialize();
			
			$('#shippingForm').submit();
			var data2 = $('#shippingForm').serialize();
			
			$('#shippingmethodForm').submit();
			var data3 = $('#shippingmethodForm').serialize();
			
			$('#paymentmethodForm').submit();
			var data4 = $('#paymentmethodForm').serialize();
			
			var dataArr = data + '&' + data1 + '&' + data2 + '&' + data3 + '&' + data4;
			var dataurl = $('#ordersubmiturl').val();
			var redirectURL = $('#redirecturl').val();
			$.ajax({
				url:dataurl,
				type:'POST',
				data:dataArr,
				beforeSend:function(){
					$('#responsive').modal('show');
				},
				success:function(result){
					var resultData = result.split('-');
					if(resultData[0].trim()==1){
						window.location.href = redirectURL+'/'+resultData[1];
					} else if(resultData[0].trim() > 5) {
						$('#confirm-content').removeClass('in');
						$('#payment-address-content').addClass('in');
						$('#payment-address-content').css('height','auto');
						if(resultData[0].trim()==7){
							$('#emailmsgerr').html('Email id already exists.');
						} else {
							$('#regmsgerr').html('<div class="note note-danger"><p>Email id already exists.</p></div>');
						}
					}
					
				}
			});
			
		});
		
	}
	
    return {
        init: function () {
            CheckoutOption();
            ReturnCustomer();
			BillingDetail();
			ShipingDetail();
			ShipingMethod();
			PaymentMethod();
			OrderConfirm();
        },
		
		initBillingState: function(){
			$('#billing_country').change(function(){
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
						$('#billing_state_div').html(result);
					}
				});
			});
		},
		
		 initBillingCity: function(){
			$('#billing_state').change(function(){
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
						$('#billing_city_div').html(result);
					}
				});
			});
		}, 
		
		initShippingState: function(){
			$('#shipping_country').change(function(){
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
						$('#shipping_state_div').html(result);
					}
				});
			});
		},
		
		initShippingCity: function(){
			$('#shipping_state').change(function(){
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
						$('#shiping_city_div').html(result);
					}
				});
			});
		}
    };

}();