<?php
foreach( $this->Get_Data('story_list_array') as $story ){
	print '<p><a href="/mobile/story/'.$story['story_url_id'].'"> '. $story['story_title'] . '</a><br />';
	print $story['story_brief'] .'</p>';
}
?>