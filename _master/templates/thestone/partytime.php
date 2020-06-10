<div class="gradient_background">

<h2>PartyTime</h2>

<?
print $this->Get_Data('messages');
print $this->Get_Data('errors');
?>

<table style="width: 100%;">
	<tr>
		<td style="width: 40%;">
		<fieldset style="border-color: #E37B00;">
		<legend>Create a New Partytime</legend>
			<form action="/thestone/partytimecreate" method="post" >
				<select name="month"><?=dropdown('MONTH', date('n') );?></select>
				<select name="day"><?=dropdown('DAY', date('j', strtotime('tomorrow') ) );?></select>
				<select name="year"><?=dropdown('YEAR', date('o') );?></select>
				<input type="submit" value="Party On, Gareth" name="submit_partyon" />
				
			</form>
				<div style="text-align: center;"><img src="/site/images/special/gareth.jpg" /></div>
		</fieldset>
		
		</td>

		<td style="width: 40%;">
		<fieldset style="border-color: green;">
		<legend>Hmmmmm</legend>
				Something WILL go here... But what?
		</fieldset>
		</td>
	</tr>
</table>


<fieldset style="margin-top: 20px;"><legend>Extra Info</legend>
	<p>The Party Time module is your time saving device. Create your image files, name them <em>mmddyy-a.jpg, mmddyy-b.jpg</em>, etc...<br />
	Make thumbnails like <em>th-mmddyy-a.jpg, th-mmddyy-b.jpg,</em> etc... and save all image files into <strong>/EM/partytime/[year]/[month]/[day]</strong>.
	</p>
</fieldset>


</div>