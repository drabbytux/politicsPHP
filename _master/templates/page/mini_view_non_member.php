<div id="story">
<div class="special">&nbsp;</div>
 
<h1><?=$this->Get_Data('story_title');?></h1>
	<br />
	<?=$this->outputStoryAuthors( $this->Get_Data('story_id') );?>
	<div class="date">
		<table style="width: 100%;">
			<tr>
				<td><img src="/site/images/icons/mini_clock.gif" /> Published <?=$this->Get_Data('story_date');?></td>
				<td style="text-align: right;">
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
			</tr>
		</table>
	</div>

<?=$this->Return_First_Paragraph( $this->Get_Data('story_content') );?>
</div>