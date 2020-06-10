<?php
/**
 * Database Class
 * Created by David Little
 * June 28, 2006
 */

class Database
{
	var $results;
	var $linkID;
	
	// Constructor - Takes in linkID as a parameter
	function Database()
	{
		//Open a new connection if one is not already present
		if ( $this->linkID == NULL )
		{
			//Make a new Database connection
			$this->linkID = mysql_connect( DB_HOST, DB_USERNAME, DB_PASSWORD ) OR die
				("Error connecting to the database: " . mysql_error());
				
			//Select the database
			mysql_select_db(DB_NAME, $this->linkID) or die
				("Error connecting to the database: " . mysql_error());
		}
		
	}
	
	// GetLinkID: returns the link ID of the database connection
	function GetLinkID()
	{
		return ($this->linkID);
	}
	
	function GetResult($res = NULL)
	{
		return mysql_fetch_array($res, MYSQL_ASSOC);
	}
	
	function Execute($sql)
	{
		$result = mysql_query($sql, $this->linkID) or die
			("\nError quering Database: " . mysql_error() . "\n<br />Query string: " . $sql);
		return $result;
	}
	
	
	function ExecuteArray( $sql, $id_to_use_as_key = NULL )
	{

		if( !isset( $sql ) || strlen( $sql ) == 0 )
		{
			return false;
		}	

		$rs = $this->Execute( $sql );		
		
		if( mysql_errno() )
		{
			return NULL;
		}
		
		if( $rs )
		{
    			$ret_arr = array();
	    		while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
	    		{
	    			if( $id_to_use_as_key && array_key_exists($id_to_use_as_key, $row) ){
	    				$ret_arr[ $row[$id_to_use_as_key] ] = $row;
	    			} else {
	    				array_push( $ret_arr, $row );
	    			}				
	    		}
				
			if( sizeof( $ret_arr ) == 0 )
			{
				return NULL;
			}	
								
	    		return $ret_arr;
		}
		
		return NULL;
	}
	
	function ExecuteAssoc( $sql )
	{
	
		if( !isset( $sql ) || strlen( $sql ) == 0 )
		{
			return false;
		}	

		$rs = $this->Execute( $sql );		
		
		if( mysql_errno() )
		{
			return NULL;
		}
		
		if( $rs )
		{
	    	return mysql_fetch_assoc($rs);
		}
		
		return NULL;
	}

	function dbReady( $str, $the_last_one_remove_comma = false ){
		return ($the_last_one_remove_comma)? "'" . addSlashes( $str ) . "'" : "'" . addSlashes( $str ) . "',";
	}
	
	function addSingleQuoteSlashes( $str ){
		return str_replace("'", "\'", $str);
	}
	
    // Close: closes the database connection
    function Close()
    {
            mysql_close($this->linkID);
    }
	
	
}
?>