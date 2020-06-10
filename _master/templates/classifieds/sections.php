<a href="/classifieds/"><?=NEWSPAPER_NAME?> Classifieds</a> &raquo; Sections
<h1>Sections</h1>

<?
if( count( $this->Get_Data('classified_sections') ) ){
	
	$item_counter = 0;
	$split_number = ceil( count( $this->Get_Data('classified_sections') ) / 2) ;	// Half the number of categories
	print '<table width="100%"><tr><td style="width: 50%;">'. "\n";
	foreach( $this->Get_Data('classified_sections') as $cs ) { ?>
		<br /><a href="/classifieds/sections/<?=$cs['classified_category_id'];?>"><?=$cs['classified_category_title'];?> (<?=$cs['item_count'];?>)</a>
	<?	if( $item_counter == $split_number ) {
			print '</td><td style="width: 50%;">'. "\n";
		}
		$item_counter++;
	} 
	print '</td></tr></table>';
 } else { ?>
	There are not categories present in the database.
<? } ?>