function ChangeTemplate(dom){
	var tplId = $(dom).val();
	var tplFor = $(dom).attr('data-templateFor');
	var changeUrl = $(dom).attr('data-changeUrl');
	var saveasTplUrl = $(dom).attr('data-saveastplurl');
	if(tplId.trim() != ""){
		if(tplId.trim() == "custom"){
			$.ajax({
				type:'POST',
				url:saveasTplUrl,
				data:{tplId:'', tplFor:tplFor},
				beforeSend : function(res){
					$("#waitingDiv").show(); 
				},
				complete: function() {
					$("#waitingDiv").hide(); 
				},
				success:function(result){
					$('#responsive').html(result);
					$('#responsive').modal('show');
					$('#new_template_id').val(1);
				}
			});
		} else {
			$.ajax({
				type:'POST',
				url:changeUrl,
				data:{id:tplId},
				beforeSend : function(res){
					$("#waitingDiv").show(); 
				},
				complete: function() {
					$("#waitingDiv").hide(); 
				},
				success:function(result){
					$('#tplPreview').html(result);
					$('#new_template_id').val(0);
				}
			});
		}
	}
}


function clonenewtemplate(dom,callback){

	
	var tplId = $(dom).attr('data-templateid');
	var tmpsubmiturl = $(dom).attr('data-tmpsubmiturl');
	var ajaxtplprvwurl = $(dom).attr('data-ajaxtplpreview');
	var ajaxtpldrpdwnurl = $(dom).attr('data-ajaxtpldrpdwnurl');

	var tplFor = 'I';

	var tmpsidebar = $(dom).attr('data-tmpsidebar');
	

	// For some browsers, `tmpsidebar` is undefined; for others, `tmpsidebar` is false. Check for both.
	if (typeof tmpsidebar !== typeof undefined && tmpsidebar !== false) {
	  // Element has this attribute
	  var with_sidebar =tmpsidebar;
	}else{
		var with_sidebar ='N';
	}


	var dataarr = {'PageTemplate':
		{
			'template_id':tplId,
			'template_name':$("#templatedrpdwn option:selected").text(),
			'template_for':tplFor,
			'is_clone':1,
			'with_sidebar':with_sidebar
		}
	};

	

	$.ajax({
		type:"POST",
		url:tmpsubmiturl,
		data:{data:dataarr},
		success:function(result){
			//console.log(result);
			//return false;
			if(result.trim() != 0){
				
				$.post(ajaxtpldrpdwnurl, {tplId:result.trim(), tplFor:tplFor}, function(res){
					$('#pgtplDrpDown').html(res);
				});
				
				$.ajax({
					type:'POST',
					url:ajaxtplprvwurl,
					data:{id:result.trim()},
					beforeSend : function(res){
						$('#tplPreview').hide();
						$("#waitingDiv").show(); 
					},
					success:function(res){
						$("#waitingDiv").hide(); 
						$('#tplPreview').html(res).show();
						$('#saveBtnBox').show();										
						$('#new_template_id').val(1);
						callback();

					}
				});
			}
		}
	});
	
}



var Template = function() {
	var AddRow = function(){
		$('#addnewRow').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
			
			if(tplId.trim() != ""){

				var tmp_clone=$("#new_template_id").val();
				var temptype = $(this).attr('data-temptype');
				if(tmp_clone==0 && temptype=='CUSTOM'){
					clonenewtemplate($(this),function(){
						$('#addnewRow').click();	
					});				
					
					return false;
				}


				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:''},
					success:function(result){
						//alert(result);
						if(result.trim() == 1){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							});
						} else {
							$('#responsive').html(result);
							$('#responsive').modal('show');
							/* $.post(ajaxTplUrl, {id:tplId}, function(res){
								$('#tplPreview').html(res);
							}); */
						}
					}
				});
			}
		});
		
		$('#rowstyleDrpdwn').change(function(){
			var style = $(this).val();
			if(style.trim() == 'INSIDECONTAINER'){
				$('#needFg').show();
			} else {
				$('#needFg').hide();
			}
		});
	}
	
	var EditRow = function(){
		$('.editCustomRow').click(function(e){
			e.preventDefault();
			
			var tplId = $(this).attr('data-templateid');
			var rowId = $(this).attr('data-rowid');
			var tplFor = $(this).attr('data-templateFor');
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
			
			if(tplId.trim() != ""){

				var tmp_clone=$("#new_template_id").val();				
				if(tmp_clone==0){
					var preindex =0 ;
					var prehtml = $(this)[0].outerHTML;
					$.each($(".editCustomRow"), function( index, value ) {
						if(prehtml==$(".editCustomRow")[index].outerHTML){
							//alert(index);
							preindex = index;
						}
					});

					clonenewtemplate($(this),function(){

						var newdom = '';

						$.each($(".editCustomRow"), function( index, value ) {

							if(preindex==index){
								newdom = $(this);
							}

						});		

						var tplId = $(newdom).attr('data-templateid');
						var rowId = $(newdom).attr('data-rowid');
						var tplFor = $(newdom).attr('data-templateFor');
						var submitUrl = $(newdom).attr('data-url');
						var saveasTplUrl = $(newdom).attr('data-saveastplurl');
						var ajaxTplUrl = $(newdom).attr('data-ajaxtplpreview');				

						$.ajax({
							type:'POST',
							url:submitUrl,
							data:{tplId:tplId, rowId:rowId},
							success:function(result){
								//alert(result);
								if(result.trim() == 1){
									$.ajax({
										type:'POST',
										url:saveasTplUrl,
										data:{tplId:tplId, tplFor:tplFor},
										success:function(result){
											$('#responsive').html(result);
											$('#responsive').modal('show');
										}
									});
								} else {
									$('#responsive').html(result);
									$('#responsive').modal('show');
									/* $.post(ajaxTplUrl, {id:tplId}, function(res){
										$('#tplPreview').html(res);
									}); */
								}
							}
						});
					});
					
					return false;
				}

				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:rowId},
					success:function(result){
						//alert(result);
						if(result.trim() == 1){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							});
						} else {
							$('#responsive').html(result);
							$('#responsive').modal('show');
							/* $.post(ajaxTplUrl, {id:tplId}, function(res){
								$('#tplPreview').html(res);
							}); */
						}
					}
				});
			}
		});
	}
		
	var SubmitRowForm = function(){
		var form3 = $('#addRowsForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
				
		var validator = form3.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "", // validate all fields including form hidden input
			rules: {
				'data[PageTemplateRow][rowstyle]': {
					required: true
				},
				'data[PageTemplateRow][rowwithForeground]': {
					required: true
				},
				'data[PageTemplateRow][sort_order]': {
					required: true,
					digits:true
				}
			},
			errorPlacement: function (error, element) { // render error placement for each input type
				if (element.attr("data-error-container")) { 
					error.appendTo(element.attr("data-error-container"));
				} else {
					error.insertAfter(element); // for other inputs, just perform default behavior
				}
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
		
		$('#addRowsForm').submit(function(e){
			e.preventDefault();
			var data = $(this).serialize();
			var tplId = $('#tmplt_id').val();
			var submitUrl = $('#rowSubmitUrl').val();
			var ajaxTplUrl = $('#ajaxTplUrl').val();
			
			if(validator.form()){
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:data,
					success:function(result){
						if(result.trim()==1){
							$('#addRowsForm')[0].reset();
							$('#responsive').modal('hide');
							$.post(ajaxTplUrl, {id:tplId}, function(res){
								$('#tplPreview').html(res);
							});
						}
					}
				});
			}
		});
	}		
			
	var ChooseShortcodeBox = function(){
		$('.addCustomCol2').click(function(e){
			
			//e.preventDefault();
			/* var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid'); */
			var submitUrl = $(this).attr('data-url');
			//alert(submitUrl);
			$.ajax({
				type:'POST',
				url:submitUrl,
				success:function(result){
					$('#responsive1').html(result);
					$('#responsive1').modal('show');
				}
			});
		});
	}
	
	var AddCol = function(){
		$('.addCustomCol').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid');
			var parentcolId = $(this).attr('data-parentcolid');
			var pageid = $(this).attr('data-pageid');
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			
			if(tplId.trim() != ""){

				var tmp_clone=$("#new_template_id").val();				
				if(tmp_clone==0){
					var preindex =0 ;
					var prehtml = $(this)[0].outerHTML;
					$.each($(".addCustomCol"), function( index, value ) {
						if(prehtml==$(".addCustomCol")[index].outerHTML){
							//alert(index);
							preindex = index;
						}
					});

					clonenewtemplate($(this),function(){

						var newdom = '';

						$.each($(".addCustomCol"), function( index, value ) {

							if(preindex==index){
								newdom = $(this);
							}

						});	

						var tplId = $(newdom).attr('data-templateid');
						var tplFor = $(newdom).attr('data-templateFor');
						var rowId = $(newdom).attr('data-rowid');
						var parentcolId = $(newdom).attr('data-parentcolid');
						var pageid = $(newdom).attr('data-pageid');
						var submitUrl = $(newdom).attr('data-url');
						var saveasTplUrl = $(newdom).attr('data-saveastplurl');					

						$.ajax({
							type:'POST',
							url:submitUrl,
							data:{tplId:tplId, rowId:rowId, parentcolId:parentcolId,pageid:pageid},
							success:function(result){
							
								if(result.trim() == 1){
									$.ajax({
										type:'POST',
										url:saveasTplUrl,
										data:{tplId:tplId, tplFor:tplFor},
										success:function(result){
											$('#responsive').html(result);
											$('#responsive').modal('show');
										
										}
									});
								} else {
									//alert('Widget is edited but page is not save');
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							}
						});
					});
					
					return false;
				}

				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:rowId, parentcolId:parentcolId,pageid:pageid},
					success:function(result){
					
						if(result.trim() == 1){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
									$('#responsive').html(result);
									$('#responsive').modal('show');
								
								}
							});
						} else {
							//alert('Widget is edited but page is not save');
							$('#responsive').html(result);
							$('#responsive').modal('show');
						}
					}
				});
			}
		});
	}
	
	var SubmitColumnForm = function(){
		var form3 = $('#addColumnsForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
				
		var validator = form3.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "", // validate all fields including form hidden input
			rules: {
				'data[PageTemplateRowsColumn][name]': {
					required: true
				},
				'data[PageTemplateRowsColumn][column]': {
					required: true
				},
				'data[PageTemplateRowsColumn][shortcode]': {
					required: true
				},
				'data[PageTemplateRowsColumn][sort_order]': {
					required: true,
					digits:true
				}
			},
			errorPlacement: function (error, element) { // render error placement for each input type
				if (element.attr("data-error-container")) { 
					error.appendTo(element.attr("data-error-container"));
				} else {
					error.insertAfter(element); // for other inputs, just perform default behavior
				}
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
		
		$('#addColumnsForm').submit(function(e){
			e.preventDefault();
			var data = $(this).serialize();
			var tplId = $('#tmplt_id').val();
			var submitUrl = $('#colSubmitUrl').val();
			var ajaxTplUrl = $('#ajaxTplUrl').val();
			
			if(validator.form()){
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:data,
					success:function(result){
						//alert(result);
						if(result.trim()==1){
							$('#addColumnsForm')[0].reset();
							$('#responsive').modal('hide');
							$.post(ajaxTplUrl, {id:tplId}, function(res){
								$('#tplPreview').html(res);
							});
						}
					}
				});
			}
		});
		
	}
	
	
	
	var SubmitColumnClientForm = function(){
		var form3 = $('#addColumnsForm1');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
				
		var validator = form3.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "", // validate all fields including form hidden input
			rules: {
				'data[PageTemplateRowsColumn][name]': {
					required: true
				},
				'data[PageTemplateRowsColumn][column]': {
					required: true
				},
				'data[PageTemplateRowsColumn][shortcode]': {
					required: true
				},
				'data[PageTemplateRowsColumn][sort_order]': {
					required: true,
					digits:true
				}
			},
			errorPlacement: function (error, element) { // render error placement for each input type
				if (element.attr("data-error-container")) { 
					error.appendTo(element.attr("data-error-container"));
				} else {
					error.insertAfter(element); // for other inputs, just perform default behavior
				}
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
		
		$('#addColumnsForm1').submit(function(e){
		
			e.preventDefault();
			var data = $(this).serialize();
			
			var tplId = $('#tmplt_id').val();
			
			var shortcodeFld = $('#shortcodeFld').val();
			var collmane = $('#colmane').val();
			var rowId = $('#rowId').val();
			var submitUrl = $('#colSubmitUrl').val();
			var pageid = $('#pageid').val();
			var parentcolId = $('#parentcolId').val();
			
			var colId = $('#colId').val();
			var dg = 'column-'+colId;
			
			if(validator.form()){
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{colId:colId, collmane:collmane,shortcodeFld:shortcodeFld,pageid:pageid,parentcolId:parentcolId},
					success:function(result){
						$('#'+dg).find('.shotc'+parentcolId).html(shortcodeFld);
						$('#'+dg).find('.colmane').html(collmane);
						$('#responsive').modal('hide');
					}
				});
			}
			
			
			
			
			
			
			
			
			
			
		});
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	var DeleteRow = function(){
		$('.delCustomRow').click(function(e){
			e.preventDefault();
			if(confirm("Do you really want to delete entire row?")){
				var tplId = $(this).attr('data-templateid');
				var tplFor = $(this).attr('data-templateFor');
				var rowId = $(this).attr('data-rowid');
				var submitUrl = $(this).attr('data-url');
				var saveasTplUrl = $(this).attr('data-saveastplurl');
				var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
				
				if(tplId.trim() != ""){

					var tmp_clone=$("#new_template_id").val();				
					if(tmp_clone==0){
						var preindex =0 ;
						var prehtml = $(this)[0].outerHTML;
						$.each($(".delCustomRow"), function( index, value ) {
							if(prehtml==$(".delCustomRow")[index].outerHTML){
								//alert(index);
								preindex = index;
							}
						});

						clonenewtemplate($(this),function(){

							var newdom = '';

							$.each($(".delCustomRow"), function( index, value ) {

								if(preindex==index){
									newdom = $(this);
								}

							});		

							var tplId = $(newdom).attr('data-templateid');
							var tplFor = $(newdom).attr('data-templateFor');
							var rowId = $(newdom).attr('data-rowid');
							var submitUrl = $(newdom).attr('data-url');
							var saveasTplUrl = $(newdom).attr('data-saveastplurl');
							var ajaxTplUrl = $(newdom).attr('data-ajaxtplpreview');				

							$.ajax({
								type:'POST',
								url:submitUrl,
								data:{tplId:tplId, rowId:rowId},
								success:function(result){
									//alert(result);
									if(result.trim() == 1){
										$.ajax({
											type:'POST',
											url:saveasTplUrl,
											data:{tplId:tplId, tplFor:tplFor},
											success:function(result){
												$('#responsive').html(result);
												$('#responsive').modal('show');
											}
										});
									} else if(result.trim() == 2){
										$.post(ajaxTplUrl, {id:tplId}, function(res){
											$('#tplPreview').html(res);
										});
									}
								}
							});
						});
						
						return false;
					}

					$.ajax({
						type:'POST',
						url:submitUrl,
						data:{tplId:tplId, rowId:rowId},
						success:function(result){
							//alert(result);
							if(result.trim() == 1){
								$.ajax({
									type:'POST',
									url:saveasTplUrl,
									data:{tplId:tplId, tplFor:tplFor},
									success:function(result){
										$('#responsive').html(result);
										$('#responsive').modal('show');
									}
								});
							} else if(result.trim() == 2){
								$.post(ajaxTplUrl, {id:tplId}, function(res){
									$('#tplPreview').html(res);
								});
							}
						}
					});
				}
			}
		});
	}
	
	var DeleteCol = function(){
		$('.dltCustomCol').click(function(e){
			e.preventDefault();
			if(confirm("Do you really want to delete entire column?")){
				var tplId = $(this).attr('data-templateid');
				var tplFor = $(this).attr('data-templateFor');
				var colId = $(this).attr('data-colid');
				var submitUrl = $(this).attr('data-url');
				var saveasTplUrl = $(this).attr('data-saveastplurl');
				var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
				
				if(tplId.trim() != ""){

					var tmp_clone=$("#new_template_id").val();				
					if(tmp_clone==0){
						var preindex =0 ;
						var prehtml = $(this)[0].outerHTML;
						$.each($(".dltCustomCol"), function( index, value ) {
							if(prehtml==$(".dltCustomCol")[index].outerHTML){
								//alert(index);
								preindex = index;
							}
						});

						clonenewtemplate($(this),function(){

							var newdom = '';

							$.each($(".dltCustomCol"), function( index, value ) {

								if(preindex==index){
									newdom = $(this);
								}

							});	

							var tplId = $(newdom).attr('data-templateid');
							var tplFor = $(newdom).attr('data-templateFor');
							var colId = $(newdom).attr('data-colid');
							var submitUrl = $(newdom).attr('data-url');
							var saveasTplUrl = $(newdom).attr('data-saveastplurl');
							var ajaxTplUrl = $(newdom).attr('data-ajaxtplpreview');

							$.ajax({
								type:'POST',
								url:submitUrl,
								data:{tplId:tplId, colId:colId},
								success:function(result){
									//alert(result);
									if(result.trim() == 1){
										$.ajax({
											type:'POST',
											url:saveasTplUrl,
											data:{tplId:tplId, tplFor:tplFor},
											success:function(result){
												$('#responsive').html(result);
												$('#responsive').modal('show');
											}
										});
									} else if(result.trim() == 2){
										$.post(ajaxTplUrl, {id:tplId}, function(res){
											$('#tplPreview').html(res);
										});
									}
								}
							});					

							
						});
						
						return false;
					}


					$.ajax({
						type:'POST',
						url:submitUrl,
						data:{tplId:tplId, colId:colId},
						success:function(result){
							//alert(result);
							if(result.trim() == 1){
								$.ajax({
									type:'POST',
									url:saveasTplUrl,
									data:{tplId:tplId, tplFor:tplFor},
									success:function(result){
										$('#responsive').html(result);
										$('#responsive').modal('show');
									}
								});
							} else if(result.trim() == 2){
								$.post(ajaxTplUrl, {id:tplId}, function(res){
									$('#tplPreview').html(res);
								});
							}
						}
					});
				}
			}
		});
	}
	
	var EditCol = function(){
		$('.editCustomCol').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid');
			var colId = $(this).attr('data-colid');
			var parentcolId = $(this).attr('data-parentcolid');
			var pageid = $(this).attr('data-pageid');
			
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
			
			if(tplId.trim() != ""){

				var tmp_clone=$("#new_template_id").val();				
				if(tmp_clone==0){
					var preindex =0 ;
					var prehtml = $(this)[0].outerHTML;
					$.each($(".editCustomCol"), function( index, value ) {
						if(prehtml==$(".editCustomCol")[index].outerHTML){
							//alert(index);
							preindex = index;
						}
					});

					clonenewtemplate($(this),function(){

						var newdom = '';

						$.each($(".editCustomCol"), function( index, value ) {

							if(preindex==index){
								newdom = $(this);
							}

						});						

						var tplId = $(newdom).attr('data-templateid');
						var tplFor = $(newdom).attr('data-templateFor');
						var rowId = $(newdom).attr('data-rowid');
						var colId = $(newdom).attr('data-colid');
						var parentcolId = $(newdom).attr('data-parentcolid');
						var pageid = $(newdom).attr('data-pageid');
						
						var submitUrl = $(newdom).attr('data-url');
						var saveasTplUrl = $(newdom).attr('data-saveastplurl');
						var ajaxTplUrl = $(newdom).attr('data-ajaxtplpreview');				

						$.ajax({
							type:'POST',
							url:submitUrl,
							data:{tplId:tplId, rowId:rowId, colId:colId, parentcolId:parentcolId,pageid:pageid},
							success:function(result){
								
								
								if(result.trim() == "1"){
									$.ajax({
										type:'POST',
										url:saveasTplUrl,
										data:{tplId:tplId, tplFor:tplFor},
										success:function(result){
										
											$('#responsive').html(result);
										//	alert('Widget is edited but page is not save');
											$('#responsive').modal('show');
											
										}
									});
								} else {
								
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							}
						});
					});
					
					return false;
				}

				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:rowId, colId:colId, parentcolId:parentcolId,pageid:pageid},
					success:function(result){
						
						
						if(result.trim() == "1"){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
								
									$('#responsive').html(result);
								//	alert('Widget is edited but page is not save');
									$('#responsive').modal('show');
									
								}
							});
						} else {
						
							$('#responsive').html(result);
							$('#responsive').modal('show');
						}
					}
				});
			}
		});
	}
	
		var EditColclient = function(){
		$('.editCustomCol1').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid');
			var colId = $(this).attr('data-colid'); 
			var dg = 'column-'+colId;
			//alert(dg);
			var parentcolId = $(this).attr('data-parentcolid');
			var pageid = $(this).attr('data-pageid');
			var shotcode=$('.shotc'+parentcolId).text();
		
			//alert(shotcode);
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
			//alert(submitUrl);
			if(tplId.trim() != ""){
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:rowId, colId:colId, parentcolId:parentcolId,pageid:pageid,shotcode:shotcode},
					success:function(result){
						
						
						if(result.trim() == 1){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
								
									$('#responsive').html(result);
								//	alert('Widget is edited but page is not save');
									$('#responsive').modal('show');
									
								}
							});
						} else {
						   // 
							$('#responsive').html(result);
							$('#responsive').modal('show');
							
							
						}
						
						
					}
				});
			}
		});
	}
	
	
	
	var EditSidebarCol = function(){
		$('.editSidebarCustomCol').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid');
			var colId = $(this).attr('data-colid');
			var parentcolId = $(this).attr('data-parentcolid');
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			var ajaxTplUrl = $(this).attr('data-ajaxtplpreview');
			
			if(tplId.trim() != ""){


				var tmp_clone=$("#new_template_id").val();				
				if(tmp_clone==0){
					var preindex =0 ;
					var prehtml = $(this)[0].outerHTML;
					$.each($(".editSidebarCustomCol"), function( index, value ) {
						if(prehtml==$(".editSidebarCustomCol")[index].outerHTML){
							//alert(index);
							preindex = index;
						}
					});

					clonenewtemplate($(this),function(){

						var newdom = '';

						$.each($(".editSidebarCustomCol"), function( index, value ) {

							if(preindex==index){
								newdom = $(this);
							}

						});	

						var tplId = $(newdom).attr('data-templateid');
						var tplFor = $(newdom).attr('data-templateFor');
						var rowId = $(newdom).attr('data-rowid');
						var colId = $(newdom).attr('data-colid');
						var parentcolId = $(newdom).attr('data-parentcolid');
						var submitUrl = $(newdom).attr('data-url');
						var saveasTplUrl = $(newdom).attr('data-saveastplurl');
						var ajaxTplUrl = $(newdom).attr('data-ajaxtplpreview');					

						$.ajax({
							type:'POST',
							url:submitUrl,
							data:{tplId:tplId, rowId:rowId, colId:colId, parentcolId:parentcolId},
							success:function(result){
								//alert(result);
								if(result.trim() == "1"){
									$.ajax({
										type:'POST',
										url:saveasTplUrl,
										data:{tplId:tplId, tplFor:tplFor},
										success:function(result){
											$('#responsive').html(result);
											$('#responsive').modal('show');
										}
									});
								} else {
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							}
						});

					});
					
					return false;
				}


				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:rowId, colId:colId, parentcolId:parentcolId},
					success:function(result){
						//alert(result);
						if(result.trim() == "1"){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							});
						} else {
							$('#responsive').html(result);
							$('#responsive').modal('show');
						}
					}
				});
			}
		});
	}
	
	var AddChildCol = function(){
		$('#addnewChildCol').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid');
			var colId = $(this).attr('data-colid');
			var parentcolId = $(this).attr('data-parentcolid');
			var submitUrl = $(this).attr('data-url');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			
			if((rowId.trim()!="") && (parentcolId.trim()!="")){

				var tmp_clone=$("#new_template_id").val();
				var temptype = $(this).attr('data-temptype');
				if(tmp_clone==0 && temptype=='CUSTOM'){
					clonenewtemplate($(this),function(){
						$('#addnewChildCol').click();	
					});				
					
					return false;
				}

				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{tplId:tplId, rowId:rowId, parentcolId:parentcolId},
					success:function(result){
						if(result.trim() == 1){
							$.ajax({
								type:'POST',
								url:saveasTplUrl,
								data:{tplId:tplId, tplFor:tplFor},
								success:function(result){
									$('#responsive').html(result);
									$('#responsive').modal('show');
								}
							});
						} else {
							$('#responsive').html(result);
							$('#responsive').modal('show');
						}
					}
				});
			}
			
		});
	}
	
	var FooterColEdit = function(){
		$('.coleditBtn').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-tplId');
			var colId = $(this).attr('data-colId');
			var submitUrl = $(this).attr('data-url');
			
			if(colId.trim()!=""){
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{colId:colId, tplId:tplId},
					success:function(result){
						if(result.trim()!=""){
							$('#responsive').html(result);
							$('#responsive').modal('show');
						}
					}
				});
			}
		});
	}
	
	var FooterColAdd = function(){
		$('#footerAddcol').click(function(e){
			e.preventDefault();
			var tplId = $(this).attr('data-tplId');
			var submitUrl = $(this).attr('data-url');
			
			$.ajax({
				type:'POST',
				url:submitUrl,
				data:{colId:0, tplId:tplId},
				success:function(result){
					if(result.trim()!=""){
						$('#responsive').html(result);
						$('#responsive').modal('show');
					}
				}
			});
		});
	}
	
	var FooterColSubmit = function(){
		var form3 = $('#mngeColForm');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);
				
		var validator = form3.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "", // validate all fields including form hidden input
			rules: {
				
				'data[FooterColumn][column]': {
					required: true
				},
				'data[FooterColumn][shortcode]': {
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
		
		$('#mngeColForm').submit(function(e){
			e.preventDefault();
			if(validator.form()){
				var tplId = $('#tmplt_id').val();
				var data = $(this).serialize();
				var submitUrl = $('#colSubmitUrl').val();
				var ajaxTplUrl = $('#ajaxTplUrl').val();
				
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:data,
					success:function(result){
						if(result.trim()==1){
							$.ajax({
								type:'POST',
								url:ajaxTplUrl,
								data:{tplId:tplId},
								success:function(result){
									$('#tplPreview').html(result);
									$('#responsive').modal('hide');
								}
							});
						}
					}
				});
			}
		});
	}
	
	var FooterColDelete = function(){
		$('.coldeleteBtn').click(function(e){
			e.preventDefault();
			if(confirm("Do you want to delete?")){
			
				var colId = $(this).attr('data-colId');
				var tplId = $(this).attr('data-tplId');
				var submitUrl = $(this).attr('data-url');
				var ajxtplUrl = $(this).attr('data-tplurl');
				//alert(colId);
				if(colId.trim()!=""){
					$.ajax({
						type:'POST',
						url:submitUrl,
						data:{colId:colId},
						success:function(result){
							
							if(result.trim()=="1"){
								$.ajax({
									type:'POST',
									url:ajxtplUrl,
									data:{tplId:tplId},
									success:function(result){
										$('#tplPreview').html(result);
									}
								});
							}
						}
					});
				}
			
			}
		});
	}
	
	var CloneWidget = function(){
		$('.cloneWidget').click(function(e){
			e.preventDefault();
			var pageid=$("#id").val();
			
			var colId = $(this).attr('data-colid');
			
			var parent_colid = $(this).attr('parent_colid');
			var tplId = $(this).attr('data-templateid');
			var widgetId = $(this).attr('data-widgetId');
			var def = $('#def').val();
			
			var submitUrl = $(this).attr('data-url');
			//alert(submitUrl);
			var res = submitUrl.split("/");
			var reslen=res.length;
			var requinx=reslen-2;
			var reqitext=res[requinx];
			var shortco=reqitext.substring(0,(reqitext.length-1));
			//alert(shortco);
			var ajxtplUrl = $(this).attr('data-ajaxtplpreview');

			
			if(confirm('Do You want to clone it?')){

				var tmp_clone=$("#new_template_id").val();
				

				if(tmp_clone==0){

					clonenewtemplate($(this),function(){});

				}else{
				
					/*--clone ajax--*/
					$.ajax({
						type:'POST',
						url:submitUrl,
						data:{colId:colId, widgetId:widgetId,pageid:pageid,def:def},
						success:function(result){
							//alert(result);
							
								if(result.trim()==1){
								
								
									$.post(ajxtplUrl, {id:tplId,def:def}, function(res){
										$('#tplPreview').html(res);
									});
								
									
									
								}else {
								
								if(parent_colid!='bal')
									{
									$('#column-'+parent_colid).find('.shotc'+colId).html(result);
									}
									else {
									$('#column-'+colId).find('.shotc'+colId).html(result);
									//$('#'+dg).find('.shotc').html(shortcodeFld);
									}
								}
								alert('Please save the page to see the effect of the cloned widgets in the front end.');
								toastr.success('Widget Cloned Successfully', 'Success :',{closeButton:true});

						}
					});
				}
			}
		});
		
	}
	
	var CustomClientTpl = function(){
		$('#addClientcustomtplbtn').click(function(e){
			e.preventDefault();
			var tplName = $("#title").val();
			var tplId = $(this).attr('data-tplid');
			var tplFor = $(this).attr('data-templateFor');
			var changeUrl = $(this).attr('data-changeUrl');
			var saveasTplUrl = $(this).attr('data-saveastplurl');
			
			if(tplName.trim() != ""){
				$.ajax({
					type:'POST',
					url:saveasTplUrl,
					data:{tplId:tplId, title:tplName, tplFor:tplFor},
					beforeSend : function(res){
						$("#waitingDiv").show(); 
					},
					complete: function() {
						$("#waitingDiv").hide(); 
					},
					success:function(result){
						$('#responsive').html(result);
						$('#responsive').modal('show');
					}
				});
			} else {
				$('#title-err').html("Please enter the title.");
				$("#title").focus();
				$("html").animate({scrollTop:400}, '500', 'swing');
			}
		});
		
		$('#title').on("click keyup",function(){
			var title = $(this).val();
			if(title.trim()!=""){
				$('#title-err').html("");
			}
		});
	}
	
	return {
		init:function(){
			AddRow();
			EditRow();
			SubmitRowForm();
			AddCol();
			SubmitColumnForm();
			DeleteRow();
			DeleteCol();
			EditCol();
			EditColclient();
			EditSidebarCol();
			ChooseShortcodeBox();
			AddChildCol();
			SubmitColumnClientForm();
			//ChangeTemplate();
			FooterColAdd();
			FooterColEdit();
			FooterColSubmit();
			FooterColDelete();
			CloneWidget();
			CustomClientTpl();
		},
		
		savetplsubmit:function(){
			var form3 = $('#saveasForm');
			var error3 = $('.alert-danger', form3);
			var success3 = $('.alert-success', form3);
							
			var validator = form3.validate({
				errorElement: 'span', //default input error message container
				errorClass: 'help-block', // default input error message class
				focusInvalid: false, // do not focus the last invalid input
				ignore: "", // validate all fields including form hidden input
				rules: {
					'data[PageTemplate][template_name]': {
						required: true
					}
				},
				errorPlacement: function (error, element) { // render error placement for each input type
					error.insertAfter(element); 
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
			
			$('#saveasForm').submit(function(e){
				e.preventDefault();
				if(validator.form()){
					var data = $(this).serialize();
					var tplFor = $('#template_for').val();
					//var pre_row_id = $('#pre_row_id').val();
					//var mode = $('#mode').val();
					
					var submiturl = $('#savetplurl').val();
					var ajaxtplprvwurl = $('#ajaxtplprvwurl').val();
					var ajaxtpldrpdwnurl = $('#ajaxtpldrpdwnurl').val();
					
					$.ajax({
						type:"POST",
						url:submiturl,
						data:data,
						success:function(result){
							if(result.trim() != 0){
								$('#saveasForm')[0].reset();
								$('#responsive').modal('hide');
								$.post(ajaxtpldrpdwnurl, {tplId:result.trim(), tplFor:tplFor}, function(res){
									$('#pgtplDrpDown').html(res);
								});
								
								$.ajax({
									type:'POST',
									url:ajaxtplprvwurl,
									data:{id:result.trim()},
									beforeSend : function(res){
										$('#tplPreview').hide();
										$("#waitingDiv").show(); 
									},
									success:function(res){
										$("#waitingDiv").hide(); 
										$('#tplPreview').html(res).show();
										$('#saveBtnBox').show();
										$('#new_template_id').val(1);
									}
								});
							}
						}
					});
				}
			});
			
			$('#cancel-formbtn').click(function(e){
				e.preventDefault();
				$('#responsive').modal('hide');
			});
			
		},
	};
	
}();