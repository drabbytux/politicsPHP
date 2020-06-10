<?
// Title
if( $this->Get_Data('column_details')) { ?>
	<div id="breadcrumb"><a href="/column/">Columns</a></div>
	<h2><?=$this->Get_Data('column_details', 'section_title');?></h2>
	
<? }


// Stories
if( $this->Get_Data('column_stories') ){
	foreach( $this->Get_Data('column_stories') as $cs ){ ?>
		<div style="font: 8pt verdana;"><?=$this->_formatDate( $cs['story_issue_date'] ); ?></div>
		<a href="/page/view/<?=$this->toURL( $cs['story_url_id'], NULL, $cs['story_issue_date'] ); ?>"><?=$cs['story_title'];?></a><br />
		<?=($cs['story_brief'])? $cs['story_brief'].'<br /><br />': NULL;?>
	<? } 
} else {
	print "No stories were found.";
}

?>
</td>
<td style="text-align: center;width: 29%;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff; padding: 0px 5px 10px 10px; margin: 0px 0px 5px 5px;">

<? include('templates/column/list.php'); ?>
</td>
