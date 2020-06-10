<? include( FILE_FCKEDITOR ); ?>
<? include( FILE_YAHOO_CALENDAR ); ?>
<form id="storyform" action="/page/save/<?=$this->Get_URL_Element( VAR_1 );?>" method="POST">
<h4>Story Date</h4>
<small>
<input id="visable_date" value="<?=$this->Get_Data('story_date');?>" style="border: 0px; display: inline; font-size: 11pt; color: #117;" /> &nbsp; <button type="button" id="showCalendar" class="button_good" style="vertical-align: middle;"><img src="/site/images/icons/calendar.gif" /></button> 

<input name="date" style="width: 200px; border: 0px;" type="hidden">
</small>
<br />
<div id="calendarContainer"></div>

<h4>Title</h4>
<h1><input name="story_title" style="width: 700px; "  type="text" value="<?=$this->Get_Data('story_title');?>" /></h1>

<h4>Author</h4>
 <input name="story_author" style="width: 200px; "  type="text" value="<?=$this->Get_Data('story_author');?>" /> <a href="" class="small_function_link">add another</a>
 <br /><input name="story_author" style="width: 200px; "  type="text" value="<?=$this->Get_Data('story_author');?>" /> <a href="" class="small_function_link">remove</a>

<h4>Story Body</h4>
<?
	$oFCKeditor 				= new FCKeditor('story_content');
	//$oFCKeditor->BasePath		= '';
	$oFCKeditor->ToolbarSet 	= 'Hilltimes';
	$oFCKeditor->Value			= $this->data['story_content'];
	$oFCKeditor->Height 		= '450';
	$oFCKeditor->Width 			= '820';
	$oFCKeditor->Create();
?>


</form>

<script type="text/javascript">
	YAHOO.namespace("example.calendar");
	YAHOO.example.calendar.init = function() {
	
		function handleSelect(type,args,obj) {
			var dates = args[0]; 
			var date = dates[0];
			var year = date[0], month = date[1], day = date[2];
			
			var txtDate1 = document.getElementById("visable_date");	
			displayMonthNames = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
			txtDate1.value = displayMonthNames[month-1] + " " + day + ", " + year;
		}
		
	
	
		function updateCal() {
			var txtDate1 = document.getElementById("visable_date");
	
			if (txtDate1.value != "") {
				YAHOO.example.calendar.cal1.select(txtDate1.value);
				var selectedDates = YAHOO.example.calendar.cal1.getSelectedDates();
				if (selectedDates.length > 0) {
					var firstDate = selectedDates[0];
					YAHOO.example.calendar.cal1.cfg.setProperty("pagedate", (firstDate.getMonth()+1) + "/" + firstDate.getFullYear());
					YAHOO.example.calendar.cal1.render();
				} else {
					alert("Cannot select a date before 1/1/2006 or after 12/31/2008");
				}
				
			}
			
			
		}
	
		function handleSubmit(e) {
			updateCal();
			YAHOO.util.Event.preventDefault(e);
		}
	
		// David Little - Place in PHP dates here
		YAHOO.example.calendar.cal1 = new YAHOO.widget.Calendar("cal1","calendarContainer", { title:"Choose a date:", close:true, pagedate:"<?=date('m', $this->Get_Data('story_unix_date'));?>/<?=date('Y', $this->Get_Data('story_unix_date'));?>", selected:"<?=date('m', $this->Get_Data('story_unix_date'));?>/<?=date('d', $this->Get_Data('story_unix_date'));?>/<?=date('Y', $this->Get_Data('story_unix_date'));?>" } );
		YAHOO.example.calendar.cal1.render();

		// Listener to show the single page Calendar when the button is clicked
		
		YAHOO.example.calendar.cal1.selectEvent.subscribe(handleSelect, YAHOO.example.calendar.cal1, true);
		YAHOO.util.Event.addListener("showCalendar", "click", YAHOO.example.calendar.cal1.show, YAHOO.example.calendar.cal1, true);
		YAHOO.util.Event.addListener("visable_date", "click", YAHOO.example.calendar.cal1.show, YAHOO.example.calendar.cal1, true);
		YAHOO.util.Event.addListener("update", "click", updateCal);
	}
		
		
	YAHOO.util.Event.onDOMReady(YAHOO.example.calendar.init);
</script>

<div style="clear:both" ></div>
