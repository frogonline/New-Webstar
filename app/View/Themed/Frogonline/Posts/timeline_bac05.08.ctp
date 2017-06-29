<div class="container">
	<div class="row">
	<?php if(!empty($posts)){ ?>
	<div class="timeline clearfix col-md-12 hidden-xs">
                        <div class="row">
						<?php for($i=0; $i<count($posts); $i++) {
                         $commentcount=count($posts[$i]['PostComment']); 
						?>
						    <?php if($i<count($posts)) { ?>
                            <div class="col-sm-6">
                                <div class="main-el clearfix">
                                    <div class="element left">
                                        <div class="head">
                                           
                                        </div>
                                        <div class="body">
                                              <h5 class="medium"><?php echo $this->Html->link($posts[$i]['Page']['title'], SITE_URL.$posts[$i]['Page']['slug']); ?></h5>
                                            <p class="italic post-links">
											<?php
											echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$posts[$i]['Page']['slug'].'#comment');
											?>
											
										   </p>
                                            <p><?php echo $posts[$i]['Page']['summery'];  ?></p>
                                            <div class="clearfix"></div>
                                            <div class="bot clearfix">
												<div class="date italic">
													<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($posts[$i]['Page']['created_date'])))); ?>
												</div>
											</div>
                                        </div>
                                        <div class="attached">
                                            <div class="arrow"></div>
                                            <div class="dot"><i class="fa fa-circle main-text-color"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php } ?>
		                   <?php $i= $i+1; ?>
							<?php if($i<count($posts)) { ?>
                            <div class="col-sm-6">
                                <div class="main-el clearfix">
                                    <div class="element right">
                                        <div class="head">
                                            
                                        </div>
                                        <div class="body">
                                             <h5 class="medium"><?php echo $this->Html->link($posts[$i]['Page']['title'], SITE_URL.$posts[$i]['Page']['slug']); ?></h5>
                                            <p class="italic post-links">
											<?php
											echo $this->Html->link(($commentcount==0)?$commentcount.' comment':$commentcount.' comments', ($commentcount==0)?'javascript:void(0);':SITE_URL.$posts[$i]['Page']['slug'].'#comment');
											?>
											
										   </p>
                                            <p><?php echo $posts[$i]['Page']['summery'];  ?></p>
                                            <div class="clearfix"></div>
                                            <div class="bot clearfix">
												<div class="date italic">
													<?php echo date("d F Y", strtotime(date("d-m-Y", strtotime($posts[$i]['Page']['created_date'])))); ?>
												</div>
											</div>
                                        </div>
                                        <div class="attached">
                                            <div class="arrow"></div>
                                            <div class="dot"><i class="fa fa-circle main-text-color"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<?php } ?>
						<?php } ?>
							
                            <div class="spine">
                            </div>
                        </div>
                     </div>
					 
					<?php echo $this->element('blogpaginator');   } else { ?>
		<div class="alert alert-noicon sc">
			<div class="text col-md-12 col-sm-7">
				<center><strong>No posts available here.</strong></center>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php } ?>	 
	
	</div>
</div>