<table style="width: 100%;">
<tr>
<td style="width: 70%;">
<h2>Recent Columns</h2>
<?php
$current_issue_date = NULL;
foreach( $this->Get_Data('section_columns') as $story_item ){
	$image_link = NULL;
	
?>

<table style="100%;"><tr>
<? // Issue date
	if( $current_issue_date != $story_item['story_issue_date'] ){ 
	$current_issue_date = $story_item['story_issue_date'];
	?> 
		<br /><h3 style="border-bottom:1px #555 solid; color: #555;padding: 0px 0px ;"><?=$this->_formatDate( $current_issue_date ); ?></h3>
	<?	} ?>
		
	<?
		if( $image_link = $this->authorPhotoExists( $story_item['author_id'] ) ){
			print '<td style="width: 50px;padding: 0px 0px 10px 0px;"><img style="border: 0px black solid;" src="'.$image_link.'"></td><td style="width: 370px;padding: 0px 0px 10px 5px;"">';
		} else {
			print '<td style="width: 420px;padding: 0px 0px 10px 0px;">';	
		}
		?><a href="/page/view/<?=$story_item['story_url_id'];?>"><?=$story_item['story_title'];?></a><br />
		
		<?
			if( $story_item['section_id'] == 3 ) { // just a column, no title
		?>
		<strong><?=$story_item['author_name'];?></strong><br />
			
		<?	} else {	?>
		<strong><?=$story_item['section_title'];?> by <?=$story_item['author_name'];?></strong><br />
			
		<?	}?>
		<?=$story_item['story_brief'];?>
		
		</td></tr>

	<? } ?>
	</table>
</td>
<td style="text-align: center;width: 29%;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff; padding: 0px 5px 10px 10px; margin: 0px 0px 5px 5px;">

<? include('templates/column/list.php'); ?>
</td>
</tr>
</table>