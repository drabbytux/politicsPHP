<style>
#ambassadors {background-color: #fff;}
#ambassadors td { font-size: 10pt; vertical-align: top; padding: 2px 2px 2px 2px; background-color: #fff;}
#ambassadors .ambassador_title { font-size: 12pt; border-bottom: 1px #333 solid; color: #1F2639;}
</style>

<h1>Embassy Contacts</h1>
<table width="100%" border="0" cellspacing="2" cellpadding="0" id="ambassadors">
	<?
	$tditem = 0;

	foreach( $this->Get_Data('ambassadors_1') as $item ){

		
		$photoname = ($item['photo_name'])?  $item['photo_name'] : 'blank.gif';
			
		//  Table cell with photo
		print '<tr><td style="width: 100px;"><img src="/site/photos/ambassadors/'. $photoname.'" style="border: 1px black solid;padding: 4px; width: 100px; height: 142px"  /></td>';
	
		// Table cell with desc
		print '<td><div class="ambassador_title">'.$item['title'].'</div>';
		print nl2br($item['details']);
		print "</td></tr>\n";
	
	}

	?>
</table>


<h2>OTTAWA INTERNATIONAL CONTACTS</h2>
<table width="100%" border="0" cellspacing="2" cellpadding="0"  id="ambassadors">
	<?
	$tditem = 0;
	foreach( $this->Get_Data('ambassadors_2') as $item ){
	
		$photoname = ($item['photo_name'])?  $item['photo_name'] : 'blank.gif';
		
		//  Table cell with photo
		print '<tr><td><img src="/site/photos/ambassadors/'. $photoname .'" style="border: 1px black solid;padding: 4px; width: 100px; height: 142px"  /></td>';
	
		// Table cell with desc
		print '<td><div class="ambassador_title">'.$item['title'].'</div>';
		print nl2br($item['details']);
		print "</td></tr>\n";
	
	}

	?>
</table>