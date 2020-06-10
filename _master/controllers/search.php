<?php

require_once 'controllers/issue.php';
require_once 'languages/en/simple_search_word_list.php';
class Search extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C     M E T H O D S - - - - - - - - - - - - - - - \\

	function Search(){
		$this->__construct();
	}
	
	function index(){
		$this->data['page_type'] = 'search';
		$this->Set_Template( 'output', 'search/default.php' );	// Uses the previous variables
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
		function advanced(){
		$this->data['page_type'] = 'search';
		$this->Set_Template( 'output', 'search/advanced.php' );	// Uses the previous variables
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	
	/**
	 * results function called on fresh search from header
	 */
	public function results(){

		$this->data['page_type'] = 'search';
		// View requires var 1 
		if( $this->Get('search_string_header') || $this->Get_URL_Element( VAR_1 ) ){
			// Search String Called. Go!
			$this->data['search_string'] =  ( $this->Get_URL_Element( VAR_1 ) ) ? stripSlashes( $this->Get_URL_Element( VAR_1 ) ): stripSlashes( $this->Get('search_string_header', true) );
			// $this->_make_Search_String_Elements();	// Create the search string - break into array of items
			// $this->_search_Stories();
		}
		
		$this->Set_URL_Wrapper( '/search/results/'. $this->Get_Data('search_string') );
		$this->Set_Template_With_PHP( 'output', 'search/default.php' );	// Uses the previous variables
		$this->Set_Common_Templates();
		$this->Output_Page();

	}
	
	/**
	 * results function called on fresh search from header
	 */
	public function advanced_results(){
		// View requires var 1 
		$this->data['page_type'] = 'search';
		// Search String Called. Go!

			if( $this->Get('search_string_header') ){
				$this->data['search_string'] =  ( $this->Get_URL_Element( VAR_1 ) ) ? stripSlashes( $this->Get_URL_Element( VAR_1 ) ): stripSlashes( $this->Get('search_string_header', true) );
				$this->_make_Search_String_Elements();	// Create the search string - break into array of items	
			} else {
				$this->data['search_string'] =  ( $this->Get_URL_Element( VAR_1 ) ) ? stripSlashes( $this->Get_URL_Element( VAR_1 ) ): stripSlashes( $this->Get('search_string', true) );
				$this->_make_Search_String_Elements();	// Create the search string - break into array of items
			}
		
		// ADV OPTION: Check for Authors ID
		if( $this->Get('author_id') && $this->Get('include_author') ){
			$this->data['search_author_id'] = $this->Get('author_id');
		}

		// ADV OPTION:  Check for Date Range
		if(  $this->Get('include_date_range') ){
			// Start and End dates saved as unix
			$this->data['search_unix_date_start'] 	= ( $this->Get('startMonth') && $this->Get('startDay') && $this->Get('startYear') )?  mktime(0,0,0,$this->Get('startMonth'),$this->Get('startDay'),$this->Get('startYear'))  : NULL;
			$this->data['search_unix_date_end'] 	= ( $this->Get('endMonth') && $this->Get('endDay') && $this->Get('endYear') )?  mktime(0,0,0,$this->Get('endMonth'),$this->Get('endDay'),$this->Get('endYear'))  : NULL;
		}
		
		
		$this->_search_Stories(1);
		if( !$this->Get_Data('search_count_too_high') ) {
			$this->_search_Stories();
		} else{
			$this->Set_Error('Your search string has returned too many results.Please narrow down your search.');
		}
		$this->Set_URL_Wrapper( '/search/advanced_results/'. $this->Get_Data('search_string') );
		$this->Set_Template_With_PHP( 'output', 'search/advanced_results.php' );	// Uses the previous variables
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	public function ajaxResults(){
		if( $this->Get('search_string') ){
			// Search String Called. Go!
			$this->data['search_string'] =  stripSlashes( $this->Get('search_string') );
			$this->_make_Search_String_Elements();	// Create the search string - break into array of items
			$this->_search_Stories();
		}
		$this->Set_URL_Wrapper( '/search/results/'. $this->Get_Data('search_string') );
		$this->Set_Template( 'output', 'search/search_results_ajax.php' );
		$this->Output_Page();

	}
	
	/**
	 * This is also within the issue controller - a little redundant, but needs to be. No time to explain now... Get back to Work!
	 */
	public function Get_Folder_Name_For_View( $folder_name, $revert_to_original = NULL ){
		// One thing about the issue result vars: the slashes are in the wrong place when
		// associated to the story DB entries. Yuk. Fix em here.
		if( $folder_name ){

			if( $revert_to_original ){
				return str_replace('.','/', $folder_name); 
			} else {
				if( strstr($folder_name, "/") ){
					$folder_name = '/'. trim( $folder_name, '/');
					return str_replace('/','.', $folder_name); 
				} else {
					return $folder_name;
				}
			}
		}
	}
	
	// - - - - - - - - - - - - - - P R I V A T E    M E T H O D S - - - - - - - - - - - - - - - \\
	
	/**
	 * ORDER OF SEARCH
	 * 1) Entire String Match in Title
	 * 2) Entire String match in Story [ By Total Times Found ]
	 * 3) Count total of each string element in story
	 * 
	 */

	private function _search_Stories( $return_count_all_records = NULL){
		$word_counter = 0;
		$match = NULL;
		$sql_combine = 'WHERE';
		foreach( $this->Get_Data_Holder('search_words') as $word ) {
			$word_counter++;
			// We are using boolean values to do a full text search. If the person already placed a '+' or '-', we don't have to.
			$match .= ( ( strpos( $word, '+') === 0) || ( strpos( $word, '-') === 0)  )? $this->addSingleQuoteSlashes($word) ." " : '+'. $this->addSingleQuoteSlashes($word) . " ";
		}

		
		// Should be bother searching?
		if( ($this->Get_Data('include_author') && $this->Get_data('search_author_id') ) || ( $match && $this->Get('include_search_string' )) || $this->Get('include_date_range') && ( $this->Get_Data('search_unix_date_start') || $this->Get_Data('search_unix_date_end'))  ) {
			
			// Start it off right
				$sql = ($return_count_all_records)? 'SELECT count(*)': "SELECT story_id, story_issue_date,  story_title, story_url_id"; 
			
			// Add the search string, if one was passed and if one was needed
				if( $this->Get_Data('search_string') && $this->Get('include_search_string' ) ) {
					$sql .=", MATCH(story_title,story_content)";
					$sql .=" AGAINST ('";
					$sql .= $match; 
					$sql .= "' IN BOOLEAN MODE) as story_score";
				}
				
				$sql .= " from story as s";

						// Adding the author to the SQL statement
				if( $this->Get_Data('include_author') && $this->Get_data('search_author_id') ){
					$sql .= " LEFT join `join-author-story` as jas on (s.story_id=jas.`join-author-story_story_id`)";
					$sql .= " $sql_combine  jas.`join-author-story_author_id`=". $this->Get_Data('search_author_id');
					$sql_combine = "AND";
				} 
				
					// The matching of the search string, if it was asked for
				if( $this->Get_Data('search_string') && $this->Get('include_search_string' ) ) {
					$sql .=" $sql_combine MATCH(story_title,story_content)";
					$sql .=" AGAINST ('";
					$sql .= $match; 
					$sql .= "' IN BOOLEAN MODE)";
					$sql_combine = "AND";
				} 

				
				
				// Adding the Date Range to the SQL statement
				if( $this->Get('include_date_range') && ($this->Get_Data('search_unix_date_start') || $this->Get_Data('search_unix_date_end'))  ) {
					if( $this->Get_Data('search_unix_date_start') ){
						$sql .= "  $sql_combine story_issue_date >='".$this->Get_Data('search_unix_date_start')."'";
						$sql_combine = "AND";
					}
					if( $this->Get_Data('search_unix_date_end') ){
						$sql .= " $sql_combine story_issue_date <='".$this->Get_Data('search_unix_date_end') . "'";
							$sql_combine = "AND";
					}
				}
				if( $return_count_all_records ){
					$sql .= " GROUP BY story_id";
				}
				
				// Sort by Relevence doesn't work without a search term. Make it go by Story Date
				if( ($this->Get('option_sort_by') == 'story_score desc') && !($this->Get_Data('search_string') && $this->Get('include_search_string' ) ) ) {
					$sql .= ' order by story_issue_date desc';
				} else {
					$sql .= ' order by '. $this->Get('option_sort_by');
				}
				if( !$return_count_all_records ) {
					
					// Helps with pagination, page limit
					$page_number = ($this->Get('search_results_page_number'))? $this->Get('search_results_page_number')-1: 0;
					$this->data['option_results_start_at_record'] = $this->Get('option_results_per_page') * $page_number;
					$sql .= " limit ";
					$sql .= $this->Get_Data('option_results_start_at_record');
					$sql .= ','. $this->Get('option_results_per_page');
					
					$mysql_start_time = microtime();
					$this->data_holder['search_results'] = $this->ExecuteArray($sql);
					$mysql_end_time = microtime();
					$this->data['mysql_total_time'] = $mysql_end_time - $mysql_start_time;
				} else { // just returning the count of ALL records
					$this->data['search_count_all_results'] = count( $this->ExecuteArray($sql) );
					if( $this->Get_Data('search_count_all_results') >= SEARCH_MAX_RESULTS_COUNT ){
						$this->data['search_count_too_high'] = true;
					}
				}
				

		} else{
			
			// Nothing was asked for, nothing to give back.
		}
		
		
	}
	
	/**
	 * _pagination sets the page numbers
	 *
	 */
	private function _pagination(){
		if( $this->Get_Data('search_count_all_results') ){
			$this->data['search_number_of_pages'] = "";
		}
		
	}
	
	private function _make_Search_String_Elements(){
		$arr_search_string_1 = array();
		if( $this->data['search_string'] && !$this->_is_quoted( $this->data['search_string'] ) ) {
			$arr_search_strings 	= $this->_Break_Up_Search_String( $this->data['search_string'] );
			$arr_search_string_1 	= $this->Remove_Array_Elements( $arr_search_strings  );		// "Stephen Harper" environment policy
			$this->data_holder['search_words'] 		= $this->_Remove_Simple_Words( $arr_search_string_1 );
		} else {
			$this->data_holder['search_words'][0] 	= $this->data['search_string'];
		}
	}
	
	/**
	 * _is_quoted
	 * 	We are checking to see if it's both quoted text (either sides)
	 *	PLUS make sure there aren't any " within the text.
	 *	We are ignoring single quotes WITHIN the text for abbreviations and possessive phrasing
	 * 
	 */
	private function _is_quoted( $str ){
		$pattern_1 = '/^\"(.*)\"$/';
		$pattern_2 = '/^\'(.*)\'$/';
		if( (preg_match( $pattern_1, $str ) || preg_match( $pattern_2, $str )) && !( strstr( $this->_strip_quotes($str), '"' )  ) ) {
			return true;
		}
		return false;
	}
	
	/**
	 * _strip_quotes
	 * Removed both single and double quotes from the first and last character of 
	 * a string.
	 * A second variable can be set to TRUE to remove ALL single and double quotes
	 * from a string.
	 */
	private function _strip_quotes( $str, $bool_all_quotes = false ){
		return ($bool_all_quotes)? str_replace('"', str_replace("'", $str) ) : rtrim( ltrim( $str, '"\''), '"\'');
	}
	
	private function _Break_Up_Search_String( $str ){
		$arr_words = array();
		$flag_quotes = false;
		$str_word = NULL;
		$int_word_count = 0;
		
		foreach( str_split($str) as $chr ){
					
			/* FLAG Setting for quoted strings */
			if( $chr == '"' ){ 
				if(!$flag_quotes){
					$flag_quotes = 1;
				} else if( $flag_quotes == 1){
					$flag_quotes = 2;
				}
			}
			
			// A new word has started, OUTSIDE of the quotes
			if( $chr == " " && !$flag_quotes ){
				$int_word_count++;
			}	
			
			// If it's NOT a space or NOT a quote and NOT within quotes, put it in....
			if( $chr != " " && $chr != '"' && !$flag_quotes) {
				$arr_words[$int_word_count] =  (array_key_exists( $int_word_count, $arr_words ) )? $arr_words[$int_word_count] . $chr : $chr;
			// If it's NOT a quote, but IS within the quotes (Spaces ARE allowed now)
			} else if ($flag_quotes){
				$arr_words[$int_word_count] =  (array_key_exists( $int_word_count, $arr_words ) )? $arr_words[$int_word_count] . $chr : $chr;
				if( $chr == '"' && $flag_quotes == 2){
					$flag_quotes = false;
				}
			}
		}		
		return $arr_words;
	}
	
	private function _Remove_Simple_Words( $arr ){
		GLOBAL $search_string_words_to_be_removed;
		return $this->Remove_Array_Elements( $arr, $search_string_words_to_be_removed  );
	}

	
}
?>