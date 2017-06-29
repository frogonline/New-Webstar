<?php
	$statusArr = array('Y'=>'Active','N'=>'Inactive');
	$currentModelPer=$this->Session->read('currentModelPer');
	//pr($currentModelPer);
?>

<div class="row" style="padding:10px 0 10px 0;">
	<div class="col-md-12">
		<?php 
		if($currentModelPer['delete']=='Y')
		{
		echo $this->Form->button('<span class="fa fa-trash-o"></span> Delete All', array('type' => 'submit', 'id'=>'deleteAll', 'class'=>"btn red"));
		}
		?>
		<?php echo $this->Html->link('<i class="fa fa-times"></i> Reset Search', array('controller'=>'Faqs','action'=>'admin_index'), array('class'=>"btn red filter-cancel", 'style'=>'float:right;', 'escape'=>false)); ?>

	</div>
</div>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-cogs"></i>Lists of FAQs
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<?php if(count($data) > 0){ ?>
		<?php echo $this->Form->create('Faq', array('action' => 'admin_index', 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
		<table class="table table-bordered table-striped table-condensed flip-content">
		<thead class="flip-content">
		<tr>
			<td class="table-checkbox" width="5%" align="center">
				<!--<input type="checkbox" class="group-checkable" data-set=".table .checkboxes"/>-->
				<?php echo $this->Form->checkbox('selectAll', array('hiddenField' => false, 'class'=>'group-checkable', 'data-set'=>'.table .checkboxes')); ?>
			</td>
			<td class="numeric" width="5%" align="center"></td>
			<td width="15%" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('category_id', 'Category',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('faq_questions', 'Ouestions',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			<td class="numeric" align="center" style="font-weight:bold">
				<?php echo $this->Paginator->sort('faq_answers', 'Answers',array('escape' => false, 'class'=>'sorting_both')); ?>
			</td>
			
			<td width="15%" align="center" style="font-weight:bold">
				Status
			</td>
			<td width="20%" align="center" style="font-weight:bold">
				Action
			</td>
		</tr>
		
		<tr role="row" class="filter">
		<td></td>
		<td></td>
		<td>
			<?php echo $this->Form->input('category_id', array(
													'options' => $faqcat,
													'empty' => 'Select Category',	
													'class' => 'form-control',
																'selected'=> (isset($searchData['Faq']))?$searchData['Faq']['category_id']:''
															));?>
		</td>
		<td align="center">
			<?php //echo $this->Form->input('faq_questions',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Faq']))?$searchData['Faq']['faq_questions']:'')); ?>
		</td>
		<td align="center">
			<?php echo $this->Form->input('faq_answers',array('type'=>'text', 'class'=>'form-control form-filter input-sm','value'=>(isset($searchData['Faq']))?$searchData['Faq']['faq_answers']:'')); ?>
		</td>
		<td align="center">
			<?php 
				echo $this->Form->input('status', 
					array(
						'options' => $statusArr,
						'empty' =>'Status',	
						'class' => 'form-control',
						'selected' => (isset($searchData['Faq']))?$searchData['Faq']['status']:''
					)); 
			?>
		</td>
		<td>
			<div align="center" class="margin-bottom-5">
				<?php echo $this->Form->button('<i class="fa fa-search"></i> Search', array('type' => 'submit', 'class'=>"btn btn-sm yellow filter-submit margin-bottom", 'escape'=>false)); ?>
			</div>
		</td>
	</tr>
		</thead>
		<tbody>
		
		<?php
			foreach($data as $faq){
				?>
				<tr>
					<td align="center">
						<!--<input type="checkbox" class="checkboxes" value="1"/>-->
						<?php echo $this->Form->checkbox('select', array('hiddenField' => false, 'class'=>'checkboxes', 'value'=>$faq['Faq']['id'])); ?>
					</td>
					<td>
						<center>
							<?php 
							if($currentModelPer['edit']=='Y')
					        {
							if($faq['Faq']['status']=='Y'){
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Faqs', 'action'=>'admin_status/'.$faq['Faq']['id'].'/N'), array('escape'=>false, 'class'=>'row-status-active','confirm'=>'Are you sure?')); 
							} else {
								echo $this->Html->link('<span class="fa fa-circle"></span>', array('controller'=>'Faqs', 'action'=>'admin_status/'.$faq['Faq']['id'].'/Y'), array('escape'=>false, 'class'=>'row-status-inactive','confirm'=>'Are you sure?')); 
							}
							}
							?>
						</center>
					</td>
					<td align="center">
						<?php echo $faqcat[$faq['Faq']['category_id']]; ?>
					</td>
					<td align="center">
						<?php echo $faq['Faq']['faq_questions']; ?>
					</td>
					<td align="center">
						<?php 
						$length=strlen($faq['Faq']['faq_answers']);
						if($length>200)
						{
						$shotresult=substr($faq['Faq']['faq_answers'], 0, 180);
						echo $shotresult.'.................';
						}
						else
						{
							echo $faq['Faq']['faq_answers'];
						}
						?>
					</td>
					<td align="center">						
						<?php 
							echo ($faq['Faq']['status']=='Y')?'<span class="label label-success">':'<span class="label label-danger">';
							echo isset($faq['Faq']['status'])?$statusArr[$faq['Faq']['status']]:'';
							echo '</span>';				
						?>
					</td>
					
					<td class="numeric" align="center">
					<div class="col-md-6">
						<?php
						if($currentModelPer['edit']=='Y')
							{
							
							echo $this->Html->link($this->Html->image(IMGPATH1.'edit.png', array('alt'=>'loading..','Title'=>'Edit')), array('controller'=>'Faqs', 'action'=>'admin_manage/'.$faq['Faq']['id']), array('escape'=>false, 'full_base'=>true, 'class'=>''));
							
							
							}
						?>
					</div>
					<div class="col-md-6">
					  <?php	
						if($currentModelPer['delete']=='Y')
						{
							echo $this->Html->link($this->Html->image(IMGPATH1.'delete.png', array('alt'=>'loading..','Title'=>'Delete')), array('controller'=>'Faqs', 'action'=>'admin_delete/'.$faq['Faq']['id']."/1"), array('escape'=>false, 'full_base'=>true,'confirm' => 'Do you really want to delete this record?', 'class'=>''));
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
				<div class="note note-info"> 
					<center>No Record Found</center>
				</div>
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
				var url = '<?php echo $this->Html->url(array('controller'=>'Faqs','action'=>'admin_deleteAll'), array('full_base'=>true)); ?>/'+idAll+'/1';
				window.location.href = url;
			}
		} else {
			alert('Please select at least one row.');
		}
	});
});
</script>