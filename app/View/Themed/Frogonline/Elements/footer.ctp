<footer>
  <div id="footer" class="fottertop_backgound">
    <div class="container">
      <div class="row">
        <?php 
			$blocks = $this->Footer->footerBlock();
			if(!empty($blocks)){
				foreach($blocks['FooterColumn'] as $blockitem){
			?>
        <div class="col-sm-6 col-md-<?php echo $blockitem['column']; ?> main-el cstm-img-responsive">
          <?php if(!empty($blockitem['name'])) { ?>
          <div class="sep-heading-container shc4 clearfix">
            <h4 class="footer-heading fottertop_control"><?php echo $blockitem['name']; ?></h4>
            <div class="sep-container">
              <div class="the-sep"></div>
            </div>
          </div>
          <?php } ?>
          <?php echo $this->ShortCode->make_content($blockitem['shortcode']); ?> </div>
        <?php
				}
			}
			?>
      </div>
    </div>
  </div>
  <div id="botbar" class="fotterbutton_backgound">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <p class="fotterbutton_control"><?php echo (!empty($siteSettings))?(!empty($siteSettings['SiteSetting']['copyright']))?$siteSettings['SiteSetting']['copyright']:'':''; ?></p>
        </div>
        <!--<div class="col-sm-5"> <span class="socials fotterbutton_control">
          <?php
						$socialIcons = $this->Footer->socialWidget();
						pr($socialIcons);
						if(!empty($socialIcons)){
							foreach($socialIcons as $icon){
								echo $this->Html->link('<i class="fa fa-'.$icon['SocialWidget']['class'].' fotterbutton_control"></i>', $icon['SocialWidget']['link'], array('class'=>$icon['SocialWidget']['link_class'], 'data-toggle'=>'tooltip', 'title'=>$icon['SocialWidget']['title'], 'target'=>'_blank', 'escape'=>false));
								echo '&nbsp;';
							}
						} 
						?>
          </span> </div>-->
      </div>
    </div>
  </div>
</footer>
