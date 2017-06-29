	<tr>
			<td>
				<?php 
					echo $this->Form->input('option_value_id', array(
											'options' => $optionvalueArray,
											'empty' => '--Select--',
											'style'=> 'width:200px',
											'name'=>"data[ProductAssignNewOption][option_value_id][".$id."][]",
											'label'=>false,
											'class' => 'form-control optionvalues '.$id,
											'selected'=> (isset($data['Product']))?$data['Product']['product_taxclass']:''
										));
				?>
			</td>
            
			<td><input type="text" name="data[ProductAssignNewOption][Quantity][<?php echo $id;?>][]" class="form-control"/></td>
			
			
			<td>
			<select name="data[ProductAssignNewOption][operation][<?php echo $id;?>][]" class="form-control" style="width:38%; float:left; margin-right:10px">
			<option value="1">+</option>
			<option value="0">-</option>
			</select>
			<input style="width:40%" type="text" name="data[ProductAssignNewOption][operation_value][<?php echo $id;?>][]" class="form-control"/>
			</td>
			
			<td><input type="hidden" name="option_id[<?php echo $id;?>][]" value="<?php echo $id;?>" /><a href="javascript:;" onClick="$(this).closest('tr').remove();" class="btn default btn-sm"><i class="fa fa-times"></i> Remove </a></td>
	</tr>
	
