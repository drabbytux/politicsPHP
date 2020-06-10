<? // -- Most Popular -----  ?>
<div style="width: 120px;">
	<div class="TabbedPanelsHeading" style="margin-top: 0px; padding: 0px;width: 120px;">
		<div class="TabbedPanelsHeadingContent" style="width: 120px;">Latest News from <?=OTHER_NEWSPAPER_NAME;?></div>
	</div>
		<div class="TabbedPanels" id="tp1" style="margin-bottom: 15px;width: 120px;">
			<div class="TabbedPanelsContentGroup" style="width: 120px;">
				<div class="TabbedPanelsContent">
					<?
						$feed_url = "http://embassymag.ca/rss";
						$xmlobj = simplexml_load_file($feed_url);

						if( is_object($xmlobj)){
							$counter=1;
							foreach( $xmlobj->channel->item as $item ){
								
								print '<p style="margin-bottom: 10px;"><a href="'.$item->link.'">';
								// print $counter . '. ';
								print $item->title;
								print '</a>';
								print "</p>\n";
								$counter++;
							}
						}
					?>
				
				</div>
			</div>
		</div>
</div>
