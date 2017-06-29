<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$sliderTypeArr = array('1'=>'Revolution Slider','2'=>'Normal Slider');
	$currentModelPer=$this->Session->read('currentModelPer');
?>
<?php 
if($currentModelPer['add']=='Y')
{
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i> Add New CMS Gallery
		</div>
	</div>
	<div class="portlet-body form">
		<?php echo $this->Form->create('CmsGallery', array('action' => 'admin_index', 'id'=>"addGalleryfrm", 'class'=>"horizontal-form", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<div class="form-body">
			<div class="row">
				
				<div class="col-md-6">
					<div class="form-group">
						<label>Gallery Name <span class="required"> * </span></label>
						<?php echo $this->Form->input('gallery_name',array('class'=>"form-control", 'placeholder'=>"Enter Gallery Title",'value'=>'', 'type'=>"text")); ?>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Gallery Style <span class="required"> * </span></label>
							
						<?php echo $this->Form->input('style',array('value'=>(isset($data['CmsGallery']))?$data['CmsGallery']['style']:'',  'data-required'=>1, 'class'=>"form-control",'id'=>"styid" ,'placeholder'=>"Enter Cms Gallery style", 'type'=>"text")); ?>  
						
					</div>
				</div>
				<div class="col-md-3">
				<?php 
					echo $this->Html->link('<i class="fa fa-edit"></i> Choose your Style', 'javascript:;', array('escape' => false,'full_base'=>true,'title'=>"Choose your Style",'class'=>'btn default green','data-target'=>"#stack1", 'data-toggle'=>"modal", 'style'=>'margin:25px 0 0 0;', 'div'=>false)
					);	
				?>	
				</div>
			</div>
		</div>
		<div class="form-actions fluid">
			<div class="col-md-offset-5 col-md-6">
				<?php echo $this->Form->button('Save', array('type' => 'submit', 'class'=>"btn blue"));?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php
}
?>

<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		?>
		<?php echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));?>
		<?php
		}
		?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'CmsGalleries','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false));?>
	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>List of CMS Gallery
		</div>
	</div>
	<div class="portlet-body flip-scroll">
	<?php if(count($data) > 0){ ?>
	<?php echo $this->Form->create('CmsGallery', array('url'=>array('controller'=>'CmsGalleries','action' => 'admin_index'), 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" align="center">
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td width="20%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('gallery_name', 'Gallery Title',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('style', 'Gallery Style',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				ShortCode
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		<tr role="row" class="filter">
		<td></td>
		<?php echo $this->Form->input('searchvalue',array("type"=>"hidden","label"=>false,"value"=>'searchvalue')); ?>
		<td>
			<?php echo $this->Form->input('gallery_name',array('type'=>'text','label'=>false,'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['CmsGallery']))?$searchData['CmsGallery']['gallery_name']:'')); ?>
		</td>
		<td>
		</td>
		<td></td>
		<td>
			<div align="center" class="margin-bottom-5">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
		</tr>
		
		</thead>
		<tbody>
		
		<?php
		
			foreach($data as $item){
				?>
				<tr>
					<td align="center">
						<?php 
							echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$item['CmsGallery']['id'])); 
						?>
					</td>
					<td align="center">
						<?php echo $item['CmsGallery']['gallery_name']; ?>
					</td>
					<td align="center">
						<?php echo $stylesArr[$item['CmsGallery']['style']]; ?>
					</td>
					<td align="center">
						<?php echo '[Banner-'.$item['CmsGallery']['id'].']'; ?>
					</td>
					<td class="numeric" align="center" style="width:160px">
					<div class="col-md-6">
						<?php
							if($currentModelPer['edit']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'CmsGalleries', 'action'=>'admin_manage/'.$item['CmsGallery']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							
							
							}
							?>
							</div>
							<div class="col-md-6">
							<?php
							if($currentModelPer['delete']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'CmsGalleries', 'action'=>'admin_delete/'.$item['CmsGallery']['gallery_slug']), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
							}
						?>
						</div>
					</td>
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
		<?php echo $this->element('admin_paginator'); ?>
		<?php echo $this->Form->end(); ?>
		<?php } else { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="note note-info"> <center>No Record Found</center></div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<div id="dialog" title="Basic dialog">
  
</div>

<div id="stack1" class="modal fade" tabindex="-1" data-width="400" >
								<div class="modal-dialog" style="height:5000px; width:1200px; z-index: 1050;">
									<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								    <h2>Select Style</h2>
									</div>
									
									<span for="PageTemplateRowsColumnColumn" class="help-block" style="display:none" id="validatefor1">Please Select any one Image</span>
									
									<?php echo $this->Form->create('testimonialdataform', array('id'=>"testimonialdataform", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>	
									<?php 
									if(!empty($banner_slider_styledata)){
										echo '<div class="modal-body">';
										echo '<div class="row">';
										foreach($banner_slider_styledata as $item){
											echo '<div class="col-md-4">';
												echo $this->Form->input('background_img', array(
														'options'=>array($item['style']['widgetstyle_name']=>$item['style']['name']),
														'type'=>'radio',
														'legend'=>false,
														'label'=>true,
														'hiddenField'=>false,
														'div'=>false
													)
												); 
												echo $this->Html->link($this->Html->image(IMGPATH.'style_img/'.$item['style']['style_img'], array('alt'=>'', 'class'=>'img-responsive')), IMGPATH.'style_img/'.$item['style']['style_img'], array('escape'=>false, 'class'=>'mix-preview fancybox-button') );
												
											echo '</div>';
										}
										        
										echo '</div>';
										echo '</div>';
									}
									?>
                                    <div class="modal-footer">
									<?php echo $this->Form->button('Ok', array('type' => 'button', 'class'=>"btn blue",'id'=>"ok")); ?>
									</div>									
								   <?php echo $this->Form->end(); ?>
                                           
								</div>
								
							</div>							
				
			
	</div>

<script type="text/javascript">
$(function(){
	$('#deleteAll').click(function(e){
		e.preventDefault();
		var idAll = [];
		var set = jQuery('.table .group-checkable').attr("data-set");
		
		jQuery(set).each(function () {
			var checked = jQuery(this).is(":checked");
			if (checked) {
				var presentId = $(this).val();
				idAll.push(presentId);
			}
		});
		if(idAll.length > 0){
			if(confirm('Are you sure ? ')){
				var url = '<?php echo $this->Html->url(array('controller'=>'CmsGalleries','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
	
	
	/***** Form Validation *****/
	var form3 = $('#addGalleryfrm');
	var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
		
	form3.validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		ignore: "", // validate all fields including form hidden input
		rules: {
			'data[CmsGallery][gallery_name]': {
				required: true
			},
			'data[CmsGallery][style]': {
				required: true
			}
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			error.insertAfter(element); // for other inputs, just perform default behavior
		},

		highlight: function (element) { // hightlight error inputs
		   $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label.closest('.form-group').removeClass('has-error'); // set success class to the control group
		}

	});
	
	$('#ok').click(function(e){
		if (!$("#testimonialdataform input[type='radio']:checked").val() ) 
		{  
			$('#validatefor1').show();
			return false;
		
		}
		e.preventDefault();
		var value1=$("#testimonialdataform input[type='radio']:checked").val();	
		//alert(value1);
		$('#stack1').modal("hide");
		$('#styid').val(value1);
	});	
	
});
</script>