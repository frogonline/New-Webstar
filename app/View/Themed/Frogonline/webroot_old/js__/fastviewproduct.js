function fastviewproduct(a)
{
	var productId = $(a).attr('data-id');
	var dataURL = $(a).attr('data-url');
	$.ajax({
		type:'POST',
		url:dataURL,
		data:{id:productId},
		success:function(result){
			//alert(result);
			$("#product-pop-up").html(result);
		}
		
	});
	
	return false;
	
}