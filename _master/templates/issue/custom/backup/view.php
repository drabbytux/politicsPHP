<h1>Party Time for <?=$this->_formatDate( $this->Get_Data('partytime_unix_date') ); ?></h1>
<script type="text/javascript" src="/site/system/swfobject/swfobject.js"></script>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="631" height="601" id="partytime" align="middle">
<param name="FlashVars" value="xmlfile=/partytime/image_xml/<?=$this->Get_Data('partytime_url_date');?>" />
<param name="movie" value="/site/flash/partytime/partytime.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed FlashVars="xmlfile=/partytime/image_xml/<?=$this->Get_Data('partytime_url_date');?>" src="/site/flash/partytime/partytime.swf" quality="high" bgcolor="#ffffff" width="631" height="601" name="partytime" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

<table style="width: 100%;">
	<tr>
		<td style="width: 75%;">
<?


if( is_array($this->Get_Data('arr_issue_dates')) ) {
	foreach( $this->Get_Data('arr_issue_dates') as $current_issue_date ){
?>
	<h3><a href="/partytime/view/<?=$this->urlDatePartyTime( $current_issue_date['pt_pa_date']); ?>"><?= $this->_formatDate( $current_issue_date['pt_pa_date'] );?></a></h3>
	<div  style="padding: 10px;">
	<?
		foreach( $this->Get_Data('Arr_Index_Issues', $current_issue_date['pt_pa_date']) as $party_item ) {
		?>
			<div style="font-size: 10pt;"><strong><?=$party_item['pt_pa_title'];?></strong><br />
				<span style="font-size: 8pt;"><?=$party_item['pt_pa_blurb'];?></span>
			</div>
		<?	
		}
	?>
	</div>
	
	
	
<? }
}
/*

foreach( $this->Get_Data('arr_albums') as $album ) {
	$str_output .= '<album title="'. $this->cleanXMLText( $album['pt_pa_title'] ).'" description="'.$this->cleanXMLText($album['pt_pa_blurb']).'" tnpath="'.SERVER_URL.'/'.SITE.'/partytime/'. $this->Get_Data('partytime_directory') .'/" lgpath="'.SERVER_URL.'/'.SITE.'/partytime/'. $this->Get_Data('partytime_directory') .'/">' . "\n";
	$arr_albums = $this->Get_Data('arr_photos', $album['pt_pa_date']);
	$arr_album_photos = $arr_albums[ $album['pt_pa_party_name']];
	foreach( $arr_album_photos as $pic ){
		$str_output .= '<img src="'.$pic['pt_im_img_name'].'" tn="th-'.$pic['pt_im_img_name'].'" caption="'. $this->cleanXMLText( $pic['pt_im_cutline'] ).'" />' . "\n";
	}
	$str_output .= '</album>' . "\n";
}
	*/			

?>
	</td>
	<td style="width: 25%;">
		<div style=" background-color: #FBF7E7; padding: 5px;">
			<h4>Archives</h4>
			
	<!--Create the Accordion widget and assign classes to each element-->
	<div id="Accordion1" class="Accordion">
<?	
	
	$panel_number_default = NULL;
	$panel_count = 0;
	foreach( $this->Get_Data('partytime_archives_dates') as $archive_year=>$archive_months ){  
		if( date('Y', $this->Get_Data('partytime_unix_date') ) == $archive_year ) { $panel_number_default = $panel_count; }
		$panel_count++;
		?>
		<div class="AccordionPanel">
			<div class="AccordionPanelTab"><?=$archive_year; ?></div>
			<div class="AccordionPanelContent">
				<? foreach( $archive_months as $archive_month=>$days) { ?>
					<a <?=($archive_month == date('n', $this->Get_Data('partytime_unix_date') ) && $archive_year==date('Y', $this->Get_Data('partytime_unix_date') ) )?'style="font-weight: bold; color: #222;" ':NULL;?>href="/partytime/viewmonth/<?=$archive_month;?>-<?=$archive_year;?>"><?=date('F', mktime(0,0,0,$archive_month,1,date('Y') ) ); ?></a><br />
				<? } ?>
			</div>
		</div>
	<? } ?>
	</div>
<script type="text/javascript">
	var Accordion1 = new Spry.Widget.Accordion("Accordion1", {defaultPanel: <?=$panel_number_default;?> });
</script>
			
			
		</div>
	</td>
	</tr>
	</table>