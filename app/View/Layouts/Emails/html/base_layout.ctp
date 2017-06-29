<?php
	$admin_set =  $this->Session->read('siteSettings');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $subject; ?></title>
</head>

<body>
<div style="width:600px; margin:0 auto;">
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="background-color:#FFFFFF;">
	<tbody>
	  <tr>
		<td valign="top" align="center" style="margin:0;padding:0;"><table width="600" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="width:600px;border:0px none;font-size:12px;font-family:Tahoma, Verdana, Arial, sans-serif;color:#333333;">
			<tbody>
			  <tr>
				<td width="600" align="center" style="margin:0;padding:0;"><table width="580" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="width:580px;border:0px none;font-size:12px;font-family:Tahoma, Verdana, Arial, sans-serif;color:#333333;">
					<tbody>
					  <tr>
						<td width="580" valign="middle" height="60" align="right" style="margin:0;padding:0 18px 0 0;font-family:Tahoma, Verdana, Arial, sans-serif; color:#ffffff; background:url('.SITE_UTL.'assets/admin/layout/img/toorak.png);" colspan="2"><a href="<?php echo $base_url; ?>" target="_blank" style="text-decoration:none;outline:none;color:#ffffff;font-family:Tahoma, Verdana, Arial, sans-serif;" rel="nofollow"> <img width="131" height="41" alt="<?php echo $admin_set['SiteSetting']['com']?>" title="<?php echo $admin_set['SiteSetting']['com']?>" src="<?php echo IMGPATH;?>admin_logo/thumb/<?php  echo $admin_set['SiteSetting']['admin_logo']; ?>"></a></td>
					  </tr>
					  <tr>
						<td width="580" valign="middle" bgcolor="1a1a1a" align="left" style="margin:0;padding:0;" colspan="2"><p style="padding:5px 10px;color:#ffffff;font-size:16px;font-weight:bold;margin:0;font-family:Tahoma, Verdana, Arial, sans-serif;"> <b><?php echo $subject; ?></b></p></td>
					  </tr>
					  <?php echo $content_for_layout;?>
					  <tr>
						<td valign="top" align="left" style="padding:36px 0 20px 0;margin:0;" colspan="2"><table width="100%" cellspacing="0" cellpadding="0" border="0" style="width:580px;border:0px none;font-size:12px;font-family:Tahoma, Verdana, Arial, sans-serif;color:#333333;">
							<tbody>
							  <tr>
								<td width="45" align="left" style="padding:0;margin:0;"><p style="font-family:Tahoma, Verdana, Arial, sans-serif; margin:0;padding:10px 0 0 0;font-size:12px;"> <?php  echo $admin_set['SiteSetting']['com']; ?> | <a href="<?php echo $base_url; ?>" target="_blank" style="color:#000;font-weight:bold;font-size:12px;text-decoration:none;" rel="nofollow"><?php echo $base_url; ?></a> </p></td>
							  </tr>
							</tbody>
						  </table></td>
					  </tr>
					</tbody>
				  </table></td>
			  </tr>
			</tbody>
		  </table></td>
	  </tr>
	</tbody>
</table>
</div>
</body>
</html>