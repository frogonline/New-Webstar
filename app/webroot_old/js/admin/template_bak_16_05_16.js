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
				}
			});
		}
	}
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
		
			e.preventDefault();
			/* var tplId = $(this).attr('data-templateid');
			var tplFor = $(this).attr('data-templateFor');
			var rowId = $(this).attr('data-rowid'); */
			var submitUrl = $(this).attr('data-url');
			
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
			var tplId = $(this).attr('data-templateid');
			var widgetId = $(this).attr('data-widgetId');
			
			var submitUrl = $(this).attr('data-url');
			var ajxtplUrl = $(this).attr('data-ajaxtplpreview');
			
			if(confirm('Do You want to clone it?')){
				$.ajax({
					type:'POST',
					url:submitUrl,
					data:{colId:colId, widgetId:widgetId,pageid:pageid},
					success:function(result){
						//alert(result);
						if(result.trim()==1){
							$.post(ajxtplUrl, {id:tplId}, function(res){
								$('#tplPreview').html(res);
							});
							alert('Please save the page to see the effect of the cloned widgets in the front end.');
							toastr.success('Widget Cloned Successfully', 'Success :',{closeButton:true});
						}
					}
				});
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
			EditSidebarCol();
			ChooseShortcodeBox();
			AddChildCol();
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