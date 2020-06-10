<div id="mini_subscriber">
<strong>Receive a 4-week web subscription for free to view this story</strong>
<form action="/member/quickwebsubscribe" method="post">
	<table style="width: 100%;margin-top: 10px;">
		<tr>
			<td>First Name<br />
			<input class="textinput" type="text" name="name_first" value="<?=$this->Get('name_first')?>"></td>
			<td>Last Name<br /><input class="textinput" type="text" name="name_last" value="<?=$this->Get('name_last')?>"></td>
		<tr>
			<td>Email<br /><input type="text" class="textinput" name="email" value="<?=$this->Get('email')?>"></td>
			<td>Subscription type<br />
			<?=$this->outputSubscriptionTypeDropDown();?>
			<span style="font-size: 14pt;">Four week Web trial</span></td>
		</tr>
		
	</table>
	
	<fieldset>
	<legend style="color: #2E4F0A;">Please fill in the following information</legend>
	<table style="width: 100%;margin-top: 10px;">
			<tr>
				<td>Password<br /><input type="password" class="textinput" name="password_1" value=""></td>
				<td>Password<br /><input type="password" class="textinput" name="password_2" value=""></td>
			</tr>
	</table>
	</fieldset>
	
	
	<div style="text-align: center; padding: 8px 0px;">
		<input class="button_good" type="submit" value="Sign-up">
	</div>

</form>
</div>