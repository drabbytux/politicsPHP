<?include('site/system/yahoo_calendar_init.php'); ?>
<script type="text/javascript">
<!--
	function checkIt(obj_id){
		document.getElementById(obj_id). checked=true;
	}
//-->
</script>
<div style="text-align: left; font-size: 9pt;"><a href="/search/">Basic Search</a> | Advanced Search</div>

<h1>Advanced Search Results</h1>


<form action="/search/advanced_results/" method="post">
<div id="folding_advanced_search_form">
	<? include('templates/search/advanced_form.php');  ?>
</div>
<?=$this->Get_Data('errors');?>
<?
$search_items_limit = 10; 
$items 				= 1;
$total_items		= 1;
$pages				= 0;
$results_output 	= NULL;
$pagination_output 	= NULL;
$pagination_output_no_javascript = NULL;

if( $this->Get_Data_Holder('search_results')  ){
	$plural = (count( $this->Get_Data('search_count_all_results') == 1)) ? '':'s';

	print $this->Get_Data('search_count_all_results') . ' result'.$plural.' were found.';
	// print count( $this->Get_Data_Holder('search_results') ) . ' result'.$plural.' were found ( in '. $this->Get_Data('mysql_total_time') . " seconds.)";
		foreach($this->Get_Data_Holder('search_results') as $resultitem ) {
			
			// Create a div to seperate pseudo pages
			/*
			if( $items == 1 ) {
				$pages++;
				$display_page_style = ( $pages == 1 )? 'block': 'none';
				$results_output .= "\n". '<div style="display: '.$display_page_style .'; " id="search_result_page_'. $pages .'">' ."\n";
				$results_output .= '<h3 style="display: inline; margin-top: 16px;">Results page '. $pages . "</h3>\n<br/>";
			}
*/

		
			$results_output .= '<div style="margin: 8px 0px 10px 0px;">';
			$results_output .= '<div class="resultsdate">'.date('F j, Y', $resultitem['story_issue_date']) .'</div>';
			$results_output .= '<div class="resultstitle"><a target="_blank" href="/page/view/'. $this->Get_Folder_Name_For_View( $resultitem['story_url_id'] ) .'">'. str_highlight($resultitem['story_title'], $this->get('search_string'),NULL, '<span style="color: #4D88CF;">\1</span>'  ) .'</a></div>';
			//$results_output .= '<div class="resultstext">';
			//$number_to_start = strripos( $resultitem['story_content'], str_replace('"','', $this->data['search_string']) ) ;
			// $start_at_int = ( ($number_to_start - 30) < 0 )? 0: $number_to_start - 30;
			//$results_output .= str_highlight( strip_tags( substr( strip_tags( $resultitem['story_content'] ), $start_at_int, 280 ) ), str_replace('"','', $this->data['search_string']),NULL, '<span style="font-weight: bold; color: #4D88CF;">\1</span>'  ) ;
			$results_output .= '</div>';
			$results_output .= '</div>';

			// Item counter
			$items++;
			$total_items++;
			
			/*
			// Close the pseudo page
			if( $items == $search_items_limit || count( $this->Get_Data_Holder('search_results') ) == $total_items-1 ) {
				$results_output .= '<h3 style="display: inline; margin-top: 16px;">Results page '. $pages . "</h3>\n<br/>";
				$results_output .=  "\n</div>\n";
				$items = 1;
			}
			*/
	}
	
	// Pagination pages
	if( $this->Get_Data('search_count_all_results') ) {
		$page_numbers = ceil( $this->Get_Data('search_count_all_results') / $this->Get('option_results_per_page') );	
	}
	
	
	// Pagination Creation 
	if( $page_numbers > 1 ){
		for( $x=1; $x<=$page_numbers; $x++ ) {
			//$pagination_output .= '<a class="simple_small_button" id="search_result_page_link_'.$x.'\'" style="font-size: 14pt;" href="/search/advanced_results/'.$x.'">'. $x . "</a> \n";
			$pagination_output .= '<input type="submit" value="'.$x.'" name="search_results_page_number" id="search_result_page_link_'.$x.'"';
			$pagination_output .= ( $this->Get('search_results_page_number')==$x || (!$this->Get('search_results_page_number') && $x==1) )? 'class="search_page_submit_selected" />': 'class="search_page_submit" />';
		}
	}
	
	
	// All is complete. Start output.
	
	// print "<br />".$pagination_output;
	print $results_output;
	print "<br />".$pagination_output;
	
} else {
	print "No results found.</em>.";
}


?>
</form>