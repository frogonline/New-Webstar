<div class="col-md-11 col-md-offset-1">
	<div class="page-nav row">
		<div class="row">
			<div class="col-sm-4 text-left hidden-xs">
				<?php
				echo $this->Paginator->prev(
					'<div class="over"><i class="fa fa-chevron-left"></i>PREV</div>',
					array('escape'=>false, 'class'=>'button solid blue md'),
					null,
					array('class' => 'button solid blue md')
				);
				?>
			</div>

			<div class="col-xs-3 text-left visible-xs">
				<?php
				echo $this->Paginator->prev(
					'<div class="over"><i class="fa fa-chevron-left"></i></div>',
					array('escape'=>false, 'class'=>'button solid blue md'),
					null,
					array('class' => 'button solid blue md')
				);
				?>
			</div>

			<div class="col-sm-4 col-xs-6">
				<div class="pages text-center">
					<?php 
					echo $this->Paginator->numbers(array(
						'separator'=>'', 
						'tag'=>'span', 
						'class'=>'page',
						'currentClass'=>'page active',
						'currentTag'=>''
						)); 
					?>
				</div>
			</div>

			<div class="col-sm-4 text-right hidden-xs">
				<?php
				echo $this->Paginator->next(
					'<div class="over">NEXT<i class="fa fa-chevron-right"></i></div>',
					array('class'=>'button solid blue md', 'escape'=>false),
					null,
					array('class' => 'button solid blue md')
				);
				?>
			</div>
			
			<div class="col-xs-3 text-right visible-xs">
				<?php
				echo $this->Paginator->next(
					'<div class="over"><i class="fa fa-chevron-right"></i></div>',
					array('class'=>'button solid blue md', 'escape'=>false),
					null,
					array('class' => 'button solid blue md')
				);
				?>
			</div>
		</div>
	</div>
</div>