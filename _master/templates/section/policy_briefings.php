<?php

?>
<h1 class="colour_babyblue">Policy Briefings</h1>
<table style="width: 100%;">
	<tr>

			<td>
			<h1 class="section_h1"><?=$this->get_data('pb_year'); ?> Policy Briefings</h1>
			<? if( $this->get_data('policy_briefing_published_list') && is_array( $this->get_data('policy_briefing_published_list') ) ) {
					foreach($this->get_data('policy_briefing_published_list') as $pb_item ){
					?>
						<div>
							 <div class="section_small_item" style="color: #666; margin-top: 12px;"><?=$this->_formatDate( $pb_item['policy_briefing_publish_date']);  ?></div>
							<h3><a href="/sections/pb/download"><?=$pb_item['policy_briefing_title'];  ?> <img src="/site/images/icons/pdf.gif" /></a></h3>
						</div>
					<?
					}
				}
				?>

			</td>
		<td class="dotted_line_middle_td" style="width: 230px;">
		
			<div id="coollist">
			
			<!-- 	<img src="/site/images/titles/title_pb_upcoming.jpg" /> -->
			<h1 class="section_h1">Upcoming</h1>

			<? if( $this->get_data('policy_briefing_upcoming_list') && is_array( $this->get_data('policy_briefing_upcoming_list') ) ) {
					foreach($this->get_data('policy_briefing_upcoming_list') as $pb_item ){
					?>
					<div class="section_small_item"><?=$pb_item['policy_briefing_title'];  ?></div>
					<div  class="section_small_indented">
						<span style="color: #000;" >Publishing Date: <?=$this->_formatDate( $pb_item['policy_briefing_publish_date']);  ?></span>
						<span style="color: #aa0000;"><?=($this->_formatDate( $pb_item['policy_briefing_booking_date']))? '<br />Booking Date: '. $this->_formatDate( $pb_item['policy_briefing_booking_date']) : NULL;  ?></span>
					</div>
					<?
					}
				}
				?>


				<!--  <div style="text-align: left;font-size: 9pt;"><a href="/sections/pb/upcoming">More upcoming...</a></div> -->

			
			</div>
		</td>
	</tr>

</table>