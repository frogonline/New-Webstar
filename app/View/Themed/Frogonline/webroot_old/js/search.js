$('#id').submit(function(e){
e.preventDefault();
		var input = $('#input').val();
		var path1 = $('#srch').val();

		if(input == ''){
		$('#i').html('<p style="color:red" class="alert alert-danger">Please type something to search</p>');
		return false;
		}else{
				$.ajax({
					type:'POST',
					url:path1,
					data:{input : input}
					});
					/* success:function(result){
					//var dataArray = jQuery.parseJSON(response);
						alert(result); */
						$('#form-search')[0].reset();
						//location.href="pages/form_search/"+result;
						/* if(result == 4){
							$('#i').html('<p style="color:red" class="success_msg">Contact details has been sent.</p>');
							$('#input')[0].reset();
						} else if(result == 3) {
							$('#i').html('<p class="error_msg">Failed to send mail.</p>');
						} else if(result == 1) {
							$('#i').html('<p class="error_msg">Please fill all fields.</p>');
						} */
					}
				

		//}

	});
	
	$('#i').click(function(){
		//e.preventDefault();
		$(this).find('p').remove();
	});
	 