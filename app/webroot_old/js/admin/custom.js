/**** Custom Javascript ****/

$(function(){
	$('.alert').click(function(e){
		e.preventDefault();
		$(this).remove();
	});
	
	jQuery('.table .group-checkable').change(function () {
		var set = jQuery(this).attr("data-set");
		var checked = jQuery(this).is(":checked");
		jQuery(set).each(function () {
			if (checked) {
				$(this).attr("checked", true);
			} else {
				$(this).attr("checked", false);
			}
		});
		jQuery.uniform.update(set);
	});				
	
	
	/*Priyankar:fix for input and select field issue for CKEDITOR within bootstrap modal */
	$.fn.modal.Constructor.prototype.enforceFocus = function() {
	  modal_this = this
	  $(document).on('focusin.modal', function (e) {
	    if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
	    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
	    && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
	      modal_this.$element.focus()
	    }
	  })
	};



	
	
});