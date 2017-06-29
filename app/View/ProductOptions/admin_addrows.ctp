<tr class="option_div">
	<?php echo $this->Form->input('id',array('type' => 'hidden','name'=>'data[OptionValue][id][]', 'value'=>$item['id']) ); ?>
	<?php echo $this->Form->input('itemnu', array('type' => 'hidden', 'class' => '','label'=>false, 'value' => $divNo,'id'=>$divNo, 'name'=>'data[OptionValue][itemnu][]')); ?>
	<td>
	<?php echo $this->Form->input('option_value_name',array('type' => 'text','name'=>'data[OptionValue][option_value_name][]', 'class' => 'form-control','label'=>false, 'data-required'=>1, 'placeholder' => 'Option Value items') ); ?>
	</td>

	<td>
	<?php echo $this->Form->input('option_sort_order',array('type' => 'text','name'=>'data[OptionValue][option_sort_order][]', 'class' => 'form-control','label'=>false, 'data-required'=>1, 'placeholder' => 'Option Value Order') ); ?>
	</td>

	<td>
	<span style="color:red; font-size:20px; margin-left: 39px; cursor:pointer !important;">
	<?php echo $this->Html->link('<i class="fa fa-trash-o"></i> Remove','javascript:void(0);', array('class'=>'btn default btn-sm delete_option rmvRow','escape'=>false,'confirm' => 'Are you Sure?')); ?>
	
	<!--<a href="javascript:void(0);" class="btn default btn-sm delete_option" id="<?=$option_res1['id']?>"><i class="fa fa-times"></i> Remove </a>-->
	</span>
	</td>
</tr>

<script type="text/javascript">
$(function(){
$('.rmvRow').click(function(e){
		e.preventDefault();
		$(this).parents(".option_div").remove();
	});
	
});
</script>