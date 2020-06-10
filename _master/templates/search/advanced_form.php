<?$arr_authors = $this->_getAllAuthors();?>

<table>
	<tr>
		<td><h2><input type="checkbox" name="include_search_string"  id="include_search_string" class="search_big_checkmark" <?=is_selected('checked', $this->Get('include_search_string'), 'on'); ?> /> Search</h2></td><td colspan=2><input onFocus="checkIt('include_search_string')" class="text"  type="text" name="search_string" value="<?=$this->Get('search_string');  ?>" /> </td>
	</tr>
	<tr>
		<td><h2><input type="checkbox" name="include_author"  id="include_author"  class="search_big_checkmark" <?=is_selected('checked', $this->Get('include_author'), 'on'); ?>/> Author</h2></td><td colspan=2><select name="author_id" onChange="checkIt('include_author');"><?=dropdown(NULL, $this->Get('author_id'), $arr_authors); ?></select></td>
	</tr>
	<tr> 
		<td><h2 style="vertical-align: middle;"><input type="checkbox" name="include_date_range" id="include_date_range"  class="search_big_checkmark"  <?=is_selected('checked', $this->Get('include_date_range'), 'on'); ?>/> Date Range</h2></td><td><div class="search_calendar_from_until">FROM</div><div id="calendar1Container"></div> </td><td><div class="search_calendar_from_until">UNTIL</div><div id="calendar2Container"></div></td>
	</tr>
</table>

<input type="hidden" name="startMonth" id="startMonth"  value="<?=$this->Get('startMonth'); ?>" />
<input type="hidden" name="startDay" id="startDay"  value="<?=$this->Get('startDay'); ?>" />
<input type="hidden" name="startYear" id="startYear"  value="<?=$this->Get('startYear'); ?>" />
<input type="hidden" name="endMonth" id="endMonth"  value="<?=$this->Get('endMonth'); ?>" />
<input type="hidden" name="endDay" id="endDay"  value="<?=$this->Get('endDay'); ?>" />
<input type="hidden" name="endYear" id="endYear"  value="<?=$this->Get('endYear'); ?>" />


<div style="border: 1px #4081CF solid; padding: 10px; margin: 20px 0px;">
	<table style="width: 100%;">
		<tr>
			<td>
			<select name="option_sort_by">
				<option value="story_issue_date desc" <?=is_selected('selected', $this->Get('option_sort_by'), 'story_issue_date desc'); ?>>Sort By Date - Most recent</option>
				<option value="story_issue_date asc" <?=is_selected('selected', $this->Get('option_sort_by'), 'story_issue_date asc'); ?>>Sort By Date - Earliest</option>
				<option value="story_score desc" <?=is_selected('selected', $this->Get('option_sort_by'), 'story_score desc'); ?>>Sort By Most Relevent First</option>
			</select>
			
			<select name="option_results_per_page">
				<option value="10" <?=is_selected('selected', $this->Get('option_results_per_page'), '10'); ?>>Show 10 results per page</option>	
				<option value="20" <?=is_selected('selected', $this->Get('option_results_per_page'), '20'); ?>>Show 20 results per page</option>
				<option value="50" <?=is_selected('selected', $this->Get('option_results_per_page'), '50'); ?>>Show 50 results per page</option>	
			</select>
			<input type="hidden" name="option_results_start_at_record" value="0" />
			
			
			</td>
			<td style="text-align: right;"><input type="submit" name="submit_advanced_search" value="Search <?=NEWSPAPER_NAME; ?>" class="button_good"></td>
		</tr>
	</table>
</div>

</form>

<script> 
	function handleSelectStart(type,args,obj){
	
		var dates = args[0]; 
		 var date = dates[0]; 
		 var year = date[0], month = date[1], day = date[2]; 
		
		var selMonth = document.getElementById("startMonth"); 
		var selDay = document.getElementById("startDay"); 
		var selYear = document.getElementById("startYear"); 
		
		selMonth.value = month; 
		selDay.value = day; 
		selYear.value = year;
	
		
		checkIt('include_date_range'); /* Checks the checkbox */
	}
	
	function handleSelectEnd(type,args,obj){
	
		var dates = args[0]; 
		 var date = dates[0]; 
		 var year = date[0], month = date[1], day = date[2]; 
		
		var selMonth = document.getElementById("endMonth"); 
		var selDay = document.getElementById("endDay"); 
		var selYear = document.getElementById("endYear"); 
		
		selMonth.value = month; 
		selDay.value = day; 
		selYear.value = year;
	
		checkIt('include_date_range'); /* Checks the checkbox */
	}

YAHOO.namespace("start.calendar"); 
YAHOO.start.calendar.init = function() {
	var navConfig = {
	      strings : { 
		    	month: "Choose Month", 
		         year: "Enter Year", 
	          	submit: "OK", 
	         	cancel: "Cancel", 
	          invalidYear: "Please enter a valid year" 
	     }, 
	   monthFormat: YAHOO.widget.Calendar.SHORT, 
		      initialFocus: "year" 
	}; 

	YAHOO.start.calendar.cal1 = new YAHOO.widget.Calendar("cal1","calendar1Container", {navigator: navConfig, pagedate: "<?=date('m', strtotime("Last Month") ); ?>/<?=date('Y', strtotime("Last Month") ); ?>" } ); 
	YAHOO.start.calendar.cal2 = new YAHOO.widget.Calendar("cal2","calendar2Container", {navigator: navConfig} ); 
	
	<?
	// Incoming start date for the calendar
		if( $this->Get('startMonth') && $this->Get('startDay') && $this->Get('startYear') ) { ?>
			var startdate = '<?=$this->Get('startMonth'); ?>/<?=$this->Get('startDay'); ?>/<?=$this->Get('startYear'); ?>';
			YAHOO.start.calendar.cal1.select(startdate); 
			YAHOO.start.calendar.cal1.cfg.setProperty("pagedate", '<?=$this->Get('startMonth'); ?>/<?=$this->Get('startYear'); ?>');
			
	<?	}	?>

	<?
	// Incoming End date for the calendar
		if( $this->Get('endMonth') && $this->Get('endDay') && $this->Get('endYear') ) { ?>
			var enddate = '<?=$this->Get('endMonth'); ?>/<?=$this->Get('endDay'); ?>/<?=$this->Get('endYear'); ?>';
			YAHOO.start.calendar.cal2.select(enddate); 
			YAHOO.start.calendar.cal2.cfg.setProperty("pagedate", '<?=$this->Get('endMonth'); ?>/<?=$this->Get('endYear'); ?>');
			
	<?	}	?>
	
	YAHOO.start.calendar.cal1.selectEvent.subscribe(handleSelectStart, YAHOO.start.calendar.cal1, true);
	YAHOO.start.calendar.cal2.selectEvent.subscribe(handleSelectEnd, YAHOO.start.calendar.cal2, true);

	YAHOO.start.calendar.cal1.render(); 
	YAHOO.start.calendar.cal2.render(); 
 } 	 
 YAHOO.util.Event.onDOMReady(YAHOO.start.calendar.init); 
</script> 

