<?=$this->Get_Data('template_story_heading_area'); ?>

<?=$this->outputStoryPhotoArea();?>
<?=$this->Get_Data('story_content');?>
</div>


<div id="comment_entry_box">
	<div class="comment_box">		
<? // -- Story Specific -----  ?>
<div>
	<div class="TabbedPanelsHeadingLarge">
		<div class="TabbedPanelsHeadingContentLarge">
			"<?= trim($this->Get_Data('story_title'));?>"
		</div>
	</div>
	<div class="TabbedPanelsLarge" id="comment1" style="margin-bottom: 15px;">
		<ul class="TabbedPanelsTabGroupLarge">
			<li class="TabbedPanelsTab" tabindex="0">Email this story</li>
			<li class="TabbedPanelsTab" tabindex="1">Bookmark it</li>
			<li class="TabbedPanelsTab" tabindex="2">Comment on this story</li>
			<li class="TabbedPanelsTab" tabindex="3">Letter to the Editor</li>
		</ul>
		<div class="TabbedPanelsContentGroupLarge">	
			<div class="TabbedPanelsContent">
				<form method="POST" id="form_email_this_story" action="/page/ajaxResponseEmailThisStory" onsubmit="return submitEmailForm(this);">
					<input type="hidden" name="story_title" value="<?=$this->Get_Data('story_title');?>" />
					<input type="hidden" name="story_url_id" value="<?=$this->Get_Data('story_url_id');?>" />
					<input type="hidden" name="story_id" value="<?=$this->Get_Data('story_id');?>" />
					<div id="response_ajax_email_this_story">
						<? include('templates/tidbits/email_story_to_a_friend.php'); ?>
					</div>
				</form>
			</div>
			<div class="TabbedPanelsContent">
			<div id="highlighter_email"></div><?// Placeholder ?>
			<p>Bookmark this story in your <a href="javascript: sets('favorites');" class="c1a">browser</a> or on one of your favouite sites:</p>
				<script type="text/javascript">
					function sets(val){
					  elt = document.getElementById('mys'); elt.value=val;
					  elt = document.getElementById('winname'); elt.value=window.name;
					  elt = document.getElementById('bookmarkform'); elt.submit();
					  return false;
					}
								
				</script>
				<form id="bookmarkform" action="http://www.addthis.com/bookmark.php" method="post">
					<input type="hidden" id="mys" name="s" value="" />
					<input type="hidden" id="pub" name="pub" value="YOUR-ACCOUNT-ID" />
					<input type="hidden" id="url" name="url" value="<?=$this->Get_URL();?>" />
					<input type="hidden" id="title" name="title" value="<?=$this->Get_Data('page_title');?>" />
					<input type="hidden" id="lng" name="lng" value="" />
					<input type="hidden" id="winname" name="winname" value="" />
					<input type="hidden" id="content" name="content" value="" />
					
					<table style="width: 100%;">
						<tr>
							<td width="50%">
								<a href="javascript: sets('favorites');" class="c1a"><img src="http://s7.addthis.com/services/favorites.png" width="16" height="16" border="0" alt="" /> Favorites</a><br />
								<a href="javascript: sets('google');" class="c1a"><img src="http://s7.addthis.com/services/goog.png" width="16" height="16" border="0" alt="" /> Google Bookmarks</a><br />
								<a href="javascript: sets('facebook');" class="c1a"><img src="http://s7.addthis.com/services/facebook.gif" width="16" height="16" border="0" alt="" /> Facebook</a><br />
								<a href="javascript: sets('delicious');" class="c1a"><img src="http://s7.addthis.com/services/delicious.png" width="16" height="16" border="0" alt="" /> Delicious</a><br />
								<a href="javascript: sets('digg');" class="c1a"><img src="http://s7.addthis.com/services/digg.png" width="16" height="16" border="0" alt="" /> Digg</a><br />
								<a href="javascript: sets('yahoobkm');" class="c1a"><img src="http://s7.addthis.com/services/ybkm.gif" width="16" height="16" border="0" alt="" /> Yahoo Bookmarks</a><br />
								
								</td><td width="50%">
								<a href="javascript: sets('newsvine');" class="c1a"><img src="http://s7.addthis.com/services/newsvine.png" width="16" height="16" border="0" alt="" /> Newsvine</a><br />
								<a href="javascript: sets('live');" class="c1a"><img src="http://s7.addthis.com/services/live.gif" width="16" height="16" border="0" alt="" /> Live</a><br />
								<a href="javascript: sets('blinklist');" class="c1a"><img src="http://s7.addthis.com/services/blinklist.png" width="16" height="16" border="0" alt="" /> Blinklist</a><br />
								<a href="javascript: sets('myweb');" class="c1a"><img src="http://s7.addthis.com/services/yahoo-myweb.png" width="16" height="16" border="0" alt="" /> Yahoo MyWeb</a><br />
								<a href="javascript: sets('fark');" class="c1a"><img src="http://s7.addthis.com/services/fark.png" width="16" height="16" border="0" alt="" /> Fark</a><br />
								<a href="javascript: sets('myspace');" class="c1a"><img src="http://s7.addthis.com/services/myspace.png" width="16" height="16" border="0" alt="" /> MySpace</a><br />
								
								
								<!-- 
								<a href="javascript: sets('furl');" class="c1a"><img src="http://s7.addthis.com/services/furl.gif" width="16" height="16" border="0" alt="" /> Furl</a><br />
								<a href="javascript: sets('su');" class="c1a"><img src="http://s7.addthis.com/services/su.png" width="16" height="16" border="0" alt="" /> StumbleUpon</a><br />
								<a href="javascript: sets('reddit');" class="c1a"><img src="http://s7.addthis.com/services/reddit.gif" width="16" height="16" border="0" alt="" /> Reddit</a><br />
								
								
								<a href="javascript: sets('technorati');" class="c1a"><img src="http://s7.addthis.com/services/technorati.png" width="16" height="16" border="0" alt="" /> Technorati</a><br />
								<a href="javascript: sets('twitter');" class="c1a"><img src="http://s7.addthis.com/services/twitter.gif" width="16" height="16" border="0" alt="" /> Twitter</a><br />
								
								<a href="javascript: sets('aolfav');" class="c1a"><img src="http://s7.addthis.com/services/aolfav.gif" width="16" height="16" border="0" alt="" /> myAOL</a><br />
								
								
								<a href="javascript: sets('ask');" class="c1a"><img src="http://s7.addthis.com/services/ask.png" width="16" height="16" border="0" alt="" /> Ask</a><br />
								
								<a href="javascript: sets('slashdot');" class="c1a"><img src="http://s7.addthis.com/services/slashdot.png" width="16" height="16" border="0" alt="" /> Slashdot</a><br />
								<a href="javascript: sets('netscape');" class="c1a"><img src="http://s7.addthis.com/services/propeller.png" width="16" height="16" border="0" alt="" /> Propeller (Netscape)</a><br />
								
								<a href="javascript: sets('mixx');" class="c1a"><img src="http://s7.addthis.com/services/mixx.png" width="16" height="16" border="0" alt="" /> Mixx</a><br />
								
								
								<a href="javascript: sets('multiply');" class="c1a"><img src="http://s7.addthis.com/services/multiply.png" width="16" height="16" border="0" alt="" /> Multiply</a><br />
								
								<a href="javascript: sets('simpy');" class="c1a"><img src="http://s7.addthis.com/services/simpy.png" width="16" height="16" border="0" alt="" /> Simpy</a><br />
								<a href="javascript: sets('blogmarks');" class="c1a"><img src="http://s7.addthis.com/services/blogmarks.png" width="16" height="16" border="0" alt="" /> Blogmarks</a><br />
								<a href="javascript: sets('diigo');" class="c1a"><img src="http://s7.addthis.com/services/diigo.gif" width="16" height="16" border="0" alt="" /> Diigo</a><br />
								<a href="javascript: sets('bluedot');" class="c1a"><img src="http://s7.addthis.com/services/bluedot.png" width="16" height="16" border="0" alt="" /> Faves (Bluedot)</a><br />
								
								<a href="javascript: sets('spurl');" class="c1a"><img src="http://s7.addthis.com/services/spurl.png" width="16" height="16" border="0" alt="" /> Spurl</a><br />
								<a href="javascript: sets('linkagogo');" class="c1a"><img src="http://s7.addthis.com/services/linkagogo.png" width="16" height="16" border="0" alt="" /> Link-a-Gogo</a><br />
								
								<a href="javascript: sets('misterwong');" class="c1a"><img src="http://s7.addthis.com/services/misterwong.png" width="16" height="16" border="0" alt="" /> Mister Wong</a><br />
								<a href="javascript: sets('feedmelinks');" class="c1a"><img src="http://s7.addthis.com/services/feedmelinks.png" width="16" height="16" border="0" alt="" /> FeedMeLinks</a><br />
								
								<a href="javascript: sets('backflip');" class="c1a"><img src="http://s7.addthis.com/services/backflip.png" width="16" height="16" border="0" alt="" /> Backflip</a><br />
								<a href="javascript: sets('magnolia');" class="c1a"><img src="http://s7.addthis.com/services/magnolia.png" width="16" height="16" border="0" alt="" /> Magnolia</a><br />
								
								<a href="javascript: sets('segnalo');" class="c1a"><img src="http://s7.addthis.com/services/segnalo.gif" width="16" height="16" border="0" alt="" /> Seganlo</a><br />
								<a href="javascript: sets('netvouz');" class="c1a"><img src="http://s7.addthis.com/services/netvouz.png" width="16" height="16" border="0" alt="" /> Netvouz</a><br />
								
								
								<a href="javascript: sets('tailrank');" class="c1a"><img src="http://s7.addthis.com/services/tailrank2.png" width="16" height="16" border="0" alt="" /> Tailrank</a><br />
								//  -->
							</td>
						</tr>
					</table>
				</form>              
			</div>
			<div class="TabbedPanelsContent">
			<div id="highlighter_comment"></div><?// Placeholder ?>
				<form method="POST" id="form_public_comment" action="/page/ajaxResponsePublicComment" onsubmit="return submitCommentForm(this);">
					<input type="hidden" name="story_id" value="<?=$this->Get_Data('story_id');?>" />
					<input type="hidden" name="story_title" value="<?=$this->Get_Data('story_title');?>" />
					<input type="hidden" name="story_url_id" value="<?=$this->Get_Data('story_url_id');?>" />
					<div id="response_ajax_public_comment">
						<? include('templates/tidbits/public_comment_form.php'); ?>
					</div>
				</form>	
				
				
			</div>
			<div class="TabbedPanelsContent">
			<div id="highlighter_letter"></div><?// Placeholder ?>
				<form method="POST" id="form_letter" action="/page/ajaxResponseLetter" onsubmit="return submitLetterForm(this);">
					<input type="hidden" name="story_id" value="<?=$this->Get_Data('story_id');?>" />
					<input type="hidden" name="story_title" value="<?=$this->Get_Data('story_title');?>" />
					<input type="hidden" name="story_url_id" value="<?=$this->Get_Data('story_url_id');?>" />
					<div id="response_ajax_letter">
						<? include('templates/tidbits/letter_form.php'); ?>
					</div>
				</form>	
				
			</div>
		</div>	
		
	</div>
</div>		
			
						
	</div>
</div>

<? // Comments Area ?>
<? 
	if( $this->Get_Data('story_comments') && is_array( $this->Get_Data('story_comments') ) ) {
		print '<a name="comments"></a>';
		print $this->outputPageComments();
	}
?>

