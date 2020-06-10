<table><tr>
<td style="width: 175px;">
	<?=NEWSPAPER_NAME;?> Archives
	<div id="archive_months_and_days" class="archive_container" style="border-left: 1px #999 solid; border-right: 1px #999 solid;">

		<!--Create the Accordion widget and assign classes to each element-->
			<div id="Accordion1" class="Accordion">
		
		<?	
			$panel_number_default = NULL;
			$panel_count		=0;
			foreach( $this->Get_Data('all_issue_dates') as $archive_year=>$archive_months ){ 
			//$this->Get_Data('current_date_selected')
			if( date('Y', $this->Get_Data('current_date_selected') ) == $archive_year ) { $panel_number_default = $panel_count; }
			$panel_count++;
			?>
		
				<div class="AccordionPanel">
					<div class="AccordionPanelTab"><?=$archive_year; ?></div>
					<div class="AccordionPanelContent"   style=" height: 300px;">
						<? foreach( $archive_months as $archive_month=>$days) { ?>
							<span <?=($archive_month == date('F', $this->Get_Data('current_date_selected') ) && $archive_year==date('Y', $this->Get_Data('current_date_selected') ) )? ' style="font-weight: bold; color: #004277;" ':NULL;?>><?=$archive_month;?></span><br />
							<? foreach( $days as $day=>$unixts ){ 
									if( $unixts <= mktime() ) {
									?>
								<a class="simple_small_button" style="font-size: 8pt; margin: 4px; padding: 0px; <?=( $archive_month == date('F', $this->Get_Data('current_date_selected') ) && $archive_year==date('Y', $this->Get_Data('current_date_selected') ) && (date('j', $unixts) == date('j', $this->Get_Data('current_date_selected') ) )  )?'font-weight: bold; color: #004277; ':NULL;?>" href="/issue/archive/<?=$archive_year;?>/<?=date('Y-m-d', $unixts);?>"><?=date('jS', $unixts);?></a>
							<? 		}
								}?><br />
						<? } ?>
					</div>
				</div>
			<? } ?>
			</div>
		<script type="text/javascript">
			var Accordion1 = new Spry.Widget.Accordion("Accordion1", {defaultPanel: <?=$panel_number_default;?>});
		</script>
		<?//=$str_out; ?>
		
	</div>
</td>
<td style="width: 465px; ">
	
<?	

/* The Headlines from the issue */
	if( is_array( $this->Get_Data_Holder('issue_headlines') )) {
		

	
		// Issue Graphic

		$cover_image_path_and_file = PATH_TO_COVER_IMAGES .'/'. date('Y', $this->Get_Data('current_date_selected') ) . '/' . strtolower( date('F', $this->Get_Data('current_date_selected') ) ) . '/';
		$cover_image_path_and_file .=  date('m', $this->Get_Data('current_date_selected') ). date('d', $this->Get_Data('current_date_selected') ). date('y', $this->Get_Data('current_date_selected') ).'_cover.jpg';
		$cover_image_url = URL_PHOTOS_DIR . '/'. date('Y', $this->Get_Data('current_date_selected') ) . '/' . strtolower( date('F', $this->Get_Data('current_date_selected') ) ) . '/';
		$cover_image_url .= date('m', $this->Get_Data('current_date_selected') ). date('d', $this->Get_Data('current_date_selected') ). date('y', $this->Get_Data('current_date_selected') ).'_cover.jpg';
		if( file_exists( $cover_image_path_and_file ) ) {
			// '/'. SITE.'/'. date('Y', $this->Get_Data('current_date_selected') ) . '/' . strtolower( date('F', $this->Get_Data('current_date_selected') ) ) . '/' 
					// print '<div  class="archive_cover_image"><table><tr><td style="width: 225px;"><img src="'.$cover_image_url.'" style="width: 225px;" />';			
							print '<div class="archive_cover_image" style="margin-bottom: 10px;"><table><tr><td style="width: 225px;"><img src="'.$cover_image_url.'" style="width: 225px;" />';		
		// Date
			print '</td><td style="width: 250px;"><h2>'. date('F d, Y', $this->Get_Data('current_date_selected')). '</h2>';
		//PDF version
			print '<a class="simple_small_button" href="/pdf/view/'.$this->Get_Data('current_date_selected_URL').'"><img src="/site/images/icons/pdf.gif"> View PDF</a>';
		// Online version
			print '<br /><a class="simple_small_button" href="/issue/view/'.$this->Get_Data('current_date_selected_URL').'"><img style="margin-left: 4px;" src="/site/images/icons/new_page.png"> View Online</a>';
			print '</td></tr></table></div>';
		} else { // We are going to take a look for the OLD covers in the older method
			$old_issue_path_with_partial_file_name = '/'. SITE.'/'. date('Y', $this->Get_Data('current_date_selected') ) . '/' . strtolower( date('F', $this->Get_Data('current_date_selected') ) ) . '/' . date('j', $this->Get_Data('current_date_selected') ) . '/web_docs/' . date('m', $this->Get_Data('current_date_selected') ). date('d', $this->Get_Data('current_date_selected') ). date('y', $this->Get_Data('current_date_selected') );
			$old_issue_cover_image =  $old_issue_path_with_partial_file_name . '_cover.jpg';
			$old_issue_front_image =  $old_issue_path_with_partial_file_name . '_front.jpg';

			if( file_exists( $_SERVER['DOCUMENT_ROOT'] . $old_issue_cover_image ) ) {
				print '<div class="archive_cover_image" style="margin-bottom: 10px;"><table><tr><td style="width: 225px;"><img src="'.$old_issue_cover_image.'" style="width: 225px;" />';		
			} else {
				if(  file_exists( $_SERVER['DOCUMENT_ROOT'] . $old_issue_front_image ) ) {
					print '<div  class="archive_cover_image"><table><tr><td style="width: 225px;"><img src="'.$old_issue_front_image.'" style="width: 225px;" />';			
			
				} else {
					print '<div  class="archive_cover_image"><table><tr><td style="width: 225px;"><img src="/site/images/icons/no-cover-image.gif" style="width: 180px;" />';			
				}
			}
		// Date
			print '</td><td style="width: 250px;"><h2>'. date('F d, Y', $this->Get_Data('current_date_selected')). '</h2>';
		//PDF version
			print '<a class="simple_small_button" href="/pdf/view/'.$this->Get_Data('current_date_selected_URL').'"><img src="/site/images/icons/pdf.gif"> View PDF</a>';
		// Online version
			print '<br /><a class="simple_small_button" href="/issue/view/'.$this->Get_Data('current_date_selected_URL').'"><img style="margin-left: 4px;" src="/site/images/icons/new_page.png"> View Online</a>';
			print '</td></tr></table></div>';	
		}
		
		// print '</td></tr><tr><td style="width: 100%; ">'; // End the top 2 cell table with dates and picture.
		
		print "\n\n". '<div id="archive_headlines" class="archive_container">';
		// Sort Bar and Search - Author,etc.
		print '<div style="border-top: 1px #ccc solid; border-bottom: 1px #ccc solid;">';
		
		// print '<a href="'. $this->Get_Sort_URL() .'/title" class="simple_small_button" style="font-size: 9pt;">By Title</a> | <a href="'. $this->Get_Sort_URL() .'/author" class="simple_small_button" style="font-size: 9pt;">By Author</a> <!-- <a href="/" class="simple_small_button" style="font-size: 9pt;">By Section</a> -->';
		// print '&nbsp; &nbsp; <input type="text" name="search_issue"><input type="submit" value="Search within this issue" />';
		
		// Pump out the headlines for this issue
		foreach( $this->Get_Data_Holder('issue_headlines') as $issue_headline ){
			if( $this->Get_URL_Element(VAR_3) == 'author' ){
			?>
				<div class="headline">
				<strong><?=$this->Output_Authors( $issue_headline, 'arr_authors' );?></strong><br />
				<a class="headlines_item" href="/page/view/<?=$this->Get_Folder_Name_For_View( $issue_headline['story_url_id'],NULL, $this->Get_Data('current_date_selected') );?>"><?=$issue_headline['story_title'];?></a>
				</div>
			<?	
			} else {
			?>
				<div class="headline">
				<a class="headlines_item" href="/page/view/<?=$this->Get_Folder_Name_For_View( $issue_headline['story_url_id'],NULL, $this->Get_Data('current_date_selected') );?>"><?=$issue_headline['story_title'];?></a>
				</div>
		<? }
		
		}
		
		print '</div>';

	} else {
		print $this->Get_Data('lang_message_issue_no_issues');
	}

?>

</td></tr></table>