<?=$this->Get_Data('errors');?>
<div id="simpleform">

	<fieldset>
		<legend>A) Request a New Password</legend>
		<form action="" method="POST">
			<table>
				<tr>
					<td style="line-height: 30pt; font-size: 40pt; vertical-align: middle;width: 50px;">1</td>
					<td>
						Fill in your registered email address: <br />
						<input class="text" type="text" name="forgot_email_address" value="<? print $this->Get('forgot_email_address'); ?>" />
					</td>
				</tr>
				<tr>
					<td style="line-height: 30pt; font-size: 40pt; vertical-align: middle;width: 50px;">2</td>
					<td>
					<? if( $this->Get_Data('messages') ) {
						print $this->Get_Data('messages');
					} else {
					?> 
					<input class="button_good" style="font-size: 14pt; " type="submit" name="forgetsubmit" value="CLICK to send an EMAIL and request a new password" />
					<? } ?>
					</td>
				</tr>
				<tr>
					<td style="line-height: 30pt; font-size: 40pt; vertical-align: middle;width: 50px;">3</td>
					<td>Check your email and click the link to reset your password.</td>
				</tr>
			</table>
		</form>
	</fieldset>

</div>