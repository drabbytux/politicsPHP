<?$result_array = $this->Get_Data('orig_issue_result_array'); // The OLD array

function show_talking_points($unix_active_date)
{
	global $site_root,$result_array,$web_server_path,$debug_message;
	$random_pick = rand(0,sizeof($result_array[5])-1);

	echo "<table border=\"0\" cellspacing=\"4\" cellpadding=\"0\" width=\"100%\">";

	echo "<tr><td align=\"left\" valign=\"top\">";

	echo "<a href=\"".$site_root."html/index.php?display=tp&tp_date=".$unix_active_date."#".$result_array[5][$random_pick][0]."\" class=\"head\">".StripSlashes( $result_array[5][$random_pick][1] )."</a>";
	$file_content = file($web_server_path.$result_array[5][$random_pick][0]."body.inc");
	echo "<div class=\"kicker\">".$file_content[0]."</div></td></tr>";
#	echo "<tr>";
#	echo "<td background=\"".$site_root."master_items/hp_images/frame_dot.gif\"><img src=\"".$site_root."master_items/hp_images/frame_dot.gif\" width=\"1\" height=\"1\"></td>";
#	echo "</tr>";
	echo "<tr>";
	
	
	echo "<td width=\"180\" align=\"center\" valign=\"top\"><a href=\"".$site_root."html/index.php?display=tp&tp_date=".$unix_active_date."\"><img src=\"".$site_root."master_items/hp_images/other_tp.gif\" width=\"147\" height=\"16\" border=\"0\"></a><br>";


	for ($i = 0; $i < sizeof( $result_array[5] ); $i++)
	{
		echo "&bull;&nbsp;<a href=\"".$site_root."html/index.php?display=tp&tp_date=".$unix_active_date."#".$result_array[5][$i][0]."\" class=\"tp\">".stripslashes($result_array[5][$i][1])."</a> ";
	}

#	echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\">";
#	for ($i = 0; $i < sizeof( $result_array[5] ); $i++)
#	{
#		echo "<tr><td align=\"left\" valign=\"top\">&bull; <a href=\"".$site_root."html/index.php?display=tp&tp_date=".$unix_active_date."#".$result_array[5][$i][0]."\" class=\"tp\">".stripslashes($result_array[5][$i][1])."</a></td></tr>";
#	}
#	echo "</table>";

	echo "</td></tr></table>";
}
?>
<?	// Test for the front throw image. If its a big one, format the table for it.
	$large_throw = false;
	$throw_image_file = BASE .SITE.'/'. $result_array[0][0][5] ."web_docs/";
	$throw_image_file .= ( trim( $result_array[0][0][2] ) )? $result_array[0][0][2]: 'hp_throw.jpg';
	
	if( file_exists( $throw_image_file ) ) {

		$arr_img_data = getimagesize( $throw_image_file );
		if( $arr_img_data[0] > 400 ){
			$large_throw = true;
		}
	}


?>

<? if( $large_throw ) { // LARGE  throw image style ?>
	<table>
		<tr>
			<td id="coverimagelarge"><? // ---2---  Cover Image ?>
				<?
					
					if( file_exists(  $throw_image_file  ) ) {
						$arr_img_data = getimagesize( $throw_image_file );
					?>
						<img src="/<?=SITE;?>/<?=$result_array[0][0][5] ?>web_docs/<?=$result_array[0][0][2];?>" />
						<div class="byline"><?=$result_array[0][0][3] ?></div>
						<div class="caption"><?=$result_array[0][0][4] ?></div>
					<?
					}
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
						<div class="issue_author">By&nbsp;<?=StripSlashes( $cover_items[3]); ?></div>
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
			<td id="coverstories"><? // ---1--- Show each of the cover stories ?>
				<? 
				$count=0;
				foreach( $result_array[0] as $cover_items ) { // 0 contain photo info
					if( $count!=0){
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $cover_items[1]) ) ); ?> by <?=StripSlashes( $cover_items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $cover_items[0] ) ); ?>">
						<h2><?=StripSlashes( $cover_items[1]); ?></h2>
						<p><?=StripSlashes( $cover_items[2]); ?></p>
						<div class="issue_author">By&nbsp;<?=StripSlashes( $cover_items[3]); ?></div>
						</a>
					<?
					}
					$count++;
				}
				?>
			</td>
			
			<td id="coverimage"><? // ---2---  Cover Image ?>
				<?
					
					if( file_exists( $throw_image_file ) ) {
						$arr_img_data = getimagesize( $throw_image_file );
					?>
						<img src="/<?=SITE;?>/<?=$result_array[0][0][5] ?>web_docs/<?=$result_array[0][0][2];?>" />
						<div class="byline"><?=$result_array[0][0][3] ?></div>
						<div class="caption"><?=$result_array[0][0][4] ?></div>
					<?
					} 
				?>
			</td>
		</tr>
	</table>
<? } // End of Top Cover story logic 


/*
 * Now for the Talking points and party time throw
 * 
 */


?>
<div style="padding: 20px; border: 2px #555 solid; margin: 8px 0px;">

<table>
	<tr>
		<td>
		<? // Talking Points ?>
		<? if ( array_key_exists(5, $result_array ) && count($result_array[5] ) ) { ?>
		<img src="/site/images/titles/talking_points.gif" width="299" height="29" border="0">
		<? 
			$random_pick = rand(0,sizeof($result_array[5])-1);
			$str_tp = NULL;
			//Show the highlighted one
			$file_contents = $_SERVER['DOCUMENT_ROOT'].'/'. SITE .'/'.$result_array[5][$random_pick][0]."body.inc";
			if( file_exists( $file_contents ) ){
				print '<div style="text-align: center;"><h2>'. stripslashes( $result_array[5][$random_pick][1] )."</h2>";
				print stripslashes( file_get_contents($file_contents) );
				print "</div>";
			}
			
			//Show the rest of the TPs

			foreach($result_array[5] as $tp )
			{
				echo "&bull;&nbsp;<a href=\"/page/view/". $this->Get_Folder_Name_For_View( StripSlashes( $tp[0] ) ) ."\" class=\"tp\">".stripslashes($tp[1])."</a> ";
			}
			
		} // End if 5 arraykey exists
		?>
		</td>
		<td style="width: 1%;"> <? // Party Time Throw ?>
			<?
			$pt_throw = $_SERVER['DOCUMENT_ROOT'].'/'. SITE.'/'.$result_array[0][0][5]."party_time/hp_throw.jpg" ;

				if ( file_exists( $pt_throw ) )
				{
					echo "<a href=\"/". SITE.'/'.$result_array[0][0][5]."party_time/\"><img src=\"/".SITE . '/'. $result_array[0][0][5]."party_time/hp_throw.jpg\" width=\"180\" style=\"border: 1px black solid;\"></a>";
				} 
			?>
			
			
			
		</td>
	</tr>
</table>
													
</div>
<?
/*
result_array[0] - Cover stories

result_array[1] - News stories
result_array[4] - ?
 
 
 result_array[5] - Talking points
 
 
  	result_array[3] - Editorial/Opinion/Columns
	result_array[2] - Culture	
	result_array[6] - letters
	result_array[7] - Cartoons
*/
?>
	<table>
		<tr>
			<td id="lefthandcolumn"><? // ---1--- Show each of the cover stories ?>
				<div class="section_heading">Embassy News</div>				
<? 
				
				 // News Stories
				 
		
				foreach( $result_array[1] as $items ) {
					
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[1]) ) ); ?> by <?=StripSlashes( $items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[0] ) ); ?>">
						<h3><?=StripSlashes( $items[1]); ?></h3></a>
						<?if( trim($items[2]) ) { ?><p><?=StripSlashes( $items[2]); ?></p><? } ?>
						<?if( trim($items[3]) ) { ?><div class="issue_author">By&nbsp;<?=StripSlashes( $items[3]); ?></div><? } ?>
						
					<?
				}
				
				 // Other stuff
		
				foreach( $result_array[4] as $items ) {
				
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[1]) ) ); ?> by <?=StripSlashes( $items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[0] ) ); ?>">
						<h3><?=StripSlashes( $items[1]); ?></h3></a>
						<?if( trim($items[2]) ) { ?><p><?=StripSlashes( $items[2]); ?></p><? } ?>
						<?if( trim($items[3]) ) { ?><div class="issue_author">By&nbsp;<?=StripSlashes( $items[3]); ?></div><? } ?>
						
					<?
					
					
				}
				
				?>
			</td>
			
			<td id="righthandcolumn"><? // ---1--- Show each of the cover stories ?>
				<div class="section_heading">Embassy Opinion</div>		
				<? 
				 // Editorial / Columns / Opinion
				
				foreach( $result_array[3] as $items ) {
	
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[1]) ) ); ?> by <?=StripSlashes( $items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[0] ) ); ?>">
						<h3><?=StripSlashes( $items[1]); ?></h3></a>
						<?if( trim($items[2]) ) { ?><p><?=StripSlashes( $items[2]); ?></p><? } ?>
						<?if( trim($items[3]) ) { ?><div class="issue_author">By&nbsp;<?=StripSlashes( $items[3]); ?></div><?} ?>
						
					<?

				}
				
				 // Culture
				 ?> 	<div class="section_heading">Embassy Culture</div>		<?
			
				foreach( $result_array[2] as $items ) {
		
					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[1]) ) ); ?> by <?=StripSlashes( $items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[0] ) ); ?>">
						<h3><?=StripSlashes( $items[1]); ?></h3></a>
						<?if( trim($items[2]) ) { ?><p><?=StripSlashes( $items[2]); ?></p><? } ?>
						<?if( trim($items[3]) ) { ?><div class="issue_author">By&nbsp;<?=StripSlashes( $items[3]); ?></div><? } ?>
						
					<?

				}
				
				 // Letters
				$count=0;
				foreach( $result_array[6] as $items ) {

					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[1]) ) ); ?> by <?=StripSlashes( $items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[0] ) ); ?>">
						<h3><?=StripSlashes( $items[1]); ?></h3></a>
						<?if( trim($items[2]) ) { ?><p><?=StripSlashes( $items[2]); ?></p><? } ?>
						<?if( trim($items[3]) ) { ?><div class="issue_author">By&nbsp;<?=StripSlashes( $items[3]); ?></div><? } ?>
						</a>
					<?

				}
				
				 // Cartoons
				$count=0;
				if( array_key_exists( 7, $result_array )  ) {
				foreach( $result_array[7] as $items ) {

					?>
						<a title="Read <?=htmlentities(strip_tags( StripSlashes( $items[1]) ) ); ?> by <?=StripSlashes( $items[3]); ?>" class="issue_entire_item_link" href="/page/view/<?=$this->Get_Folder_Name_For_View( StripSlashes( $items[0] ) ); ?>">
						<h3><?=StripSlashes( $items[1]); ?></h3>
						<?if( trim($items[2]) ) { ?><p><?=StripSlashes( $items[2]); ?></p><? } ?>
						<?if( trim($items[3]) ) { ?><div class="issue_author">By&nbsp;<?=StripSlashes( $items[3]); ?></div><? } ?>
						
					<?

				} }
				?>
			</td>
		</tr>
	</table>




