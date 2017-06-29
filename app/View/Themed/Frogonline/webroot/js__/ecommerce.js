function wishlist(el){
	var id = $(el).attr('id');
	var product_id = $(el).attr('data-product_id');
	var member_id = $(el).attr('data-member_id');
	var submitUrl = $(el).attr('data-url');
	
	if((product_id.trim()!="") && (member_id.trim()!="")){
		$.ajax({
			type:'POST',
			url:submitUrl,
			data:{product_id:product_id, member_id:member_id},
			success:function(result){
				if(result.trim()=='A'){
					$('#'+id).find('i').removeClass('fa-heart-o');
					$('#'+id).find('i').addClass('fa fa-heart');
					$('#'+id).find("i").animate({fontSize:'30px'});
					$('#'+id).find("i").animate({fontSize:'14px'});
					toastr.success('Product added to wishlist', 'Success :',{closeButton:true});
					$('#'+id).attr('title', 'Remove from wishlist');
				} else if(result.trim()=='R'){
					$('#'+id).find('i').removeClass('fa-heart');
					$('#'+id).find('i').addClass('fa fa-heart-o');
					$('#'+id).find("i").animate({fontSize:'30px'});
					$('#'+id).find("i").animate({fontSize:'14px'});
					toastr.success('Product removed from wishlist', 'Success :',{closeButton:true});
					$('#'+id).attr('title', 'Add to wishlist');
				} else {
					alert('Failed to add this product to wishlist.');
				}
			}
		});
	}
	return false;
}



function wishlistproduct(el){
	var id = $(el).attr('id');
	var product_id = $(el).attr('data-product_id');
	var member_id = $(el).attr('data-member_id');
	var submitUrl = $(el).attr('data-url');
	
	if((product_id.trim()!="") && (member_id.trim()!="")){
		$.ajax({
			type:'POST',
			url:submitUrl,
			data:{product_id:product_id, member_id:member_id},
			success:function(result){
				if(result.trim()=='A'){
					$('#'+id).find('i').removeClass('fa-heart-o');
					$('#'+id).find('i').addClass('fa fa-heart');
					//$('#'+id).find("i").animate({fontSize:'30px'});
					//$('#'+id).find("i").animate({fontSize:'14px'});
					toastr.success('Product added to wishlist', 'Success :',{closeButton:true});
					$('#'+id).attr('title', 'Remove from wishlist');
					$('#'+id+' .over').html('<i class="fa fa-heart"></i>REMOVE WISHLIST');
					$('#'+id).removeClass('green');
					$('#'+id).addClass('red');
				} else if(result.trim()=='R'){
					$('#'+id).find('i').removeClass('fa-heart');
					$('#'+id).find('i').addClass('fa fa-heart-o');
					//$('#'+id).find("i").animate({fontSize:'30px'});
					//$('#'+id).find("i").animate({fontSize:'14px'});
					toastr.success('Product removed from wishlist', 'Success :',{closeButton:true});
					$('#'+id).attr('title', 'Add to wishlist');
					//$('#'+id).find("i").html('ADD WISHLIST');
					$('#'+id+' .over').html('<i class="fa fa-heart-o"></i>ADD WISHLIST');
					$('#'+id).removeClass('red');
					$('#'+id).addClass('green');
					
				} else {
					alert('Failed to add this product to wishlist.');
				}
			}
		});
	}
	return false;
}

function removewishlist(el){
	var id = $(el).attr('id');
	var product_id = $(el).attr('data-product_id');
	var member_id = $(el).attr('data-member_id');
	var submitUrl = $(el).attr('data-url');
	
	if((product_id.trim()!="") && (member_id.trim()!="")){
		$.ajax({
			type:'POST',
			url:submitUrl,
			data:{product_id:product_id, member_id:member_id},
			success:function(result){
				if(result.trim()=='R'){
					$('#'+id).parents('.main-el').removeClass('col-md-4 col-sm-6').remove();
					/* $('#'+id).find('i').addClass('fa fa-heart-o');
					$('#'+id).find("i").animate({fontSize:'30px'});
					$('#'+id).find("i").animate({fontSize:'14px'}); */
				} else {
					alert('Failed to add this product to wishlist.');
				}
			}
		});
	}
	return false;
}

var Ecommerce = function () {
	var ProductLoadmore = function() {
		$('#product-loadmore').click(function(e){
			e.preventDefault();
			var conditionArr = $(this).attr('data-conditions');
			var limit = $(this).attr('data-limit');
			var offset = $(this).attr('data-offset');
			
			var submiturl = $(this).attr('data-url');
			var productcounturl = $(this).attr('data-productcounturl');
			$.ajax({
				type:'POST',
				url:submiturl,
				beforeSend:function(){
					$('#product-loadmore').find('span').hide();
					$('.ajax-preloader').show();
				},
				complete:function(){
					$('#product-loadmore').find('span').show();
					$('.ajax-preloader').hide();
				},
				data:{conditionArr:conditionArr, limit:limit, offset:offset},
				success:function(result){
					var totaloffset = parseInt(offset)+parseInt(limit);
					$('.product-list').append(result);
					$('#product-loadmore').attr('data-offset', totaloffset);
					
					$.post(productcounturl, {conditionArr:conditionArr}, function(result){
						
						if(parseInt(result.trim()) < totaloffset){
							$('#product-loadmore').hide();
							$('<div class="clearfix"></div><div class="alert alert-noicon"><center>That\'s All Folks! </center></div>').insertAfter('#product-loadmore');
						}
					});
				}
			});
		});
	}
	
	
    return {
        init: function () {
            ProductLoadmore();
			//AddtoWishlist();
        },
		
		/* AddtoWishlist: function() {
			$('.addtowishlist').click(function(e){
				e.preventDefault();
				var id = $(this).attr('id');
				var product_id = $(this).attr('data-product_id');
				var member_id = $(this).attr('data-member_id');
				var submitUrl = $(this).attr('data-url');
				
				if((product_id.trim()!="") && (member_id.trim()!="")){
					$.ajax({
						type:'POST',
						url:submitUrl,
						data:{product_id:product_id, member_id:member_id},
						success:function(result){
							if(result.trim()=='A'){
								$('#'+id).find('i').removeClass('fa-heart-o');
								$('#'+id).find('i').addClass('fa fa-heart');
								$('#'+id).find("i").animate({fontSize:'30px'});
								$('#'+id).find("i").animate({fontSize:'14px'});
							} else if(result.trim()=='R'){
								$('#'+id).find('i').removeClass('fa-heart');
								$('#'+id).find('i').addClass('fa fa-heart-o');
								$('#'+id).find("i").animate({fontSize:'30px'});
								$('#'+id).find("i").animate({fontSize:'14px'});
							} else {
								alert('Failed to add this product to wishlist.');
							}
						}
					});
				}
			});
		}, */
		
    };

}();