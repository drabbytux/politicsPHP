<?php

/**
 *  Paragraph standards
 *  - - - - - - - - - - 
 * 1)Use on-the-fly paragraph tags:
 *	 	story_current_story_dir has an entry
 * 			AND
 *	 	story_updated is NULL
 *	 		AND
 *		story_super_section_id is present
 * 
 * 2) Edit - insert paragraph tags with ALL proper code
 * 
 * 
 */


require_once 'controllers/issue.php';
class Partytime extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Partytime(){
		$this->__construct( true );
	}
	
	public function index(){
		$this->view();
	}
	
	public function view(){
		if( $this->Get_URL_Element( VAR_1 ) ){
			$arr_month_year 	= explode( '-', $this->Get_URL_Element( VAR_1 ) );
			$first_date_unix 	= mktime( 0,0,0, $arr_month_year[0], 1, $arr_month_year[2]  );
			$last_date_unix 	= mktime( 11,59,59, $arr_month_year[0], date('t', $first_date_unix ), $arr_month_year[2]  );
		} else {
			$seg_date = $this->urlDatePartyTime( $this->_getLatestPartyTimeDate() );
			$arr_month_year 	= explode( '-', $seg_date);
			$first_date_unix 	= mktime( 0,0,0, $arr_month_year[0], 1, $arr_month_year[2]  );
			$last_date_unix 	= mktime( 11,59,59, $arr_month_year[0], date('t', $first_date_unix ), $arr_month_year[2]  );
		}

		
		$this->setPartyTimeDate($first_date_unix, $last_date_unix);
		$this->setPartyTimeIndex($first_date_unix, $last_date_unix);
		$this->setPartyTimeArchiveDateArray();
		
		if( $this->Get_Data('partytime_unix_date') ) {
			$this->Set_Template( 'output', 'partytime/view.php' );	// Uses the previous variables
		}
		else {
			$this->Set_Template( 'output', 'partytime/index.php' );	// Uses the previous variables
		}

		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	public function viewmonth(){
		$arr_month_year 	= explode( '-', $this->Get_URL_Element( VAR_1 ) );
		$first_date_unix 	= mktime( 0,0,0, $arr_month_year[0], 1, $arr_month_year[1]  );
		$last_date_unix 	= mktime( 11,59,59, $arr_month_year[0], date('t', $first_date_unix ), $arr_month_year[1]  );

		$this->setPartyTimeDate($first_date_unix, $last_date_unix, true);
		$this->setPartyTimeIndex($first_date_unix, $last_date_unix);
		$this->setPartyTimeArchiveDateArray();
		
		$this->Set_Template( 'output', 'partytime/view.php' );	// Uses the previous variables


		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	public function image_xml(){
		$str_output = NULL;		
		$this->setPartyTimeDate();
		
		if( $this->Get_Data('partytime_unix_date') ) {
			$this->fetchPartyTimeAlbums();
			$this->fetchPartyTimePhotos();

			if( is_array( $this->Get_Data('arr_albums') ) ) {
				foreach( $this->Get_Data('arr_albums') as $album ) {
					$str_output .= '<album title="'. $this->cleanXMLText( $album['pt_pa_title'] ).'" description="'.$this->cleanXMLText($album['pt_pa_blurb']).'" tnpath="'.SERVER_URL.'/'.SITE.'/partytime/'. $this->Get_Data('partytime_directory') .'/" lgpath="'.SERVER_URL.'/'.SITE.'/partytime/'. $this->Get_Data('partytime_directory') .'/">' . "\n";
					$arr_albums = $this->Get_Data('arr_photos', $album['pt_pa_date']);
					$arr_album_photos = $arr_albums[ $album['pt_pa_party_name']];
					foreach( $arr_album_photos as $pic ){
						$str_output .= '<img src="'. strtolower( $pic['pt_im_img_name'] ).'" tn="th-'. strtolower( $pic['pt_im_img_name'] ).'" caption="'. $this->cleanXMLText( $pic['pt_im_cutline'] ).'" />' . "\n";
					}
					$str_output .= '</album>' . "\n";
				}
			}
		}
		
		//OuTPUT!
		if( $str_output ){
			$this->outputXMLHeader();
			print '<gallery>'."\n";
			print $str_output;
			print '</gallery>'."\n";
		} else {
			//$this->outputXMLHeader();
			print '<gallery><album title="No Output from XML Testing" lgpath="/site/images/icons/" ><img src="sorry_party_time.jpg" /></album></gallery>';
			//print "Sorry - No Photos available.";
		}

				
	}
	
	public function image_xml_test(){
		$str_output = NULL;		
		$this->setPartyTimeDate();
		
		if( $this->Get_Data('partytime_unix_date') ) {
			$this->fetchPartyTimeAlbums();
			$this->fetchPartyTimePhotos();

			print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
			print_r($this->Get_Data('arr_photos'));
			print "</pre>";
		}
	}
	
	public function urlDatePartyTime($unix_date){
		return date('n', $unix_date).'-'.date('j', $unix_date).'-'.date('Y', $unix_date);
	}
	
	
	private function setPartyTimeArchiveDateArray(){
		//partytime_archives_dates
		$arr_partytime_archives_dates = array();
		$sql = "SELECT distinct pt_pa_date from party_time_parties order by pt_pa_date asc";
		$res = $this->ExecuteArray($sql);
		
		if( $res ){
			foreach( $res as $d ){
				$arr_partytime_archives_dates[ date('Y', $d['pt_pa_date'] ) ][ date('n', $d['pt_pa_date'] ) ][] = date('j', $d['pt_pa_date'] );
			}
		}
		$this->data['partytime_archives_dates'] = $arr_partytime_archives_dates;
	}
	
	
	private function setPartyTimeDate($first_date_unix = NULL, $last_date_unix=NULL, $month_only = NULL){
		if( $first_date_unix && $last_date_unix && $month_only ){	// This will set the active date to the closest date after the first_date_unix
			$this->data['partytime_unix_date'] 	= $this->_getIssueDateClosestToDate( $first_date_unix );
			$this->data['partytime_url_date']	= date('n', $this->Get_Data('partytime_unix_date') ).'-'.date('j', $this->Get_Data('partytime_unix_date') ) .'-'. date('Y', $this->Get_Data('partytime_unix_date') );
			$this->data['partytime_directory'] 	= date('Y', $this->Get_Data('partytime_unix_date') ) . '/'. strtolower( date('F', $this->Get_Data('partytime_unix_date') ) ). '/'. date('j', $this->Get_Data('partytime_unix_date') );	

		
		}	else if( !$this->Get_URL_Element(VAR_1) ) { 
			$this->data['partytime_unix_date'] 	= $this->_getLatestPartyTimeDate();
			$this->data['partytime_url_date']	= date('n', $this->Get_Data('partytime_unix_date') ).'-'.date('j', $this->Get_Data('partytime_unix_date') ) .'-'. date('Y', $this->Get_Data('partytime_unix_date') );
			$this->data['partytime_directory'] 	= date('Y', $this->Get_Data('partytime_unix_date') ) . '/'. strtolower( date('F', $this->Get_Data('partytime_unix_date') ) ). '/'. date('j', $this->Get_Data('partytime_unix_date') );		
		
		} else {
			$arr_pt_date = explode("-", $this->Get_URL_Element(VAR_1) );
			if( array_key_exists(0, $arr_pt_date) && array_key_exists(1, $arr_pt_date) && array_key_exists(2, $arr_pt_date) ) {
				$this->data['partytime_unix_date'] = mktime(0,0,0,$arr_pt_date[0],$arr_pt_date[1],$arr_pt_date[2]);
				$this->data['partytime_url_date']	= date('n', $this->Get_Data('partytime_unix_date') ).'-'.date('j', $this->Get_Data('partytime_unix_date') ) .'-'. date('Y', $this->Get_Data('partytime_unix_date') );
				$this->data['partytime_directory'] = date('Y', $this->Get_Data('partytime_unix_date') ) . '/'. strtolower( date('F', $this->Get_Data('partytime_unix_date') ) ). '/'. date('j', $this->Get_Data('partytime_unix_date') );
	
			}
		}
	}
	
	/**
	 * This will retreive the photos and sort them in an array of album names => photos
	 * If a different unix date is sent, it will gather and pass back the results for that date.
	 * Otherwise, it's stored in the arr_photos data variable 
	 */
	private function fetchPartyTimePhotos( $different_unix_date = NULL ) {
		if( $this->Get_Data('partytime_unix_date') || $different_unix_date ){
			$sql = "SELECT * from party_time_images where pt_im_date=";
			$sql .= ($different_unix_date)?  $this->dbReady( $different_unix_date, true ) : $this->dbReady( $this->Get_Data('partytime_unix_date'), true );
			$sql .= " order by pt_im_party_name, pt_im_img_number";

			$res = $this->ExecuteArray($sql);
			$arr_ph = array();
			if( is_array( $res )){
				foreach( $res as $ph ){
					$arr_ph[ $ph['pt_im_date'] ][ $ph['pt_im_party_name'] ][] = $ph;
				}
			}
			
			if( $different_unix_date ){
				return $arr_ph;
			} else {
				$this->data['arr_photos'] = $arr_ph;
			}
		}
		
	}
	
	private function _getLatestPartyTimeDate(){
		$sql = "SELECT pt_pa_date from party_time_parties where pt_pa_date <= ".mktime()." order by pt_pa_date desc limit 0,1";
		$res = $this->ExecuteAssoc( $sql );
		if( $res ){
			return $res['pt_pa_date'];
		}
	}
	
	
	private function _getIssueDateClosestToDate( $first_date_unix ) {
		$sql = "SELECT pt_pa_date from party_time_parties where pt_pa_date >= $first_date_unix and  pt_pa_date <= ".mktime()." order by pt_pa_date asc limit 1";
		$res = $this->ExecuteAssoc($sql);
		if( is_array( $res) ){
			return $res['pt_pa_date'];
		}
	}
	
	private function setPartyTimeIndex( $date_unix_from=NULL, $date_unix_to=NULL ) {
		$arr_parties = array();	
		$this->data['Arr_Index_Photos'] = $this->fetchBatchofPartyTimePhotos(NULL, $date_unix_from, $date_unix_to );
	}
	
	/**
	 * Sends back the last bunch
	 *
	 * @param unknown_type $how_many_issues
	 * @param unknown_type $date_unix_from
	 * @param unknown_type $date_unix_to
	 * @return unknown
	 */
	private function fetchBatchofPartyTimePhotos( $how_many_issues = NULL, $date_unix_from=NULL, $date_unix_to=NULL ){
		$arr_photos = NULL;
		$arr_ph = NULL;

		if( $date_unix_from && $date_unix_to ){
			
			$this->data['Arr_Index_Issues'] = $this->fetchPartyTimeAlbums( $how_many_issues, $date_unix_from, $date_unix_to );
			if( is_array( $this->Get_Data('arr_issue_dates' ) ) ) {
				foreach( $this->Get_Data('arr_issue_dates' ) as $issue_date ) {
					$arr_photos = $this->fetchPartyTimePhotos( $issue_date['pt_pa_date'] );
	
					if( is_array( $arr_photos ) && array_key_exists($issue_date['pt_pa_date'], $arr_photos )  ) {
						foreach( $arr_photos[ $issue_date['pt_pa_date'] ] as $ph ) {
							foreach( $ph as $photo_item ) {
										$arr_ph[ $photo_item['pt_im_date'] ][ $photo_item['pt_im_party_name'] ][] = $photo_item;
							}
						}
					}
				}
			}
		} else {
			$this->data['Arr_Index_Issues'] = $this->fetchPartyTimeAlbums( 5 );
			foreach( $this->Get_Data('arr_issue_dates' ) as $issue_date ) {
				$arr_photos = $this->fetchPartyTimePhotos( $issue_date['pt_pa_date'] );

				if( is_array( $arr_photos ) ) {
					foreach( $arr_photos[ $issue_date['pt_pa_date'] ] as $ph ) {
						foreach( $ph as $photo_item ) {
									$arr_ph[ $photo_item['pt_im_date'] ][ $photo_item['pt_im_party_name'] ][] = $photo_item;
						}
					}
				}		
			}
		}

		return $arr_ph;
	}
	
	private function fetchPartyTimeAlbums( $how_many_issues = NULL, $date_unix_from=NULL, $date_unix_to=NULL) {
		// Just set the arr_albums
		if( $this->Get_Data('partytime_unix_date') && !$how_many_issues &&  !$date_unix_from && !$date_unix_to ){
			$sql = "SELECT * from party_time_parties where pt_pa_date=". $this->dbReady( $this->Get_Data('partytime_unix_date'), true );

			$res = $this->ExecuteArray($sql);
			if( is_array( $res )){
				$this->data['arr_albums'] = $res;
				
				
			}
		}
		
		// Get a bunch of issues and their albums!
		if( $how_many_issues && !$date_unix_from && !$date_unix_to ){
			$this->data['arr_issue_dates'] = $this->fetchPartytimeIssueDatesArray();

			if( is_array( $this->Get_data('arr_issue_dates' ) ) ){
				$sql = "SELECT * from party_time_parties where pt_pa_date in (";
				$x=1;
				foreach( $this->Get_data('arr_issue_dates' ) as $d ){
					$sql .= "'". $d['pt_pa_date']. "'";
					$sql .= ( $x < count( $this->Get_data('arr_issue_dates' ) ) ) ? ",": NULL;
					$x++;
				}
				$sql .= ') and pt_pa_date <= '.mktime().' order by pt_pa_date desc, pt_pa_order';
				$res = $this->ExecuteArray($sql);
				if( is_array( $res )){
					foreach( $res as $ph ){
						$arr_ph[ $ph['pt_pa_date'] ][] = $ph;
					}
				}
				return $arr_ph;
			}
		}

		
		// A range of dates have been called up
		if( $date_unix_from && $date_unix_to ){
			$this->data['arr_issue_dates'] = $this->fetchPartytimeIssueDatesArray(NULL,NULL, $date_unix_from, $date_unix_to);
	
			if( is_array( $this->Get_data('arr_issue_dates' ) ) ){
				$sql = "SELECT * from party_time_parties where pt_pa_date in (";
				$x=1;
				foreach( $this->Get_data('arr_issue_dates' ) as $d ){
					$sql .= "'". $d['pt_pa_date']. "'";
					$sql .= ( $x < count( $this->Get_data('arr_issue_dates' ) ) ) ? ",": NULL;
					$x++;
				}
				$sql .= ') and  pt_pa_date <= '.mktime(). ' order by pt_pa_date desc, pt_pa_order';
				$res = $this->ExecuteArray($sql);
				if( is_array( $res )){
					foreach( $res as $ph ){
						$arr_ph[ $ph['pt_pa_date'] ][] = $ph;
					}
				}
				return $arr_ph;
			}	
		}
		
		
	}
	
	private function fetchPartytimeIssueDatesArray( $number_of_issues = 5, $start_at_record = 0,$date_unix_from = NULL, $date_unix_to = NULL ){
		
		if( $date_unix_from && $date_unix_to){
			$sql = "SELECT distinct pt_pa_date from party_time_parties ";
			$sql .= " where pt_pa_date >=$date_unix_from and pt_pa_date <=$date_unix_to";
			$sql .= " and pt_pa_date <=". $this->_getLatestPartyTimeDate();
			$sql .= " order by pt_pa_date desc";
			$res = $this->ExecuteArray($sql);
			if( is_array( $res )){
				return $res;
			}	
		} else {
			$sql = "SELECT distinct pt_pa_date from party_time_parties ";
			$sql .= " where pt_pa_date <=". $this->_getLatestPartyTimeDate();
			$sql .= " order by pt_pa_date desc limit $start_at_record, $number_of_issues";
			$res = $this->ExecuteArray($sql);
			if( is_array( $res )){
				return $res;
			}
		}
	}
	
	
	private function cleanXMLText( $text ){
		$str = str_replace( "\r", '', $text );
		$str = str_replace( "\n", '', $str );
		$str = str_replace( 'Õ', "'", $str );
		$str = strip_tags( $str );
		$str = strtr( $str, $this->language_html_entities);
		// return $str; exit();
		return trim(  $this->convert_smart_quotes($str)  );
	}

	function convert_smart_quotes($string) 
	{ 
	    $search = array(chr(145), 
	                    chr(146), 
	                    chr(147), 
	                    chr(148), 
	                    chr(151)); 
	 
	    $replace = array("'", 
	                     "'", 
	                     '"', 
	                     '"', 
	                     '-'); 
	 
	    return str_replace($search, $replace, $string); 
	} 

	
	private function outputXMLHeader(){
		// header('Content-type: application/xml; charset=UTF-8',true); //iso-8859-1
		print '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	}
	
/**
 * 
 * 
 * 
 * 
 * <!-- ============================================================== -->

// <param name="FlashVars" value="xmlfile=http://mydomain.com/myXML.xml" />
<!--
        $Id: images.dtd 3 2006-10-07 17:43:36Z stefan $       
        DTD for SlideShowPro
        Author: Stefan Saasen <s@juretta.com>
        http://creativecommons.org/licenses/by/2.5/ applies
-->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!--                element/attribute declarations                  -->
<!-- ============================================================== -->
<!ELEMENT gallery (album+)>

<!ELEMENT album (img+)>
<!ATTLIST album  
        id              NMTOKENS            #IMPLIED
        title           CDATA               #REQUIRED
        description     CDATA               #REQUIRED
        lgPath          CDATA               #REQUIRED
        tnPath          CDATA               #IMPLIED
        tn              CDATA               #IMPLIED
        audio           CDATA               #IMPLIED
        audioCaption    CDATA               #IMPLIED
>


<!ELEMENT img (#PCDATA)>
<!ATTLIST img  
        src             CDATA               #REQUIRED
        tn              CDATA               #IMPLIED
        caption         CDATA               #IMPLIED
        link            CDATA               #IMPLIED
        target          CDATA               #IMPLIED
        pause           CDATA               #IMPLIED        
>

 * 
	 */
	

private function getFolderNumber( $number ){
	if( sizeof($number) == 1 ) {
		$number = '0'.$number;
	}
	
	return $number.'_';
}
	

}
?>