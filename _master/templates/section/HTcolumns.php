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

		if( isset($blahtest) ) { //$image_link = $this->authorPhotoExists( $story_item['author_id'] ) ){
			print '<td style="width: 50px; padding: 0px 0px 10px 0px;"><img style="border: 0px black solid;" src="'.$image_link.'"></td><td style="width: 370px; padding: 0px 0px 10px 5px;"">';
		} else {
			print '<td style="width: 420px; padding: 0px 0px 10px 0px;">';	
		}

		?><a href="/page/view/<?=$story_item['story_url_id'];?>"><?=$story_item['story_title'];?></a><br />
		
		<?
		// Pump out the author OR Authors
			$str_authors = NULL;
			if( is_array($this->get_data('story_authors', $story_item['story_id'] ) ) ){
				$author_count = 1;
				$str_authors = NULL;
				foreach ( $this->get_data('story_authors', $story_item['story_id']) as $author ){
					$str_authors .= $author['author_name'];
					if(  $author_count  < count( $this->get_data('story_authors', $story_item['story_id'] ) ) ){
						$str_authors .=  ', ';
					}
					$author_count++;
				}
			}
		
		if( $story_item['section_id'] == 5 && $str_authors ) { // just a column, no title
			?>
			<div class="byline">By <?=uc_latin1( html_entity_decode( $str_authors ) );?></div>
			<?	} else {	?>
			<div class="byline"><?= $story_item['section_title'] ;?> by <?= uc_latin1( html_entity_decode( $str_authors ) );?></div>
		<?	}?>
		<?//=$story_item['story_brief'];?>
		
		</td></tr>

	<? } ?>
	</table>
</td>
<td style="text-align: center;width: 29%;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff; padding: 0px 5px 10px 10px; margin: 0px 0px 5px 5px;">

<? include('templates/column/list.php'); ?>
</td>
</tr>
</table>