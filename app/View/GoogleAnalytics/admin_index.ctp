<section class="content">
  	<div class="row">  		
        <div class="col-md-10">
        	<section class="head-sort">
	        	<div class="row">
	        		<div class="col-md-12">
	        			<!-- <form class="form" method="post">	        			 -->
	        			<?php 	        			
	        			echo $this->Form->create('User', array('class'=>"form", "type"=>"post", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
	        				<div class="input-group input-group-sm" style="width: 320px;">
		        				<span class="input-group-btn">
									<div class="btn btn-default"><i class="fa fa-calendar"></i></div>
								</span>
								<?php 
								$ga_date = $this->Session->read('GoogleAnalytics.daterange');
								if( !empty($ga_date) ){
									$date = $ga_date;
								}else{

									$date = date('m/d/Y', strtotime(NOW.' -29 day'))." - ".date('m/d/Y', strtotime(NOW.' -1 day'));
								}?>
								<!-- <input type="text" class="form-control datepicker daterange" name="daterange" value="<?//=(get('daterange') != '')?get('daterange'):$date?>"> -->
								<input type="text" class="form-control datepicker daterange" name="daterange" value="<?php echo $date; ?>">
								<span class="input-group-btn">
									<button class="btn btn-default btn-flat btnDateRange" type="submit">Submit</button>
								</span>
							</div>
	        			</form>
	        		</div>
	        	</div>
        	</section>
        	
			<div class="sessionschart"></div>
			
        </div>
    </div>
</section>
<script type="text/javascript">
	var PATH = '<?php echo SITE_URL ?>';	
	//var token = '1815a2fdae1ca4854a4936f450ed4296';
	var token = '';
	var list_chart = [];
</script>
<script type="text/javascript" src="<?php echo SITE_URL ?>/js/admin/google_analytics/main.js"></script>