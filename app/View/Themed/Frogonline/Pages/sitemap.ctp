<?php
				
$default = array(
				'menu_slug' => 'header-menu',
				'container_div' => false,
				'container_class' => '',
				'container_id' => '',
				'item_class' => '',
				'submenu_class' => 'dropdown-menu',
				'item_wrap' => '',
				'after_item' => 'span',
				'after_item_class' => 'main-text-color light',
				'hasChildli_class' => 'dropdown closed',
				'menu_id' => ''
			);
$menu = $this->MenuitemMasters->cp_menumap($default); 
//pr($menu);
				
?>
<style type="text/css">
#cont{
background-color: #DDD;
font: normal 80%;
margin:0;
text-align:center;

}
#cont{
margin:auto;
width:60%;
text-align:left;
}
a:visited {

text-decoration: underline;
}

h1 {
background-color:#fff;
padding:20px;

text-align:left;
font-size:40px;
margin:0px;
}
h3 {
font-size:30px;
background-color:#B8DCE9;
margin:0px;
padding:10px;

text-align:center
}
h3 a {
float:right;
font-weight:normal;
display:block;
}
th {
text-align:center;
background-color:#00AEEF;
color:#fff;
padding:4px;
font-weight:normal;
font-size:30px;
}
td {
font-size:20px ;
padding:3px;
text-align:left;
}
tr {background: rgb(243, 243, 243)}
tr:nth-child(odd) {background: rgb(243, 243, 243)}

.pager,.pager a {
background-color:#00AEEF;

padding:3px;
}
.lhead {
background-color:#fff;
padding:3px;
font-weight:bold;
font-size:30px;
}
.lpart {
background-color:#F3F3F3;
padding:0px;
}
.lpage {

    padding-left: 60px;
    text-transform: capitalize;
	padding-bottom:10px;

}
.lcount {
    background-color: #00AEEF;
   
    padding: 5px 10px;
    margin: 2px;
    font: bold 18px verdana;
}
a.aemphasis {

font-weight:bold;
}
.l-sub {
    padding-left: 90px;
    font-size: 16px; 
}
.l-sub a {
   
}
.lpage > a {
 
}
</style>

<div id="cont">
<h1 style="text-align:center">Site Map</h1>



<table width="100%" cellspacing="0" cellpadding="0" border="5">
	<tbody>
		<tr valign="top">
			<td colspan="100" class="lpart">
			
			
			
			<h3><a href="<?php echo SITE_URL; ?>"></a><?php echo $counsitemap; ?> pages are active in this site</h3>

			<table width="100%" cellspacing="0" cellpadding="0" border="1">
				<tbody>
				<?php 
				$i=1;
				foreach($sitemap as $data1)
				{	
				?>
					<tr>
						<td class="lpage"><?php echo $i.'. '; ?><a title="<?php echo $data1['Page']['title']; ?>" href="<?php echo $data1['Page']['page_url']; ?>"><?php  echo $data1['Page']['title']; ?></a></td>
					</tr>
					
				<?php 
				$i++;
				} 
				?>	
				</tbody>
			</table>
			</td>
		</tr>
	
		
		
	</tbody>
</table>
</div>
<br/>
