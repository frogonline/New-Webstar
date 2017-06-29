

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-table"></i>Lists of Record
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($formalldataArr) > 0){ ?>
		
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
			<tr>
				<th class="numeric" width="3%">No</th>
				<th class="numeric col-md-2" style="font-weight:bold">
					
					<center>Date</center>
				
				</th>
				<th class="numeric col-md-5" style="font-weight:bold">
					
					<center>Form Content</center>
					
				</th>
				<th class="numeric col-md-5" style="font-weight:bold">
					
					<center>File</center>
				
				</th>
				
				
			</tr>
		</thead>
		<tbody>
		
		<?php
		$i=1;
		foreach($formalldataArr as $item){
			?>
			<tr>
				<td>
				<?php echo $i; ?>
				</td>
				<td  class="numeric col-md-2">
					
					<center><?php echo $item['FormSaveRecord']['submit_date']; ?></center>
				
				</td>
				<td align="left" class="numeric col-md-5">
					
					<?php echo $item['FormSaveRecord']['form_content']; ?>
				
				</td>
				<td class="numeric col-md-5" style="width:175px;" align="left">
					
					<?php 
					
					foreach($item['FormImage'] as $imagename)
					{
			 
					$exten=explode('.',$imagename['image_name']);
					$extension =end($exten);
					$extensionlow =strtolower($extension);
					
					if($extensionlow=='png' || $extensionlow=='jpg' || $extensionlow=='jpeg' || $extensionlow=='gif' || $extensionlow=='bmp'){	
					echo $this->Html->link($this->Html->image(SITE_URL.'img/uploads/form_image/'.$imagename['image_name'], array('alt'=>'File', 'class'=>'img-responsive imagesizebug')),SITE_URL.'img/uploads/form_image/'.$imagename['image_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'class'=>'col-md-2','style'=>'display: block; text-align: center;width: 30%;')); 
					}
					
					 if($extensionlow=='doc' || $extensionlow=='docx'){
					 	echo $this->Html->link($this->Html->image(SITE_URL.'resources/word_document.png', array('alt'=>'File', 'class'=>'img-responsive imagesizebug')),SITE_URL.'img/uploads/form_image/'.$imagename['image_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'class'=>'col-md-2','style'=>'display: block; text-align: center;width: 30%;'));
					 
					 }
					 
					  if($extensionlow=='xls' || $extensionlow=='xlsx' || $extensionlow=='xlsm' || $extensionlow=='xlsb'){
					  
					  echo $this->Html->link($this->Html->image(SITE_URL.'resources/Excel_File.png',array('alt'=>'File', 'class'=>'img-responsive imagesizebug')),SITE_URL.'img/uploads/form_image/'.$imagename['image_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'class'=>'col-md-2','style'=>'display: block; text-align: center;width: 30%;'));
					  
					  
					  }
					  if($extensionlow=='pdf'){
					   echo $this->Html->link($this->Html->image(SITE_URL.'resources/pdfimage.png',array('alt'=>'File', 'class'=>'img-responsive imagesizebug')),SITE_URL.'img/uploads/form_image/'.$imagename['image_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'class'=>'col-md-2','style'=>'display: block; text-align: center;width: 30%;'));
					  
					  
					  } if($extensionlow=='xps'){
					  
					   echo $this->Html->link($this->Html->image(SITE_URL.'resources/file_folder.png',array('alt'=>'File', 'class'=>'img-responsive imagesizebug')),SITE_URL.'img/uploads/form_image/'.$imagename['image_name'], array('escape'=>false, 'target'=>'_blank', 'full_base'=>true,'class'=>'col-md-2','style'=>'display: block; text-align: center;width: 30%;'));
					  
					  }
			
					}
					?>
					
				</td>
				
			</tr>
			<?php
			$i++;
		}
		?>
		</tbody>
		</table>
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
				var url = '<?php echo $this->Html->url(array('controller'=>'FormTables','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll;
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>