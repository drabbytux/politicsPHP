<?
/**
 * Banner Code
 * Uses Javascript for the local development server
 * Uses LOCAL mode for the production server
 */

/*
 * Embassy Skyscraper 2 - 160x600
 */

if( SITE =='EM' ){

		if( DEVELOPMENT ){
		 ?>

			<!--/* OpenX Javascript Tag v2.6.3 */-->

			<script type='text/javascript'><!--//<![CDATA[
			   var m3_u = (location.protocol=='https:'?'https://www.embassymag.ca/promotions/www/delivery/ajs.php':'http://www.embassymag.ca/promotions/www/delivery/ajs.php');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   if (!document.MAX_used) document.MAX_used = ',';
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("?zoneid=6");
			   document.write ('&amp;cb=' + m3_r);
			   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			   document.write ("&amp;loc=" + escape(window.location));
			   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
			   if (document.context) document.write ("&context=" + escape(document.context));
			   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			   document.write ("'><\/scr"+"ipt>");
			//]]>--></script><noscript><a href='http://www.embassymag.ca/promotions/www/delivery/ck.php?n=a056d666&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://www.embassymag.ca/promotions/www/delivery/avw.php?zoneid=6&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a056d666' border='0' alt='' /></a></noscript>

		 <?
			
		} else { 
		  // --- Embassy Production Banner ---


			  define('MAX_PATH', '/magma/users/u32/magfest/public_html/promotions');
			  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
			    if (!isset($phpAds_context)) {
			      $phpAds_context = array();
			    }
			    $phpAds_raw = view_local('', 6, 0, 0, '', '', '0', $phpAds_context, '');
			  }
			  echo $phpAds_raw['html'];

			
						
					
		  // -- END Embassy Production Banner ---
		}
} // End Embassy

/*
 * Hill Times - Rectangle 1 -TOP Most 300 x 250
 */
if( SITE =='HT' ){
		
		
		if( DEVELOPMENT ){
			
		 ?>
		 <!--/* OpenX Javascript Tag v2.6.3 */-->		

		 
		 <?
			
		} else { 

		}
} // End Hill Times


?>