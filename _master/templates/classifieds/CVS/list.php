<h2>Columnists</h2>
<?
	/**
	 * COLUMNIST NAMES ----
	 */
	if( $this->get_data('columnist_list') ) {
		foreach( $this->get_data('columnist_list') as $columnist ) { ?>
			<div>
				<a style="font-family: verdana, arial; font-size: 80%;" href="/column/author/<?=$columnist['author_id']; ?>" ><?=$columnist['author_name']; ?></a>
			</div>		
<?		}		
	}
	/**
	 * COLUMN LIST ----
	 */
		if( $this->get_data('column_list') ) {
			?><br /><br /><h2>Columns</h2><?
		foreach( $this->get_data('column_list') as $column ) { 
			if( $column['section_id'] != COLUMNS ) { // Column '3' shouldn't be outputed...
			?>
			<div>
				<a style="font-family: verdana, arial; font-size: 80%;" href="/column/view/<?=$column['section_id']; ?>" ><?=$column['section_title']; ?></a>
			</div>		
<?			} 
		}
	}
?>