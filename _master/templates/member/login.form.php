<form action="/member/login" method="POST">
<?=$this->Get_Data('errors');?>
	<div id="login">
		<div class="content">
		<strong>Already a member? Login please.<br /><br />
			
			 Email Address<br /><input class="textinput" type="text" name="member_email" value="<?=$this->Get_Data('member_email');?>" /><br /><br />
			 Password<br /><input class="textinput"  type="password" name="member_password" value="<?=$this->Get_Data('member_password');?>" />
			<br />
			
			<br />
			<div style="text-align: left;padding-bottom: 6px; border-bottom: 1px #ccc solid;"><input type="checkbox" name="stay_logged_in" value="1"><span style="font-size: 10pt;">Stay logged in on this computer</span>
			<div class="button_area"><input type="submit" name="member_login_submit" value="Login" class="button_good" />
			
			</div>
			
		</div>
			<div style=" text-align: right;"><a class="simple_small_button" style="font-size: 9pt;" href="/member/forget">Forget your password?</a></div>
		</div>
	</div>
</form>