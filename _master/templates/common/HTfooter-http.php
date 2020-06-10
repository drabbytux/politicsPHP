<? if( $this->Get_Data('page_type') == 'issue') {
		include('templates/common/HTbottom_block_headlines.php');
	}
?>
</td>

<td style="text-align: center;width: 301px;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff;width: 300px; padding: 0px 5px 10px 10px; margin: 0px 0px 5px 5px;">
<? // Middle button links ?>


<? // Policy Briefings ?>
	<div style="background-image: url('/site/images/backgrounds/hilltimes_pb.gif'); background-repeat: no-repeat; width: 300px; border: 1px #666 solid; ">
			<div style="padding: 10px; padding-top: 76px; padding-bottom: 0px;">
				<?=$this->policy_briefing_side(); ?>
			</div>
	</div>
<br />


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
	autorotateconfig: [4000, 20] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
})

</script>

<div id="columnistsscroller" class="glidecontentwrapper">
<? print $this->outputColumnistScrollerHTML(); ?>
</div>


<div id="p-select" class="glidecontenttoggler">
<a href="#" class="prev">&nbsp;</a><a href="#" class="next">&nbsp;</a>
</div>


<table style="width: 100%;">
	<tr>
		<td style="width: 50%; text-align: center;">
			<img src="/HT/promo_ads/best_worst_politics_2008.jpg" />
		</td>
		<td style="width: 50%; text-align: center;">
				<a href="/page/view/.2008.february.25.toplobbyists_2008"><img src="/HT/promo_ads/2008-top-100_lobbyists.jpg" /></a>
		</td>
	</tr>
	<tr>
		<td style="width: 50%; text-align: center;">
			<img src="/HT/promo_ads/2008-savvy-sexy-survey.jpg" />
		</td>
		<td style="width: 50%; text-align: center;">
			<img src="/HT/promo_ads/2009-influential.jpg" />
		</td>
	</tr>
	<tr>
		<td style="width: 50%; text-align: center;">
		<img src="/HT/promo_ads/terrific_staffers_2008.jpg" />
			
		</td>
		<td style="width: 50%; text-align: center;">
			<img src="/HT/promo_ads/cabinet_staff_list_2009.jpg" />
		</td>
	</tr>
</table>
<br />

<? // Blogs ?>
<img src="/HT/promo_ads/blogs_harris.jpg" />


<? // Advertising - Top Rectangle ?>
<div style="margin: 15px 0px; padding-top: 10px; ">
	<? include( DIRECTORY_TEMPLATES . '/bannercode/rectangle_1.php'); // RIGHT COLUMN top ad 300x250 ?>
</div>



<? include(FILE_POPULAR_STORIES); ?>


<? // Advertising - Bottom Rectangle 2 ?>
<div style="margin: 15px 0px; padding-top: 10px; ">
	<? include( DIRECTORY_TEMPLATES . '/bannercode/rectangle_2.php'); // RIGHT COLUMN top ad 300x250 ?>
</div>

<br /><br />
<? // double  skyscraper  ?>
<table style="width: 100%;">
	<tr>
		<td style="width: 120px;">
			<? // FIRST COLUMN ?>
			<? include(FILE_EMBASSY_FEED); ?>
		</td>
		<td style="width: 160px;">
			<? // SECOND COLUMN ?>
			<? include( DIRECTORY_TEMPLATES . '/bannercode/skyscraper_1.php'); // RIGHT COLUMN 1 tall banner ?>
			<br /><br />
			<? include( DIRECTORY_TEMPLATES . '/bannercode/skyscraper_2.php'); // RIGHT COLUMN 2 tall banner ?>
		</td>
	</tr>
	</tr>
</table>

<br /><br />
<? include( DIRECTORY_TEMPLATES . '/bannercode/button_1.php'); // The first button ?>
<br /><br />
<? include( DIRECTORY_TEMPLATES . '/bannercode/button_2.php'); // The second button ?>
<br /><br />
<? include( DIRECTORY_TEMPLATES . '/bannercode/button_3.php'); // The third button ?>
				
<? if( !DEVELOPMENT ) { ?>
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
<? } ?>


</td>
</tr>
</table>
<?=$this->Get_Data('footer_links'); ?>

</div><? // End Enclosed Area ?>
</div><? //End Master Area ?>

<? // Get the common javascript stuff at the bottom ?>
<? include( $_SERVER['DOCUMENT_ROOT'].'/site/javascript/common_js.php');?>

<? if( !DEVELOPMENT ) { ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1271965-4";
urchinTracker();
</script>
<? } ?>				
	</body>
</html>

