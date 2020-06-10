<div id="story">
	<div class="special">&nbsp;</div>
	
	<table>
		<tr>
			<td style="width: 600px;">
				<h1><?=$this->Get_Data('story_title');?></h1>
				<?=$this->outputStoryAuthors( $this->Get_Data('story_id') );?>
			</td>
			<td style="background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff;width: 1px; padding: 0px; margin: 0px;"><img src="/site/images/spacer.gif" style="width: 1px; height: 1px;" /></td>
			<td id="basic_functions">
				<? if( $this->Get_Data('page_type') == 'story' ) { include(FILE_PAGE_FUNCTIONS);  } ?>
			</td>
		</tr>
	</table>
	<div class="date">
		<table style="width: 100%;">
			<tr>
				<td><img src="/site/images/icons/mini_clock.gif" /> Published <?=$this->Get_Data('story_date');?>
					<? // Show the number of comments
						if( $this->Get_Data('story_comments') && is_array( $this->Get_Data('story_comments') ) ) {
							print '<a href="#comments" class="anchor_no_underline">';
							print '&nbsp; <img src="/site/images/icons/mini_comment.gif" />&nbsp;';
							print count( $this->Get_Data('story_comments') );
							print ' Comment';
							if( count( $this->Get_Data('story_comments') ) > 1 ) {
								print 's';
							}
							print '</a>';
						}
					?>
					<? // Show the number of Blogged/Bookmarked
						if( $this->Get_Data('story_bookmarked') && is_array( $this->Get_Data('story_bookmarked') ) ) { 
							print '&nbsp; <img src="/site/images/icons/mini_doc.gif" />';
							print count( $this->Get_Data('story_bookmarked') );
							print ' Bookmarked';
							if( count( $this->Get_Data('story_bookmarked') ) > 1 ) {
								print 's';
							}
						}
					?>
				</td>
				<td style="text-align: right;">
					&nbsp;
				</td>
			</tr>
		</table>
	</div>
		