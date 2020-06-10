<?
$result_array = $this->Get_Data('orig_issue_result_array');
$development_complete_domain = 'http://current.hilltimes.dev';
 /**
  * Pre-2007 issue template
  * Takes in the OLD array variable and uses it instead of the
  * newer area methodology (issue_old_array_content).
  * $result_array is required
  * 
  * David Little
  */

?>
		<!--  Start Content Area -->
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="1%;">
					<? /**  XO	HomePage Throw (as of Feb 19, 2007) / Cover
						 *  OO
						 */

					
						// HP THROW
						// Feb 19 2007 to September 2007 uses the HP Throw instead of the cover
						if ( isset( $result_array[7][0][0] ) )  {
							?>
							<a href="<?=$result_array[7][0][0].$result_array[7][0][7];?>">
								<img style="border: 1px black solid;" src="<?=$development_complete_domain. "/". $result_array[7][0][0] ."web_docs/" . $result_array[7][0][4]; ?>" /><br />
								<? if ( isset( $result_array[7][0][5] ) ) { print '<div class="photo_credit">'. $result_array[7][0][5] .'</div>';  } // ByLine  ?>
								<? if ( isset( $result_array[7][0][6] ) ) { print '<div class="cutline">'. $result_array[7][0][6] .'</div>';  } // Cutline  ?>
							</a>
							<?
						} else {
							// Kicken it *OLD* School - just show the cover image
							?><img src="<?=$development_complete_domain. '/'. $result_array[1][0][4] ?>" style="border: 1px black solid;"><?
						}

					?>
					
					<!-- END Home Page Throw Photo/Cutline -->
				</td>
				<td style="padding: 0px 16px 0px 8px; width: 99%;">
					<!-- Front Page Story Headlines -->
					<?
						/** OX	Front Page Headlines
						 *  OO
						 */
						$firstitemflag = NULL;
						for ($i = 0; $i < sizeof( $result_array[1] ); $i++)
						{
							if ($firstitemflag){ 
								print '<div id="storyitem">';
							} else {
								$firstitemflag = 1;
								print '<div id="storyitemfirst">';
							}
							print '<a href="/page/view/'. $this->Get_Folder_Name_For_View( $result_array[1][$i][1] ) .'">';
							print '<h2>'. StripSlashes( $result_array[1][$i][2]) . "</h2>";
							if ( isset($result_array[1][$i]) && StripSlashes( $result_array[1][$i][3] )) { ?>
								<div class="cover_kick"><?=StripSlashes( $result_array[1][$i][3]);?>"</div>
							<?
							}
							
							if (StripSlashes( $result_array[1][$i][0] ) )
							{ ?>
								<div class="cover_author">
								<?
								if ( !strstr( StripSlashes( $result_array[1][$i][0] ), "By" ) || strstr( StripSlashes( $result_array[1][$i][0] ), "Commentary" ))
								{
									print "By ";
								}
								echo StripSlashes( $result_array[1][$i][0] ); ?>
								</div>
							<?
							print '</a>';
							}
							print "</div>"; // End Story Item Div
				
						} // End 

					?>
				
					<!-- END Front Page Story Headlines -->
				</td>
			</tr>
			</table>
			
			<table>
			<tr>
				<td style="50%; padding: 8px;">
					<?
						/** OO	Bottom Left News items
						 *  XO
						 */
			if( isset( $result_array[4] ) ){
						print "<h3>News</h3>";
					}
	
							$fistitemflag = NULL;
						for ($i = 0; $i < sizeof( $result_array[2] ); $i++)
						{
										
							if ($firstitemflag){ 
								print '<div id="storyitem">';
							} else {
								$firstitemflag = 1;
								print '<div id="storyitemfirst">';
							}
							
							if ( !strstr(StripSlashes( $result_array[2][$i][4] ), "News") )
							{
								echo "<div style=\"font-size: 8pt;\" class=\"feature_name\">".StripSlashes( $result_array[2][$i][4] )."</div>";
   							}
							echo "<a href=\"/page/view/". $this->Get_Folder_Name_For_View( StripSlashes( $result_array[2][$i][1]  ) )."\">";
							echo StripSlashes( $result_array[2][$i][2] );
							echo "</a>";
							
							if ( StripSlashes( $result_array[2][$i][3] ) )
							{
								echo "<div>"; // Brief intro
								echo StripSlashes( $result_array[2][$i][3] );
								echo "</div>"; // Brief intro
							}
							
							if ( StripSlashes( $result_array[2][$i][0] ) )
							{
								echo "<div class=\"front_author\">";
								if ( !strstr( StripSlashes( $result_array[2][$i][0] ), "By" ))
								{
								echo "By ";
								}
							echo StripSlashes( $result_array[2][$i][0] )."</div>";
							}
						print "</div>"; // End Story Item Div
						}
						
						
						// -- Feature stories - WHERE I LEFT OFF - Sept102007 //
					if( isset( $result_array[4] ) ){
						print "<h3>Features</h3>";
					}
					for ($i = 0; $i < ( sizeof( $result_array[0] ) ); $i++)
							{
																	
							if ($firstitemflag){ 
								print '<div id="storyitem">';
							} else {
								$firstitemflag = 1;
								print '<div id="storyitemfirst">';
							}
								
								if ( StripSlashes( $result_array[0][$i][2] ) )	# lets make sure that there is a headline
								{
									if ( !strstr(StripSlashes( $result_array[0][$i][2] ), "The Spin Doctors") )
									{
										echo "<div class=\"feature_name\">".StripSlashes( $result_array[0][$i][4] )."</div>";
									}
									echo "<a href=\"/page/view/". $this->Get_Folder_Name_For_View( StripSlashes( $result_array[0][$i][1] ) )."\">";
									echo StripSlashes( $result_array[0][$i][2] );
									
					
						
									if (StripSlashes( $result_array[0][$i][3] ))
									{
										echo "<div class=\"sm\">".StripSlashes( $result_array[0][$i][3] )."</div>";
									}
									if ( StripSlashes( $result_array[0][$i][0] ) )
									{
										echo "<div class=\"front_author\">";
										if ( !strstr( StripSlashes( $result_array[0][$i][0] ), "By" ))
										{
											echo "By ";
										}
										echo StripSlashes( $result_array[0][$i][0] )."</div>";
									}
									echo "</a>";
								}
								print "</div>";
							}
						
						
					
						
					?>
					<!-- Left Hand News -->
				
				
					<!-- END Left Hand News -->
				</td>
				<td style="50%; padding: 8px;">
					<?
						/** OO	Bottom Right News Items
						 *  OX
						 */
						// Opinions...
				if( isset( $result_array[4] ) ){
						print "<h3>Opinion</h3>";
					}
					for ($i = 0; $i < ( sizeof( $result_array[4] ) ); $i++)
					{
						if ( StripSlashes( $result_array[4][$i][2] ) )	// lets make sure that there is a headline
						{
							if ( StripSlashes( $result_array[4][$i][4] ) == "Oped" )
							{
								echo "<div class=\"feature_name\">Op-ed</div>";	# Feature name
							}
							else
							{
								echo "<div class=\"feature_name\">".StripSlashes( $result_array[4][$i][4] )."</div>";	// Feature name
							}
							if ( StripSlashes( $result_array[4][$i][2] ) != "Letters" )
								{
									echo "<a href=\"/page/view/". $this->Get_Folder_Name_For_View( StripSlashes( $result_array[4][$i][1] ) ) ."\">";
								}
								else
								{
									echo "<a href=\"/categories/index.php?section_id=4\">";
								}
					
							echo StripSlashes( $result_array[4][$i][2] );	// Title
				
								echo "</a>";
				
							if (StripSlashes( $result_array[4][$i][3] ))   
							{
								echo "<div class=\"sm\">".StripSlashes( $result_array[4][$i][3] )."</div>";
							}
							if ( StripSlashes( $result_array[4][$i][0] ) )
							{
								echo "<div class=\"front_author\">";
								if ( !strstr( StripSlashes( $result_array[4][$i][0] ), "By" ))
								{
									echo "By ";
								}
								echo StripSlashes( $result_array[4][$i][0] )."</div>";
							}
							echo "<hr noshade size=\"1\">";
						}
					}
					
					// Columns
					if( isset( $result_array[3] ) ){
						print "<h3>Columns</h3>";
					}
					for ($i = 0; $i < sizeof( $result_array[3] ); $i++)
					{

							echo "<a href=\"/page/view/". $this->Get_Folder_Name_For_View( StripSlashes( $result_array[3][$i][1] ) )."\">";
						echo "<font size=-1>".StripSlashes( $result_array[3][$i][2] )."</font>";
						echo "</a>";
						if (StripSlashes( $result_array[3][$i][3] ))
						{
							echo "<div class=\"sm\">".StripSlashes( $result_array[3][$i][3] )."</div>";
						}
						if ( StripSlashes( $result_array[3][$i][0] ) )
						{
							echo "<div class=\"front_author\">";
							if ( !strstr( StripSlashes( $result_array[3][$i][0] ), "By" ))
							{
							echo "By ";
							}
							echo StripSlashes( $result_array[3][$i][0] )."</div>";
						}
						echo "<hr noshade size=\"1\">";
					}
						
					
					// Lists
					if( isset( $result_array[5] ) && array_key_exists(0, $result_array[5]) ){
						print "<h3>Lists &amp; Surveys</h3>";
					}
					

					for ($i = 0; $i < sizeof( $result_array[5] ); $i++)
					{
						if ( !strstr(StripSlashes( $result_array[5][$i][4] ), "News") )
						{
							echo "<div class=\"dif\">".StripSlashes( $result_array[5][$i][4] )."</div>";	// Title
						}
						echo "<a href=\"/page/view/". $this->Get_Folder_Name_For_View( StripSlashes( $result_array[5][$i][1] ) )."\">";
						echo StripSlashes( $result_array[5][$i][2] );
						echo	"</a>";
		
						if ( StripSlashes( $result_array[5][$i][3] ) )
						{
							echo "<div class=\"sm\">".StripSlashes( $result_array[5][$i][3] )."</div>";
						}
						if ( StripSlashes( $result_array[5][$i][0] ) )
						{
							echo "<div class=\"front_author\">";
							if ( !strstr( StripSlashes( $result_array[5][$i][0] ), "By" ))
							{
								echo "By ";
							}
							echo StripSlashes( $result_array[5][$i][0] )."</div>";
						}
						echo "<hr noshade size=\"1\">";
					}
		
						
					?>
					<!-- Right Hand News -->
				
				
					<!-- END Right Hand News -->
				</td>
			</tr>
		</table>
		<!--  End Content Area -->