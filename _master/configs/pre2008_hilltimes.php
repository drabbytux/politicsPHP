<? $result_array = $this->Get_Data('orig_issue_result_array'); // The OLD array ?>
<?
// Test for the front throw image. If its a big one, format the table for it.
	$large_throw = false;
	if( array_key_exists( 4, $result_array[7][0] )){
		
		$throw_image_file = $_SERVER['DOCUMENT_ROOT'] . '/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][4];

		if( file_exists( $throw_image_file )) {
			$arr_img_data = getimagesize( $throw_image_file );
			if( $arr_img_data[0] > 400 ){
				$large_throw = true;
			}
		}
	}
?>

<? if( $large_throw ) { // LARGE  throw image style ?>
	<table>
		<tr>
			<td id="coverimagelarge"><? // ---2---  Cover Image ?>
				<?
					if( array_key_exists( 4, $result_array[7][0] )){
						if( file_exists(  $_SERVER['DOCUMENT_ROOT'] . '/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][4]  ) ) {
						$arr_img_data = getimagesize( $_SERVER['DOCUMENT_ROOT'] . '/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][4] );
					?>
						<img src="/<?=$result_array[7][0][0] ?>web_docs/<?=$result_array[7][0][4] ?>" />
						<div class="byline"><?=$result_array[7][0][5] ?></div>
						<div class="caption"><?=$result_array[7][0][6] ?></div>
					<?
					} }
				?>
			</td>
		</tr>
		<tr>
			<td id="coverstorieslarge"><? // ---1--- Show each of the cover stories ?>
				<? 
				$count=0;
				foreach( $result_array[0] as $cover_items ) { // 0 contain photo info
					if( $count!=0){
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $cover_items[1]) ) ); ?> by <?=StripSlashes( $cover_items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $cover_items[0] ) ); ?>">
						<h2><?=StripSlashes( $cover_items[1]); ?></h2>
						<p><?=StripSlashes( $cover_items[2]); ?></p>
						<div class="issue_author">By&nbsp; <?=StripSlashes( $cover_items[3]); ?></div>
						</a>
					<?
					}
					$count++;
				}
				?>
			</td>
		</tr>
	</table>

<? } else { // Normal throw page image style ?>
	<table>
		<tr>
			<td id="coverimage"><? // ---2---  Cover Image ?>
				<?
					if( array_key_exists( 4, $result_array[7][0] )){
						if( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][4] ) ) {
						$arr_img_data = getimagesize( $_SERVER['DOCUMENT_ROOT'] . '/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][4] );
					?>
						<a href="page/view/<?=$this->Get_Folder_Name_For_View( $result_array[7][0][0] . $result_array[7][0][7] );?>"><img src="/<?=$result_array[7][0][0] ?>web_docs/<?=$result_array[7][0][4] ?>" /></a>
						<div class="byline"><?=$result_array[7][0][5] ?></div>
						<div class="caption"><?=$result_array[7][0][6] ?></div>
					<?
					} }
				?>
			</td>
			
			<td id="coverstories"><? // ---1--- Show each of the cover stories ?>
				<? 
				$count=0;
				foreach( $result_array[1] as $cover_items ) { // 0 contain photo info
					if( $count!=0){
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $cover_items[2]) ) ); ?> by <?=StripSlashes( $cover_items[0]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $cover_items[1] ) ); ?>">
						<h2><?=StripSlashes( $cover_items[2]); ?></h2></a>
						<p><?=StripSlashes( $cover_items[3]); ?></p>
						<div class="issue_author">By&nbsp;<?=StripSlashes( $cover_items[0]); ?></div>
						
					<?
					}
					$count++;
				}
				?>
			</td>
			

		</tr>
	</table>
<? } // End of Top Cover story logic 



?>

<div style="margin-top: 12px; border-top: 1px #555 solid;" >&nbsp; </div>
	<table>
		<tr>
			<td id="lefthandcolumn"><? // ---1--- Show each of the cover stories ?>
				<div class="section_heading">News</div>				
<? 
				
				 // News Stories
				 
		
				foreach( $result_array[2] as $items ) {
					
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[2]) ) ); ?> by <?=StripSlashes( $items[0]); ?>" class="issue_entire_item_link"  href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[1] ) ); ?>">
						<h2 style="border-top: 1px #777 solid; margin-top: 5px;"><?=StripSlashes( $items[2]); ?></h2></a>
						<?if( trim($items[3]) ) { ?><div style="padding: 0px;"><?=StripSlashes( $items[3]); ?></div><? } ?>
						<?if( trim($items[0]) ) { ?><div class="issue_author">By&nbsp; <?=StripSlashes( $items[0]); ?></div><? } ?>
						
					<?
				}
				
				 // Other stuff
		
				foreach( $result_array[0] as $items ) {
				
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[2]) ) ); ?> by <?=StripSlashes( $items[0]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[1] ) ); ?>">
						<h2 style="border-top: 1px #777 solid; margin-top: 5px;"><?=StripSlashes( $items[2]); ?></h2></a>
						<?if( trim($items[3]) ) { ?><div style="padding: 0px;"><?=StripSlashes( $items[3]); ?></div><? } ?>
						<?if( trim($items[0]) ) { ?><div class="issue_author">By&nbsp; <?=StripSlashes( $items[0]); ?></div><? } ?>
						
					<?
					
					
				}
				
				?>
			</td>
			
			<td id="righthandcolumn"><? // ---1--- Show each of the cover stories ?>
				<div class="section_heading">Opinion</div>		
				<? 
				 // Editorial / Columns / Opinion
				
				foreach( $result_array[4] as $items ) {
	
						?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[2]) ) ); ?> by <?=StripSlashes( $items[0]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[1] ) ); ?>">
						<h2 style="border-top: 1px #777 solid; margin-top: 5px;"><?=StripSlashes( $items[2]); ?></h2></a>
						<?if( trim($items[3]) ) { ?><div style="padding: 0px;"><?=StripSlashes( $items[3]); ?></div><? } ?>
						<?if( trim($items[0]) ) { ?><div class="issue_author">By&nbsp; <?=StripSlashes( $items[0]); ?></div><? } ?>
						
					<?

				}
				
				 // Culture
				 ?> 	<div class="section_heading">Columns</div>		<?
			
				foreach( $result_array[3] as $items ) {
		
						?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[2]) ) ); ?> by <?=StripSlashes( $items[0]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[1] ) ); ?>">
						<h2 style="border-top: 1px #777 solid; margin-top: 5px;"><?=StripSlashes( $items[2]); ?></h2></a>
						<?if( trim($items[3]) ) { ?><div style="padding: 0px;"><?=StripSlashes( $items[3]); ?></div><? } ?>
						<?if( trim($items[0]) ) { ?><div class="issue_author">By&nbsp; <?=StripSlashes( $items[0]); ?></div><? } ?>
						
					<?

				}
				
				
				?>
			</td>
		</tr>
	</table>
	
	<div style="text-align: center;">
	<?
					 // Cartoon
				$count=0;
				if( array_key_exists( 2, $result_array[7][0] )  ) {
					foreach( $result_array[7] as $items ) {
				
						$cartoon_image_file = $_SERVER['DOCUMENT_ROOT'] . '/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][2];
				
						if( file_exists( $cartoon_image_file ) ) { ?>
							<img src="<?='/'. $result_array[7][0][0] ."web_docs/".$result_array[7][0][2];?>" />	
							
							<? 
						}
					}
				

					
 				}
 				?>
	</div>


