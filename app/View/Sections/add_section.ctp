<tr>
	<td>
    	Page 
			<select id="SectionPageId" name="data[Section][page_id][]" class="form-control" style="width:200px;" >
            	<option value="" >Select Page</option>
                <?php
					foreach($pagelist as $key=>$value)
					{
					?>
                    	<option value="<?=$key?>"><?=$value?></option>
                    <?php
					}
				?>
            </select>
    </td>
	<td>
        Position
        <select id="SectionPosition" name="data[Section][position][]" class="form-control" style="width:200px;">
        	<option value="" >Select Position</option>
              <?php
					foreach($position as $key=>$value)
					{
					?>
                    	<option value="<?=$key?>"><?=$value?></option>
                    <?php
					}
				?>
        </select> 
	</td>
<td>
	Column
    <select id="SectionColumn" name="data[Section][column][]" class="form-control" style="width:200px;">
    	<option value="" >Select Column</option>
        		<?php
					foreach($column as $key=>$value)
					{
					?>
                    	<option value="<?=$key?>"><?=$value?></option>
                    <?php
					}
				?>
    </select>
</td>
<td>
	&nbsp;<a class="clearButton" style="cursor: pointer; cursor: hand;"><span>Clear</span></a>&nbsp;
	
</td>
<td>
    &nbsp;<a class="removeButton" style="cursor: pointer; cursor: hand;"><span>Remove</span></a> 
</td>
<td>
	&nbsp;<a class="addButton" style="cursor: pointer; cursor: hand;"><span>New</span></a> 
</td>
</tr>