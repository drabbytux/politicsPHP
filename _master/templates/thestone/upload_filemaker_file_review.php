<div class="gradient_background">

<div class="breadcrumb"><a href="/thestone/users">Users</a> &raquo; <a href="/thestone/uploadFilemaker">Upload Filemaker File</a> &raquo;</div>
<h2>Review Memberships</h2>
<?
print $this->Get_Data('messages');
print $this->Get_Data('errors');
?>
<table style="width: 100%;">
	<tr>
		<td style="width: 50%;">
		<div style="border: 1px #333 solid; padding: 2px 8px;">
		<h3>To be Added</h3>
		
			<?
				if( is_array( $this->Get_Data('new_users') ) &&  count(  $this->Get_Data('new_users') ) ) {
					foreach( $this->Get_Data('new_users') as $key=>$val ) {
						print $key . "<br />";
					}
				} else {
					print '<em><span style="color: #AAA;">No one to be added.. Oh well...<span></em>';	
				}
			?>
		</div>
		</td>
		<td style="width: 50%;">
			<div style="border: 1px #333 solid; padding: 2px 8px;">
			<h3>To be removed</h3>
		
			<?
				if( is_array( $this->Get_Data('removed_users') ) && count($this->Get_Data('removed_users')) ) {
					foreach( $this->Get_Data('removed_users') as $r_user ) {
						print $r_user['member_email'] . "<br />";
					}
				} else {
					print '<em><span style="color: #AAA;">Nobody needs to be removed. Yah!<span></em>';
				}
			?>
			</div>
		</td>	
	</tr>
</table>	

<form action="/thestone/processFilemaker" method="post">
	<?
		if( (is_array( $this->Get_Data('new_users') ) && count( $this->Get_Data('new_users') ) ) || ( is_array( $this->Get_Data('removed_users') ) && count( $this->Get_Data('removed_users') ) ) )  {
			?>
			

				<div style="margin-bottom: 10px; text-align: center; border: 1px #A79C6B solid; background-color: #FBF0BC; padding: 6px;">
				<input class="button_warning" type="submit" name="submit_cancel" value="NO! Let me upload a revised version..." /> &nbsp; &nbsp;
					<input class="button_good" type="submit" name="submit_process_filemaker_file" value="YES - Process the new and expired members" />
				</div>
			<?
		} else {
			?><p> Nothing new to process. If you think there should be, contact online services to confirm the system is working properly.</P>
			
	<?	}	?>
</form>

</div>

