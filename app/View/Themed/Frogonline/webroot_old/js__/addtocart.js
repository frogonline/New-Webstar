function add_to_cart(a)
{
	var data = $(a).serialize();
	var dataurl = $(a).find('.addtocarturl').val();
	var datashowurl = $(a).find('.showminicart').val();
	$('html,body').animate({scrollTop: 0, scrollRight: 0}, 'slow');
	$(a).animate('.top-cart-block i',{pixels_per_second: 1000,}); 
	
	$.ajax({
		url: dataurl,
		type: "POST",
		data: data,
		success:function(result){
			//alert(result);
			if(result.trim() == 1){
				$('#addtocartmsg').html('<p>Item added to cart</p>').show();
				$.post(datashowurl,function(result){
					//alert(result);
					$("#minicart").html(result);
					$('#nav-shop').addClass('in');
					$('#nav-shop').css('height','auto');
					//Layout.init();
				});
			}
		}
	});
	return false; 
}

function submitcart(id){
	$('#singlecart'+id).submit();
	//alert(id);
	return false;
}

$('#addtocartmsg').click(function(e){
	e.preventDefault();
	$(this).hide();
});

function fnDecrese(a){
	var qty = parseInt($(a).next().val());
	
	if(--qty!=0){
		$(a).next().val(qty);
	}else {

	toastr.error('Minimum 1 quantity needed to add to cart', {closeButton:true});
	
	}
	
}

function fnIncrese(a){
	var qty = parseInt($(a).prev().val());
	var limit = parseInt($(a).prev().attr('data-qty'));
	
	if(qty++!=limit){
		$(a).prev().val(qty);
	} else {

	toastr.error('Order Quantity exceeds stock quantity', {closeButton:true});
	}
	
	
}