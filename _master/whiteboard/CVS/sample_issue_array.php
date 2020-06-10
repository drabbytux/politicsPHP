<?php
/**
 * ArtistArea Class
 * 
 * Takes care of the artist area authentication
 * and other things in the future
 * 
*/
require_once('classes/database.class.php');

class ArtistArea extends Database 
{
	
	public function ArtistArea(){
		$this->Database();		
	}
	
	public function login($login_name = NULL, $password = NULL){
		// Look up the member
		$sql = "SELECT * from artist_area_member where name='$login_name' and login_password='$password'";
		$res = $this->Execute( $sql );
		if( $res && mysql_num_rows( $res ) !=0 ){
			// Good to go!
			return true;
		}
	}
	
	
	

} // END CLASS

?>