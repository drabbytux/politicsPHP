<a href="/classifieds/"><?=NEWSPAPER_NAME?> Classifieds</a> &raquo; <a href="/classifieds/sections">Sections</a>  &raquo;  <?=$this->Get_Data('classified_section', 'classified_category_title')?>
<h1><?=$this->Get_Data('classified_section', 'classified_category_title')?></h1>

<?
	if( count( $this->Get_Data('classified_items') ) ){
		print '<table width="100%">';
		foreach( $this->Get_Data('classified_items') as $ci ){ ?>
			<tr><td>
			<div style="font-size: 10pt; font-weight: bold; border-bottom : 1px #AFA078 solid; border-left : 1px #AFA078 solid;padding: 4px; background-color: #FFF6DF;background-image:url('/IMAGES/backgrounds/classifieds_back.gif');">
				<?=$ci['classified_item_title'];?>
			</div>
			<div style="background-color: #fff; padding: 4px;margin-bottom: 14px;">
				<?=$ci['classified_item_description'];?>
			</div>
			</td></tr>
	<?	} // End foreach
	
	print "</table>";
	}


?>
