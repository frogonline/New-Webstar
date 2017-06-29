<tr>
	<td colspan="2" align="left" valign="top" width="580" style="margin:0px;padding:0px" bgcolor="ffffff">
		<p style="padding:25px 0px 20px;margin:0px;font-size:12px;color:rgb(51,51,51)">&nbsp;</p>
	</td>
</tr>
<tr>
	<td colspan="2" align="left" valign="top" width="580" style="margin:0px;padding:0px" bgcolor="ffffff">
		<table width="580" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td width="580" colspan="2" style="padding:0px;margin:0px">
						<p style="padding:0px 10px 0px 0px;margin:0px;font-size:12px">
							<?php
								if(!empty($body_varArr)){
									echo $body_text = str_replace(array_keys($body_varArr),array_values($body_varArr), $body_text);
								} else {
									echo $body_text;
								}
							?>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" align="left" valign="top" width="580" style="margin:0px;padding:0px" bgcolor="ffffff"><br></td>
</tr>