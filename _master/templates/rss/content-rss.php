<?php
/*
 * RSS Stories Template
 * Output of the Stories within an XML/RSS view
 */
foreach( $this->data_holder['arr_stories'] as $story ){
	?>
<item>
	<title><?=$this->RSS_Text( $story['story_title'] );?></title>
	<link>http://<?=$_SERVER["SERVER_NAME"] . '/page/view/';?><?=$this->toURL( $story['story_url_id'], NULL, $story['story_issue_date']);?></link>
	<description><![CDATA[<?=(trim( $story['story_kicker'] ) )? $this->RSS_Text( $story['story_kicker']):$this->RSS_Text( $story['story_description'].'...' );?>]]></description>
</item>
	<?
}
?>