<?php

class EcommerceFooterHelper extends AppHelper {

	var $helpers = array('Cache','Html','Session','Form','Paginator','ShortCode');

	

	

	public function footer_block(){

		App::import('Model', 'FooterBlock');

		$footer_block = new FooterBlock();

		$blockArray = $footer_block->find('all',array('conditions'=>array('footer_block'=>'ecommerce','is_del'=>'0','is_active'=>'Y'),

									'order'=>array('order ASC')	

								));

								

		

		

?>		

		<div class="pre-footer">

			<div class="container">

				<div class="row">

				<!-- BEGIN BOTTOM ABOUT BLOCK -->

				<?php foreach($blockArray as $block){ ?>

				<div class="col-md-3 col-sm-6 pre-footer-col">

					<h2><?php echo $block['FooterBlock']['title']; ?></h2>

					<p><?php echo $this->ShortCode->make_content($block['FooterBlock']['block_content']); ?></p>

				</div>

				<?php }?>

				<!-- END BOTTOM ABOUT BLOCK -->	

				</div>

			</div>

		</div>

<?php

	}

	

}

?>