<div class="gradient_background">

<h2>Attibute an area to a story</h2>
<?
print $this->Get_Data('messages');
print $this->Get_Data('errors');
?>
<form action="" method="post">
	<select name="area_id">
	<?=dropdown(NULL, NULL, $this->get_data('arr_areas') ) ?>
	</select>
	<input type="submit" name="submit_addArea" value="Submit" />
</form>
</div>
