<div class="gradient_background">
<fieldset>
<legend>Load an issue file</legend>
<form action="/thestone/uploadissuefile" enctype="multipart/form-data" method="POST" >
	<h3>Issue Date</h3>
		<select name="month"><?=dropdown('MONTH', date('n') );?></select>
		<select name="day"><?=dropdown('DAY', date('j', strtotime('tomorrow') ) );?></select>
		<select name="year"><?=dropdown('YEAR', date('o') );?></select>
	<h3>Select your file</h3>
		<input type="file" name="issuefile"> <input type="checkbox" name="delete_issue_stories" checked />Delete existing issue stories &nbsp; &nbsp; <input type="submit" name="submit" value="Upload Issue File">
</form>
</fieldset>
</div>