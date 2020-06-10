<?
/**
 * The Right side ADS
 * This switch pumps out the correct banner code that the classified section requires, such as real estate, restaraunts
 * or the main page.
 */

if( $this->Get_URL_Element( REQUEST_ACTION ) == 'restaurants') { ?>
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/bistro.jpg"><br />
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/cafe.jpg"><br />
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/menu.jpg"><br />

<? } else if ( $this->Get_URL_Element( REQUEST_ACTION ) == 'real_estate')  {?>
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/realestate.jpg"><br />
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/cottage.jpg"><br />
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/homerepair.jpg"><br />
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/homeforsale.jpg"><br />
<? } else { // DEFAULT ?>
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/realestate.jpg"><br />
	<img style="margin-bottom: 12px;border: 1px black solid;" src="/site/images/ads/mockup/cafe.jpg"><br />
<? } ?>