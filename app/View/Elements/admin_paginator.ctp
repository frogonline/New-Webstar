<?php 
	if($this->Paginator->counter('{:count}') > PAGINATION_PER_PAGE_LIMIT){ 
?>
<div class="row">
	<div class="col-md-6" style="padding:10px 15px;"><?php
		echo $this->Paginator->counter(
			'Showing {:start} to {:end} of {:count} entries'
		);
	?></div>
	
	<div class="col-md-6">
		<ul class="pagination" style="float:right;"><?php
			echo $this->Paginator->prev(__('Previous'), 
										array('tag'=>'li', 'class'=>'prev'), 
										null, 
										array('tag'=>'li', 'class'=>'prev disabled', 'disabledTag'=>'a')
									);
			echo $this->Paginator->numbers(array('tag'=>'li', 'separator'=>' ', 'currentTag'=>'a', 'currentClass'=>'active')); 
			echo $this->Paginator->next(__('Next'), 
										array('tag'=>'li', 'class'=>'next'), 
										null, 
										array('tag'=>'li', 'class'=>'next disabled', 'disabledTag'=>'a')
									);
		?></ul>
	</div>
</div>
<?php 
	} 
?>