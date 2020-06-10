<?php

include('database.class.php');
class Classifieds extends Database {
	public $upload_temp_apth_and_file = "/www/dirty.embassymag.ca/secure_files/temp/classifieds_temp.txt";
	public $message;
	private $entire_content;
	public $arr_categories;
	public $arr_items;
	public $arr_cat_ids; // Collected unique ids from Classifieds system
	
	public $var_category 	= '@Header';
	public $var_item_head 	= '@Bold & Centred';
	public $var_item_desc 	= '@Classified Line';
	public $var_graphic 	= '@Graphic:';
	
	function __construct() {
		parent::Database();
	}
	
	public function get_list( $section_id = NULL, $search_str = NULL ){
		$sql = "SELECT * from classified_items order by category";
		$res = $this->ExecuteArray($sql);
		return $res;
	}
	
	public function get_cat_sorted_list(){
		$res = $this->get_list();
		$arr_list = NULL;
		$current_catgory = NULL;
		foreach( $res as $item ){
			if( $current_catgory  == $item['category'] ){
				$arr_list[ $current_catgory ][] = $item;
			} else {
				$current_catgory  = $item['category'];
				$arr_list[ $current_catgory ][] = $item;
			}
		}
		return $arr_list;
	}
	
	public function get_cats( $section_id = NULL, $search_str = NULL ){
		$sql = "SELECT * from classified_category";
		$res = $this->ExecuteArray($sql);
		return $res;
	}

	public function process_classifieds($file= NULL, $travel_file_flag = NULL){
		if( $travel_file_flag ){ // We have the travel section instead
			$this->var_category 	= '@Location heading';
			$this->var_item_head 	= '@Getaways 14';
			$this->var_item_desc 	= '@Getaways body text';
		}
		
		if( $this->upload_classifieds_file( $file ) ){
			$this->parse_content();
			$this->db_replenish_categories();
			$this->db_replenish_items();
		}
		
	}
	
	public function upload_classifieds_file( $file = NULL){
		if( $file ){
			if( is_uploaded_file( $file['tmp_name'] ) ) {
				move_uploaded_file( $file['tmp_name'], $this->upload_temp_apth_and_file );
				$this->entire_content = file_get_contents( $this->upload_temp_apth_and_file );
				if( $this->entire_content ) return true;
			}
		} else {
			$this->message .="<br />Sorry - No file was uploaded.";
		}
		
	}
	
	public function parse_content(){
		// Fix Broad issues with the content;
		// $this->entire_content = str_replace("\0xCA", "\r", $this->entire_content);

		//Get Each line in and create a multi array
		$arr_entire = explode("\r", $this->entire_content );
		$cat_count = 0;
		$item_count = 0;
		$loop_count = 0;
		$arr_items = NULL;
		$hotlink_itemid = NULL;
		$hotlink=false;
		$flag_item_done = false;
		$flag_item_heading_as_desc=false;
		
		// Create an nice array
		foreach ($arr_entire as $line){
			
			$line_caught = false;
			if( strlen($line) > 2 ) // Gets rid of bad lines {
			{
				// Category
					if( $cat_name = strstr( $line, $this->var_category ) ) {
						if( $loop_count!=0){
							$cat_count++;
						}
						$loop_count++;
						$arr_cat[ $cat_count ] = ltrim( strstr($cat_name,':'), ':');
						$line_caught 	= true;
						$hotlink		= false;
						$hotlink_itemid	= false;
						$flag_item_done 	= true;
					}
					
				// Item Title
					if( $item_title = strstr( $line, $this->var_item_head)) {
						if( !$flag_item_done ){	// Catch a DOUBLE Bold&Centered Line, assign it to be picked up by the desc instead
							$flag_item_heading_as_desc = true;
						}
						else
						{
							if( $flag_item_done && $loop_count!=0) {
								$item_count++;
								
							} 
							$flag_item_done = false;
							if( $hotlink ){
								$hotlink_itemid = $item_count;
								$hotlink = false;
							}
													// $arr_items[ $item_count ]->category = $cat_count; 
							$arr_items[ $item_count ]->category = $cat_count;
							$arr_items[ $item_count ]->title = ltrim( strstr($item_title,':'), ':');
							$line_caught = true;
						}
											
					}
			
				// Catch the Hotlink reference, which will make URLs good to go...
					if( $item_desc = strstr( $line, $this->var_graphic )) {
						// HOTLINK appears before the Item Title, which increments the item count.
						// Artificially set the hotlink number to one above the current item count
						if( $item_desc = strstr( $line, $this->var_graphic . 'HOTLINK') ) {
							$hotlink		= true;
						}
						$line_caught 	= true;
					}
					
				// Item Desc
					if( ($item_desc = strstr( $line, $this->var_item_desc )) || ($flag_item_heading_as_desc) ) {
						
						if( $flag_item_heading_as_desc ){
							$item_desc = strstr( $line, $this->var_item_head );
							$flag_item_heading_as_desc = false;
						}				
						$str_desc = ltrim( strstr($item_desc,':'), ':');
						if( $hotlink_itemid==$item_count ){
							$str_desc = $this->set_url( $str_desc );
						}
						$arr_items[ $item_count ]->desc =  $str_desc;
						$line_caught 	= true;
						
						// Set a flag to send back to the next header, since the first one needs to run through fully
						$flag_item_done	= true;
					}
					
				// Catch a bad line with nothing in from of it. Append it to the current item desc
				if( !$line_caught ) {
						if( $hotlink_itemid==$item_count ){
							$str_desc = $this->set_url( $line );
						}
						$arr_items[ $item_count ]->desc =  $arr_items[ $item_count ]->desc ." ". $str_desc;
				}
			} // End of bad line if
				
			
		}
		
		print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
		print_r($arr_cat);
		print "</pre>";
		
		print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
		print_r($arr_items);
		print "</pre>";
		// Store them for use
		$this->arr_categories 	= 	$arr_cat;
		$this->arr_items		=	$arr_items;
	}
	
	private function set_url( $str ){
		// Parse out the URL
		return preg_replace("/[^a-z]+[^:\/\/](www\.". "[^\.]+[\w][\.|\/][a-zA-Z0-9\/\*\-\?\&\%\=\,\.]+)/"," <a href=\"http://$1\" target=\"_blank\">$1</a>", $str);
		
	}
	
	private function db_replenish_categories( ){
		if( $this->arr_categories ){
			$sql_insert = NULL;
			// Delete current Cats
			
			$res = $this->Execute( "DELETE from classified_category" );
			if( $res ){	$this->message .= "<br />1 Classified_Category Table is now Empty.";
			} else { $this->message .= "<br />1 !! Could not Empty Classified_Category Table !!";			}
			// Create new cat query
			$sql = "INSERT into classified_category (`id`, `title`) values";
			foreach( $this->arr_categories as $cat ){
				$entire_cat = trim( str_replace("  ", " ", $cat));
				$arr_for_id = explode(" ", $entire_cat);
				$cid = trim( $arr_for_id[0] );
				$ctitle = trim( strstr($entire_cat, ' ') );
				$collected_ids_for_item_insert[] = $cid;
				$sql_insert .= "('$cid','$ctitle'),";
			}
			//  Store the collected Category IDs for the items to reference
				$this->arr_cat_ids = $collected_ids_for_item_insert;
			
			$sql = trim($sql . $sql_insert, ',') . ';';
			// Replenish The database
			$res = $this->Execute($sql);
			if( $res ){	$this->message .= "<br />Classified_Category Table is now Filled UP.";
			} else { $this->message .= "<br />!! Could not Fill the  Classified_Category Table !!";			}		
		}
	}
	
	private function db_replenish_items(){
		// $this->arr_cat_ids
	if( $this->arr_items ){
			$sql_insert = NULL;
			// Delete current Items
			
			$res = $this->Execute( "DELETE from classified_items" );
			if( $res ){	$this->message .= "<br />2 Classified_Items Table is now Empty.";
			} else { $this->message .= "<br />!! 2 Could not Empty Classified_Items Table !!";			}
			// Create new cat query
			$sql = "INSERT into classified_items (`title`,`description`,`category`) values";
			foreach( $this->arr_items as $item ){
				$sql_insert .= "('";
				$sql_insert .= (isset( $item->title ) )? $this->db_prep( $item->title ): NULL;
				$sql_insert .= "','";
				$sql_insert .= (isset( $item->desc ) )? $this->db_prep( $item->desc ) : NULL;
				$sql_insert .= "','";
				$sql_insert .= (isset(  $item->category ) )? $this->arr_cat_ids[ $item->category ] : NULL;
				$sql_insert .= "'),";
			}
			
			$sql = trim($sql . $sql_insert, ',') . ';';
			// Replenish The database
			$res = $this->Execute($sql);
			if( $res ){	$this->message .= "<br />Classified_Items Table is now Filled UP.";
			} else { $this->message .= "<br />!! Could not Fill the  Classified_Items Table !!";			}		
		}
		
	}
	
	private function db_prep( $str ){
		// Replace those nasty, HIDDEN!!!! ƒ chars
		$str = str_replace("Ê", " ", $str); // ƒ char
		return str_replace("'", "\'", $str);
	}

}
?>