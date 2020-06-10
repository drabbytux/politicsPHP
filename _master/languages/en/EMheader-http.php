<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title><?=$this->Get_Data('page_title');?></title>
<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
<meta name="title" content="<?=$this->Get_Data('page_title');?>">
<meta name="description" content="<?=$this->Get_Data('meta_description');?> Canada's Foreign Policy Newsweekly">
<meta name="keywords" content="<?=$this->Get_Data('meta_keywords');?>,Embassy, Ambassador, Diplomat, Diplomatic, Ottawa, Diplomatic Community, News">
<meta name="language" content="english">

<meta name="author" content="<?=NEWSPAPER_NAME;?> - <?=$this->Get_Data('meta_authors');?>">
<meta name="copyright" content="The Hill Times Publishing">
<meta name="revisit-after" content="7 days">
<meta name="reply-to" content="onlineservices@<?=DOMAIN;?>">
<meta name="document-class" content="Published">
<meta name="document-classification" content="News">
<meta name="document-rating" content="Safe for Kids">
<meta name="document-distribution" content="Global">
<meta name="document-state" content="Dynamic">
<meta name="cache-control" content="Public">
<script language="javascript" type="text/javascript" src="/site/javascript/main.js"></script>
<!-- <script language="javascript" type="text/javascript" src="/site/javascript/rss_scroller.js"></script> -->
<? include(FILE_SPRY); ?>
<link rel="stylesheet" href="/site/styles/main.css" type="text/css">
<link rel="stylesheet" href="/site/styles/<?=SITE?>.css" type="text/css">
<script type="text/javascript"><!--//--><![CDATA[//><!--
startList = function() {
	if (document.all&&document.getElementById) {
		navRoot = document.getElementById("themainlist");
		for (i=0; i<navRoot.childNodes.length; i++) {
			node = navRoot.childNodes[i];
			if (node.nodeName=="LI") {
				tnode.onmouseover=function() {
					this.className+=" over";
				}
				node.onmouseout=function() {
					this.className=this.className.replace(" over", "");
				}
			}
		}
	}
}
window.onload=startList;

//--><!]]></script>
<script type="text/javascript">
	function isIE(){
	 // alert(navigator.appName);
		if( navigator.appName == "Microsoft Internet Explorer" ){
			return true;
		}
		return false;
	}

	function processSubMenu(newDivID){
	 return true;
		curdiv 				= document.getElementById('currentOpenSubMenuDiv');			// Currently active div name
		calleddiv 			= document.getElementById(newDivID);						//  The called div obj
		calleddivState 		= document.getElementById(newDivID+'State');				// The Div state that you're calling
		previousdivState 	= document.getElementById( curdiv.value +'State' );			// The Previous (current) div state
	
		
 // alert("Currently Open: " + curdiv.value + "\n" + "Called: " + calleddivState.value + "\n" );


		if( curdiv.value == "0" ){ // First time through - Never before seen!
			if( isIE() ) {
				calleddiv.style.display = 'block'; 				// **IE FIX: set the div to visable
			}
			eval('js'+newDivID+".start()");					// Opens the New menu
			
			curdiv.value = newDivID;						// Set the current ID
			calleddivState.value="1";						// Set the current DIV State to ON!	
			
		} else {	
			
			objCurDiv = document.getElementById( curdiv.value );	// NEW obj
			if( curdiv.value == newDivID ) {				// The button has been clicked twice in a row
				eval('js'+newDivID+".start()");				// Closes the Same Menu							
				if( isIE() ) {
					objCurDiv.style.display= "none";				// IE FIX: set current div to invisible
				}
				curdiv.value = "0";							// Set the currentID TO NOTHING
				calleddivState.value="0";					// Set the current DIV State to ON!
				
			} else {
				
				eval( "js" + curdiv.value + ".start()" );	// Closes the previous div
				if( isIE() ) {
					objCurDiv.style.display= 'none';			// **IE FIX: set current div to invisible
					calleddiv.style.display = 'block'; 			// **IE FIX: set the called div to visible
				} 
				eval('js'+newDivID+".start()");				// Opens the New menu

				curdiv.value = newDivID;					// Set the currentID
				calleddivState.value="1";					// Set the current DIV State to ON!	
				
			}
							
		}
	
		
	}
</script>
</head>
<body id="body" onLoad="<?=$this->Get_Data('javascript_body_items'); ?>" >
<div id="mainnav">
	<div class="content">
		<table style="width: 100%;">
			<tr>
				<td style="color: #fff; width: 30%; text-align: left; vertical-align: middle; font-family: verdana, arial; font-size: 9pt;">
					<?=$this->Get_Data('member_edit_link');?>
				</td>
				<td style="width: 70%; text-align: right; vertical-align: middle; color: #fff;">
					<span class="topnavitem"><a target="_blank" style="color: #FBC381" href="http://www.hilltimes.com">The Hill Times</a></span>
					<span class="topnavitem"><a target="_blank" style="color: #FBC381" href="http://www.dailypublinet.ca">Publinet</a></span>
					&nbsp; | &nbsp; 
					<span class="topnavitem"><a href="<?=SERVER_URL?>/member/subscribe">Subscriptions</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/advertise">Advertising</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/rss/overview">RSS</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/mobile">Mobile</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/about">About</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/contact">Contact</a></span>
					
					<?=$this->Get_Data('member_link');?>		
				</td>
			</tr>
		</table>
	</div>
</div>
	
<div id="masterarea">
<? include( FILE_SCRIPTACULOUS_INIT ); ?>


 
	<table id="top_ad_table">
		<tr>
			<td style="width:728px; ">
			
									<? include( DIRECTORY_TEMPLATES . '/bannercode/leaderboard.php'); // RIGHT COLUMN tall banner ?>

</td>
			
			<td style="12px; text-align: center"></td>
			<td style="width:232px; text-align: left;">
		
				<a class="linklist" href="/classifieds/">Classifieds</a>
				<!--
				<a class="linklist" href="/classifieds/">Autos</a>
				<a class="linklist" href="/classifieds/">Careers</a>
				// -->
				<a class="linklist" href="/classifieds/vacation">Vacations</a>
				
			</td>
			
		</tr>
	</table>
	
 
 	<table id="top_ad_table">
		<tr>
		<td style="width:500px; text-align: left;">	
				<div style="text-align: left; vertical-align: middle; margin: 0px auto; width: 500px;padding-bottom: 10px; ">
					<a href="<?=SERVER_URL?>/" title="Embassy">
					<img alt="<?=DEFAULT_TITLE ?>" src="/site/images/logos/embassy_logo_2.gif"  />
					</a><!-- <br /><span style="color: #000; font-size: 12pt; letter-spacing: 0.07em;">Canada's Foreign Policy Newsweekly</span> -->
				</div>
			</td>
			<td style="width:400px; text-align: right; vertical-align: bottom;padding-bottom: 10px;">
				<a href="<?=SERVER_URL?>/issue/archive" style="color: #444;font-size: 9pt;font-family: verdana, arial;"><img style="vertical-align: middle;" src="/site/images/icons/book.gif" /> Archives</a>
				 &nbsp; &nbsp;
				 <form action="/search/results" id="topsearch" method="post">
					<input type="text" style="vertical-align: middle; border: 1px #999 solid;height: 20px;font-size: 9pt;" id="search_string_header" value="<?=$this->Get_Data('search_string');?>" name="search_string_header" />&nbsp;<input type="submit" value="Search" name="submit_search_top" style="vertical-align: middle; font-size: 10pt; border: 1px #666 solid; color: #666;" />
				</form>
			</td>
		</tr>
	</table>
	
	
				
	<div id="categorynav">
		<div class="content">
			<ul id="MenuBar1">
				<li><a href="/">Front Page</a></li>
				<li style="width: 100px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='immigration' )? 'class="selected"':NULL; ?> href="/section/immigration">Immigration</a></li>
				<li style="width: 65px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='trade' )? 'class="selected"':NULL; ?> href="/section/trade">Trade</a></li>	
				<li style="width: 75px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='opinion' )? 'class="selected"':NULL; ?> href="/section/opinion">Opinion</a></li>
				<li style="width: 80px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='defence' )? 'class="selected"':NULL; ?> href="/section/defence">Defence</a></li>
				<li style="width: 100px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='development' )? 'class="selected"':NULL; ?> href="/section/development">Development</a></li>
				<li style="width: 90px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='diplomacy' )? 'class="selected"':NULL; ?> href="/section/diplomacy">Diplomacy</a></li>
				<li><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='partytime' )? 'class="selected"':NULL; ?> href="/partytime">Party Time</a></li>
				<li><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='columns' )? 'class="selected"':NULL; ?> href="/section/columns">Columns</a></li>
				<li style="width: 140px;"><a <?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='diplomaticcontacts' )? 'class="selected"':NULL; ?> href="/section/diplomaticcontacts">Diplomatic Contacts</a></li>
			</ul>
		</div>
	</div>
	
	
	<!--  
	<div id="column">
		
		<a onclick="processSubMenu('newsdiv');" href="/section/news"><img src="/site/images/icons/arrow_button.gif" />Chatter House</a>
		<a onclick="processSubMenu('featuresdiv'); " href="/section/features"><img src="/site/images/icons/arrow_button.gif" />Diplomatic Circles</a>
		<a onclick="processSubMenu('lettersdiv');" href="/section/letters"><img src="/site/images/icons/arrow_button.gif" />Inside Defence</a>
		<a onclick="processSubMenu('opinionsdiv'); " href="/section/opinions"><img src="/site/images/icons/arrow_button.gif" />Lunch with Brian</a>

	</div>
	//  -->
	
	
	<div id="enclosedarea">

		<table style="width: 100%;">
			<tr>
				<td><?=$this->Get_Data('issue_date');?>

