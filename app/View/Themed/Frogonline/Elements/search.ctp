 <?php
$siteSettings = $this->Session->read('siteSettings');
$blogtemplate=$siteSettings['SiteSetting']['blog_template'];
$blogtemplateaction=$blogtemplate.'/';
$ThemeSetting=$this->Session->read('ThemeSetting');
$ThemeSettingheadertype=$ThemeSetting['ThemeSetting']['header_type'];
?>
<?php if($ThemeSettingheadertype=='V'){?>
 <div id="search" class="panel-collapse collapse search-vertical submenu_searchcon">
<?php } else { ?>
<div id="search" class="panel-collapse collapse search-horizontal submenu_searchcon">
<?php } ?>
 
                <div class="container">
                    <div class="row">
					<?php if($ThemeSettingheadertype=='V'){?>
					
                        <div class="col-md-11 col-sm-12 col-xs-12">
						<?php }else{ ?>
						 <div class="col-xs-12">
						<?php } ?>
						<?php echo $this->Form->create('search',array('url'=>array('controller'=>'Generals','action' => 'lists'), 'id'=>"form_sample_5", 'class'=>"form-horizontal", "type"=>"file", 'inputDefaults' => array('required' => false, 'label' => false,'div' => false))); ?>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" value="s" id="search_id" class="btn btn-default dropdown-toggle submenu_leftsearch_backgound searchdrop_control" data-toggle="dropdown">Search In <span class="caret down"></span><span class="caret up"></span></button>
									  
									<button type="button" id="blog_search" style="display:none" class="btn btn-default dropdown-toggle submenu_leftsearch_backgound searchdrop_control" data-toggle="dropdown">Blog <span class="caret down"></span><span class="caret up"></span></button>
									
									<button type="button" id="shop_search" style="display:none" class="btn btn-default dropdown-toggle submenu_leftsearch_backgound searchdrop_control" data-toggle="dropdown">Shop <span class="caret down"></span><span class="caret up"></span></button>
									
									<button type="button" id="pages_search" style="display:none" class="btn btn-default dropdown-toggle submenu_leftsearch_backgound searchdrop_control" data-toggle="dropdown">Pages <span class="caret down"></span><span class="caret up"></span></button>
									<?php echo $this->Form->input('search-type-value',array("type"=>"hidden", 'id'=>'search-type-value', "label"=>false,"value"=>'')); ?>
									
                                    <ul class="dropdown-menu" id="dropdown-menu-id">
										<?php if($blogcount>0) {
											  if($siteSettings['SiteSetting']['blog_flag']=='Y'){
										?>
                                        <li ><a class="selecttype searchdrop_control submenu_leftsearch_backgound" value="Posts">Blog</a></li>
										<?php }
										}
										?>
										<?php
										 if($siteSettings['SiteSetting']['ecommerce_flag']=='Y')
										 {
										 ?>
										<li ><a class="selecttype searchdrop_control submenu_leftsearch_backgound" value="Products">Shop</a></li>
										<?php 
										}
										?>
                                        <li ><a class="selecttype searchdrop_control submenu_leftsearch_backgound" value="Pages">Pages</a></li>
                                    </ul>
                                </div>
								<?php echo $this->Form->input('searching-value',array("type"=>"text", 'id'=>'searching-value', "label"=>false, 'class'=>"form-control")); ?>
                                <span class="input-group-btn">
                <button class="btn btn-default button solid blue submenu_rightsearch_backgound" id="button_search" type="submit">
                                        <span class="over">
                                            <i class="fa fa-search magnify_glass"></i>
                                        </span>
                                    </button>
                                </span>
                            </div>
							<?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
$(function(){
	$(".selecttype").click(function(e){
	e.preventDefault();
	var typevalue = $(this).attr('value')
	if(typevalue=='Posts')
	{
		$('#blog_search').show();
		$('#search_id').hide();
		$('#pages_search').hide();
		$('#shop_search').hide();
		$('#search-type-value').val(typevalue);
	}
	if(typevalue=='Pages')
	{
		$('#pages_search').show();
		$('#search_id').hide();
		$('#shop_search').hide();
		$('#blog_search').hide();
		$('#search-type-value').val(typevalue);
	}
	if(typevalue=='Products')
	{
		$('#shop_search').show();
		$('#search_id').hide();
		$('#blog_search').hide();
		$('#pages_search').hide();
		$('#search-type-value').val(typevalue);
	}
		
	});
	$("#button_search").click(function(e){
		e.preventDefault();
		var value1= $('#search-type-value').val();
		var value2= $('#searching-value').val();
		
		 if(value1!='' && value2!='')
		{
				if(value1=='Posts')
				{
				window.location.href = '<?php echo SITE_URL."blog"; ?>'+'/search/'+value2;
				}
				if(value1=='Pages')
				{
				window.location.href = '<?php echo SITE_URL."page"; ?>'+'/search/'+value2;
				}
				if(value1=='Products')
				{
				window.location.href = '<?php echo SITE_URL."shop/search"; ?>'+'/'+value2;
				}
		}
		else if (value1 =='' && value2 =='')
		{
			return false;
		} 
		
	
	});
	
	
});
</script>