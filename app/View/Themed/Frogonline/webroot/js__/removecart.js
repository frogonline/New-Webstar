function removeminicart(a)
{
	
	var dataurl = $(a).attr('data-url');
	var dataminicarturl = $(a).attr('data-minicarturl');
	var dataid = $(a).attr('data-id');
	
	$.ajax({
		url: dataurl,
		type: "POST",
		data: {id:dataid},
		success:function(result){
			//alert(result);
			if(result.trim() == 1){
				$.post(dataminicarturl,function(result){
					//alert(result);
					$("#minicart").html(result);
					//Layout.init();
				});
			} else {
				alert('Failed to delete cart item.');
			}
			
		}
	});
	return false; 
}

function removecart(a)
{
	
	var dataurl = $(a).attr('data-url');
	var dataminicarturl = $(a).attr('data-minicarturl');
	var datafullcarturl = $(a).attr('data-fullcarturl');
	var dataid = $(a).attr('data-id');
	
	$.ajax({
		url: dataurl,
		type: "POST",
		data: {id:dataid},
		success:function(result){
			//alert(result);
			if(result.trim() == 1){
				$.post(dataminicarturl,function(result){
					//alert(result);
					$("#minicart").html(result);
					//Layout.init();
				});
				$.post(datafullcarturl,function(result){
					//alert(result);
					$("#shop-cart-block").html(result);
					//Layout.init();
				});

			} else {
				alert('Failed to delete cart item.');
			}
			
		}
	});
	return false; 
}