<?
/**
 * General template for the sections
 * Should display photos and the most recent stories, and links for the rest.
 */
$current_date = NULL;
$story_count = 0;
$photo_size = NULL;

if( is_array( $this->Get_Data('formatted_issue_stories') ) ){

	
	
	// Heading
	if( $this->Get_Data('section_details', 'section_image') ) {
		?><div style="border-bottom: 2px #000 solid;"><img src="/<?=SITE?>/<?=$this->Get_Data('section_details', 'section_image')?>" /></div><?
	} else {
		?><h1><?=$this->Get_Data('h1_title');?></h1><?
	}
	
	foreach( $this->Get_Data('formatted_issue_stories') as $story_item ) { ?>
	<?
		switch($story_count) {	
			case 0:
			case 1:
			case 2:
			case 3:
					$photo_size = LARGE;
			break;
			
			case 4:
			case 5:
			case 6:
			case 7:
			case 8:
			case 9:
			case 10:
				$photo_size = SMALL;
			break;
			default:
				$photo_size = NULL;
			break;
		}
	
		
		if( $photo_size ) {
			print $this->outputStoryPhoto( $story_item['story_id'], $photo_size  );
		}
			
		
		if( $story_count <=5 ) {
			print $this->_formatDate( $story_item['story_issue_date']);
		?><br /><h2><a href="/page/view/<?=$this->toURL( $story_item['story_url_id'],NULL,$story_item['story_issue_date'] );?>" class="list_item"><?=$story_item['story_title'] . "";?></a></h2><?		
		} else {
			print $this->_formatDate( $story_item['story_issue_date']);
		?><br /><a href="/page/view/<?=$this->toURL( $story_item['story_url_id'],NULL,$story_item['story_issue_date'] );?>" class="list_item"><?=$story_item['story_title'] . "";?></a><?	
		}
		
	$story_count++;
	}
}


/**
if( is_array( $this->Get_Data('story_list_array') ) ){
	print '<table style="border-collapse: none;">';
	foreach( $this->Get_Data('story_list_array') as $story_item ) { ?>
	<? 
		if( $current_date == $story_item['story_issue_date'] ) {
			$extra_style = NULL;
		} else {
			$current_date = $story_item['story_issue_date'];
			$extra_style = "color: #fff; font-weight: bold;";
		}
		
	?>
		<tr>
			<td style="width: 100px; border-top: 1px #aaa solid;background-color: #333; border-bottom: 1px #888 solid;">
				<div style="height: 100%;font-size: 6pt;color: #ccc; <?=$extra_style;?> ">
					<?=$this->_formatDate( $story_item['story_issue_date']);?>
				</div>
			</td>
			<td style="border-bottom: 1px #aaa solid;">
				<a href="/page/view/<?=$this->toURL( $story_item['story_url_id'] );?>" class="list_item"><?=$story_item['story_title'] . "";?></a>
			</td>
		</tr>
		<?
	}
	print "</table>";
} else {
	print "Please try a different section.";
}

**/

?>