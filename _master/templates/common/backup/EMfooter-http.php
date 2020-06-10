</td>

<td style="text-align: center;width: 301px;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff;width: 300px; padding: 0px 5px 10px 10px; margin: 0px 0px 5px 5px;">
				<? // SPECIAL AREA ON THE RIGHT ?>
	
<? // Policy Briefings ?>
<div style="text-align: center; margin-bottom: 10px;">
	<img src="/site/images/titles/embassy_policy_briefings.gif" />
	
	<?=$this->policy_briefing_side(); ?>
	</div>

<? // Authors ?>
<link rel="stylesheet" type="text/css" href="/site/styles/content_glider.css" />
<script type="text/javascript" src="/site/javascript/jQuery.js"></script>
<script type="text/javascript" src="/site/javascript/content_glider.js"></script>


	
<script type="text/javascript">

featuredcontentglider.init({
	gliderid: "columnistsscroller", //ID of main glider container
	contentclass: "glidecontent", //Shared CSS class name of each glider content
	togglerid: "p-select", //ID of toggler container
	remotecontent: "", //Get gliding contents from external file on server? "filename" or "" to disable
	selected: 0, //Default selected content index (0=1st)
	persiststate: false, //Remember last content shown within browser session (true/false)?
	speed: 200, //Glide animation duration (in milliseconds)
	direction: "leftright", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
	autorotate: true, //Auto rotate contents (true/false)?
	autorotateconfig: [3000, 20] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
})

</script>

<div id="columnistsscroller" class="glidecontentwrapper">
<?
	$arr_dir = scandir( DIRECTORY_PHOTOS . '/columnists/scroller');
	if( is_array( $arr_dir ) ) {
	
		foreach( $arr_dir as $photo ) {
			if( strstr($photo, '.jpg' ) ) { ?>
				<div class="glidecontent">
				 <img src="<?=URL_PHOTOS_DIR. '/columnists/scroller/'. $photo;?>" />
				</div>	
		<?	}
		}
	}
?>

	

	
</div>


<!--  <div id="p-select" class="glidecontenttoggler"> -->
<a href="#" class="prev">&nbsp;</a><a href="#" class="next">&nbsp;</a>
</div>
		
							
<? // Advertising ?>
					<div style="margin: 15px 0px; padding-top: 2px; ">
						<? include( DIRECTORY_TEMPLATES . '/bannercode/right_rectangle_300x250.php'); // RIGHT COLUMN top ad 300x250 ?>
					</div>
					<? include(FILE_POPULAR_STORIES); ?>

			<table style="width: 100%;">
				<tr>
					<td style="width: 140px;">
<? // Buttons ?>
						<a href="/page/listings"><img style="margin-bottom: 10px;" src="/site/images/buttons/ottawa-listings.jpg" /></a>
						<!-- <img style="margin-bottom: 10px;" src="/site/images/buttons/120-90-buyme.gif" /><br />
						<img style="margin-bottom: 10px;" src="/site/images/buttons/120-90-buyme.gif" /><br />
						<img style="margin-bottom: 10px;" src="/site/images/buttons/120-90-buyme.gif" /><br />
						<img style="margin-bottom: 10px;" src="/site/images/buttons/120-90-buyme.gif" /><br />
						<img src="/site/images/buttons/120-90-buyme.gif" />
						//  -->
					</td>
					<td style="width: 160px;">
						<? include( DIRECTORY_TEMPLATES . '/bannercode/skyscraper.php'); // RIGHT COLUMN tall banner ?>
					</td>
				</tr>
				</tr>
			</table>
			<br />
			<? // include(FILE_HILLTIMES_FEED); ?>

<script type="text/javascript"><!--
							google_ad_client = "pub-0862844959872799";
							/* 300x250, created 8/12/08 */
							google_ad_slot = "4167005132";
							google_ad_width = 300;
							google_ad_height = 250;
							//-->
							</script>
							<script type="text/javascript"
							src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
				
</td>
</tr>
</table>
<? if( $this->Get_Data('page_type') == 'issue') {
		include('templates/common/EMbottom_block_headlines.php');
	}
?>

<!-- 
<div style="border: 1px #555 solid; padding: 2px 10px; background-color: #eee;">
	<strong>Regional</strong> &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  &raquo;The Americas &nbsp;&nbsp;&raquo;Europe &nbsp;&nbsp;&raquo;Asia &nbsp;&nbsp;&raquo;Africa &nbsp;&nbsp;&raquo;The Middle East
</div>
//  -->

<?=$this->Get_Data('footer_links'); ?>

	</div><? // End Enclosed Area ?>
	<div style="text-align: right; margin-top: 10px; padding: 8px;">
		
	</div>

</div><? //End Master Area ?>

<? // Get the common javascript stuff at the bottom ?>
<? include( $_SERVER['DOCUMENT_ROOT'].'/site/javascript/common_js.php');?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1271965-2";
urchinTracker();
</script>
						
	</body>
</html>
