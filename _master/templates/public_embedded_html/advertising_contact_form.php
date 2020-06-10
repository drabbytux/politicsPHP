<?
	/**
	 * Contact form for advertising
	 */
?>
<form action="/information/view/advertise" method="post">
<table>
	<tr>
		<td>Name </td><td><input type="text" name="client_name" value="<?=$this->Get('client_name');?>"></td>
	</tr>
	<tr>
		<td>Company </td><td><input type="text" name="client_company_name" value="<?=$this->Get('client_company_name');?>"></td>
	</tr>
	<tr>
		<td>Email: </td><td><input type="text" name="client_email" value="<?=$this->Get('client_email');?>"></td>
	</tr>
		<tr>
		<td>Phone: </td><td><input type="text" name="client_phone" value="<?=$this->Get('client_phone');?>"></td>
	</tr>
		<tr>
		<td>&nbsp;</td><td style="padding: 10px;"><input class="button_good" type="submit" name="submit_client_information" value="Submit"></td>
	</tr>
	</table>
</form>