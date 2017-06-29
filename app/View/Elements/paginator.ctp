<?php 
    //print_r($this->Paginator);
	if($this->Paginator->counter('{:count}') > PAGINATION_PER_PAGE_LIMIT){ 
?>
<div class="row">
	
	
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

<!--<div class="col-md-11 col-md-offset-1">
                            <div class="page-nav row">
                                <div class="row">
                                    <div class="col-sm-4 text-left hidden-xs">
                                        <a class="button solid blue md">
                                            <div class="over">
                                                <i class="fa fa-chevron-left"></i>PREV
                                            </div>
                                        </a>
                                    </div>
									
									<?php echo $this->Paginator->prev(__('<i class="fa fa-chevron-left"></i>PREV'), 
										array('tag'=>'div', 'class'=>' col-sm-4 text-left hidden-xs prev'), 
										array('class'=>'button solid blue md'), 
										array('tag'=>'div', 'class'=>' col-sm-4 text-left hidden-xs prev disabled', 'disabledTag'=>'a')
									); ?>

                                    <div class="col-xs-3 text-left visible-xs">
                                        <a class="button solid blue md">
                                            <div class="over">
                                                <i class="fa fa-chevron-left"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-sm-4 col-xs-6">
                                        <div class="pages text-center">
                                            <a class="page active">1</a>
                                            <a class="page">2</a>
                                            <a class="page">3</a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 text-right hidden-xs">
                                        <a class="button solid blue md">
                                            <div class="over">
                                            NEXT<i class="fa fa-chevron-right"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xs-3 text-right visible-xs">
                                        <a class="button solid blue md">
                                            <div class="over">
                                                <i class="fa fa-chevron-right"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>  -->
<?php 
	} 
?>