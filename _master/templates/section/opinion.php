<?php
$current_issue_date = NULL;
foreach( $this->Get_Data('section_columns') as $story_item ){
	
?>

<? // Issue date
	if( $current_issue_date != $story_item['story_issue_date'] ){ 
	$current_issue_date = $story_item['story_issue_date'];
	?> 
		<h3 style="border-bottom: 2px #000 solid;"><?=$this->_formatDate( $current_issue_date ); ?></h3>
	
	<?
	
} ?>
<?
	if( $story_item['section_id'] == 12 ) { // just a column, no title
?>
<h4 style="border-top: 1px #000 solid;"><?=$story_item['author_name'];?></h4>
<p>

<?
} else {
?>
<h4 style="border-top: 1px #000 solid;"><?=$story_item['section_title'];?></h4>
<p><small><?=$story_item['author_name'];?></small><br />

<?	
}

?>

	<a href="/page/view/<?=($story_item['story_issue_date'] <= SYSTEM_IMPLEMENTATION_DATE )? $story_item['story_url_id'] : $this->toURL( $story_item['story_url_id'] );?>"><?=$story_item['story_title'];?></a>
	</p>

<?
}

?>



