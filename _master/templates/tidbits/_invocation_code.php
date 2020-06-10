<?php
 include('_define_max_path.php');
	if( defined('MAX_PATH') ) {	// Not defined means it's on the local server - don't show ads
	 if (include_once(MAX_PATH . '/www/delivery/alocal.php')) {
	    if (!isset($phpAds_context)) {
	      $phpAds_context = array();
	    }
	    if( isset( $banner_id ) ) {
	   	 	$phpAds_raw = view_local('', $banner_id, 0, 0, '', '', '0', $phpAds_context);
	    	echo $phpAds_raw['html'];
	    }	
	  }
	} else { // On the local machine, use javascript innvocation
		/*
		$num = rand(48,4329);
		print "<a href='http://hilltimes.com/promotions/www/delivery/ck.php?n=$nzone&amp;cb=".$num."' target='_blank'><img src='http://hilltimes.com/promotions/www/delivery/avw.php?zoneid=$banner_id&amp;cb=".$num."&amp;n=$nzone'"; 
		print (isset($ad_width) && isset($ad_height) && $ad_height && $ad_width ) ? ' width="'.$ad_width.'" height="'.$ad_height.'"': NULL;
		print " border='0' alt='' /></a>";
		*/
	$num = rand(48,4329);	
?>
<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://hilltimes.com/promotions/www/delivery/ajs.php':'http://hilltimes.com/promotions/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?zoneid=<?=$banner_id?>");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://hilltimes.com/promotions/www/delivery/ck.php?n=<?=$banner_id?>&amp;cb=<?=$num?>' target='_blank'><img src='http://hilltimes.com/promotions/www/delivery/avw.php?zoneid=29&amp;cb=<?=$num?>&amp;n=<?=$banner_id?>' border='0' alt='' /></a></noscript>
	<?	
	}
	$banner_id = NULL;
	$ad_width = NULL;
	$ad_height = NULL;
?>