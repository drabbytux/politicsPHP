<?php
/**
 * Takes in the abbriviated content, and shows the login and subscribe areas
 */
?>
<?=$this->Get_Data('output_page_view'); ?>

<h4 style="color: #08468F;">To view the rest of this article, please login or subscribe for a free trial</h4>
<table style="width: 100%;">
	<tr>
		<td style="width: 50%;">
			<?=$this->Get_Data('output_mini_subscribe'); ?>
		</td>
		<td style="width: 50%;">
			<?=$this->Get_Data('output_login'); ?>
		</td>
	</tr>
</table>