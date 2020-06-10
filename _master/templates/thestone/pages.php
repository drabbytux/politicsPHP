<!-- 
	<div>
	<span style="font-weight: bold; color: #3E4F18;">Current Status</span><br />
		Displayed Issue: August 12, 2007 (<a>edit</a>)<br />Auto Date change on. (<a href="">Turn off</a>)
	</div>
	<br />
-->
<div class="gradient_background">
<h2>Issues, Stories and Content</h2>
	<table style="width: 100%;">
		<tr>
			<td style="width: 50%;">
			<p><a href="/thestone/loadentireissue"><img src="/site/images/icons/coolgrey.gif"> Load a new issue</a></p>
				<h3>Issues</h3>
				
				<p>
					<select name="issue">
					<?
						if( is_array( $this->Get_Data('issue_dates_array') ) ) {
							foreach( $this->Get_Data('issue_dates_array') as $issue_date ){
								print '<option value="'. $issue_date['issue_date'].'">'. $this->_formatDate( $issue_date['issue_date'] )."</option>";
							}
						}
					?>
					</select><input type="submit" value="Display Stories" /><br />
				</p>	
			</td>
			<td style="width: 50%;">
				<h3>Stories</h3>
				<a style="font-size: 9pt;" href="/thestone/createPage">Create a New Story</a>
				<p>
				<form action="/thestone/fetchpage" method="post">
					<input type="text" name="page_retrieve" style="width: 240px;" /><input type="submit" value="fetch" name="submit_page_fetch" /> <a href="#" class="tooltipQuestion" onClick="return false;" id="tooltip_page_retrieval" >?</a><br />
				</form>
					<div id="tooltip_retrieve_existing_page" class="tooltipContent" style="width:200px;">
					 	This will retrieve the page given, and if it doesn't exist will use the entered text as a search term.
					</div>
				</p>
			</td>
		</tr>
	</table>
</div>
	<?=$this->Get_Data('page_fetch_list'); ?>
<script type="text/javascript">
 var fadeTooltip = new Spry.Widget.Tooltip('tooltip_retrieve_existing_page', '#tooltip_page_retrieval', {useEffect: 'Fade'});
</script>