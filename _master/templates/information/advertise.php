<h1>Advertising with <?=NEWSPAPER_NAME?></h1>
<div style="float: left; width: 160px; margin-right: 2px;"><img width="160" height="640" alt="" src="/site/images/photos/Policy-Briefing-Calendar.jpg" /></div>
<p>At Hill Times Publishing we understand the importance of communicating effectively with the people that matter, we do it twice a week, fifty weeks of the year and we do it so well that 84% of surveyed readers say they rely on <b>The Hill Times</b> and <b>Embassy</b> to stay up-to-date on the information they need.</p>
<p>Whether you need to reach key decision makers more often leading up to an important event or you&rsquo;re establishing a key message for the future <b>The Hill Times</b> and <b>Embassy</b> give you a voice with the audience that will make a difference to your issue, industry or business.</p>

<p>You can contact our sales department by calling 613-232-5952 or by sending an email to <a href="mailto:sales@<?=DOMAIN?>">sales@<?=DOMAIN?></a>.</p>


<?
	if( !$this->Get_Data('advertising_output') ){
		$this->Set_Template_With_PHP( 'advertising_output', 'information/advertise_contact_form.php' );	// Uses the previous variables	

		
	}
	print $this->Get_Data('advertising_output');

?>
	