<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title><?=$this->Get_Data('page_title');?></title>
<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
<meta name="title" content="<?=$this->Get_Data('page_title');?>">
<meta name="description" content="<?=$this->Get_Data('meta_description');?> Canada's Politics and Government Newsweekly">
<meta name="keywords" content="<?=$this->Get_Data('meta_keywords');?>,Canadian politics, Political news, Government of Canada news, Canadian government, Federal, Government, Politics, News, Newspaper, Canada">
<meta name="language" content="english">

<meta name="author" content="<?=NEWSPAPER_NAME;?> - <?=$this->Get_Data('meta_authors');?>">
<meta name="copyright" content="The Hill Times Publishing">
<meta name="revisit-after" content="7 days">
<meta name="reply-to" content="webmaster@<?=DOMAIN;?>">
<meta name="document-class" content="Published">
<meta name="document-classification" content="News">
<meta name="document-rating" content="Safe for Kids">
<meta name="document-distribution" content="Global">
<meta name="document-state" content="Dynamic">
<meta name="cache-control" content="Public">
<script language="javascript" type="text/javascript" src="/site/javascript/main.js"></script>
<link rel="stylesheet" href="/site/styles/<?=SITE?>.css" type="text/css">
<? include(FILE_SPRY); ?>
<link rel="stylesheet" href="/site/styles/main.css" type="text/css">
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
					<span class="topnavitem"><a href="<?=SERVER_URL?>/member/subscribe">Subscriptions</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/advertise">Advertising</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/rss/overview">RSS</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/mobile">Mobile</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/about">About</a></span>
					<span class="topnavitem"><a href="<?=SERVER_URL?>/information/view/contact">Contact</a></span>
					<?=$this->Get_Data('member_link');?>
					&nbsp; | &nbsp; 
					<span class="topnavitem"><a target="_blank" style="color: #FBC381" href="http://www.embassymag.ca">Embassy</a></span>
					<span class="topnavitem"><a target="_blank" style="color: #FBC381" href="http://www.dailypublinet.ca">Publinet</a></span>
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
				<? // Leaderboard ?>
				<? include( DIRECTORY_TEMPLATES . '/bannercode/leaderboard.php'); ?>
			</td>
			<td style="12px; text-align: center"></td>
			<td style="width:232px; text-align: left;">
		
				<a class="linklist" href="/classifieds/">Classifieds</a>
				<a class="linklist" href="/classifieds/vacation">Vacations</a> 
				<a class="linklist" href="/classifieds/careers">Careers</a>
			</td>
			
		</tr>
	</table>
	
 
 	<table id="top_ad_table">
		<tr>
		<td style="width:500px; text-align: left;">	
				<div style="text-align: left; vertical-align: middle; margin: 0px auto; width: 500px;padding-bottom: 10px; ">
					<a href="<?=SERVER_URL?>/" title="The Hill Times">
					<img alt="The Hill Times - Canada's Politics and Government Newsweekly" src="/site/images/logos/HT_LOGO_rev.jpg"  />
					</a><!--  <br /><span style="color: #000; font-size: 12pt; letter-spacing: 0.07em;">Canada's Politics and Government Newsweekly</span> -->
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
	
	
				
	<div id="categorynav_master">
		<div id="categorynav">
			<ul id="MenuBar1">
				<li style="width: 100px; border-left: 0px;"><a style="border-left: 0px; color: #000;" href="/">Front Page</a></li>
				<li style="width: 130px;"><a href="/section/pb" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='pb' )? 'colour_green_on':'colour_green'; ?>">Policy Briefings</a></li>
				<li style="width: 90px;"><a href="/section/features" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='features' )? 'colour_babyblue_on':'colour_babyblue'; ?>">Features</a></li>	
				<li><a href="/section/opinions" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='ideas' )? 'colour_purple_on':'colour_purple'; ?>">Ideas</a></li>
				<li><a href="/section/life" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='life' )? 'colour_red_on':'colour_red'; ?>">Life</a></li>
				<li><a href="/section/qa" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='qa' )? 'colour_yellow_on':'colour_yellow'; ?>">Q&A</a></li>
				<li style="width: 230px;"><a href="/section/lists_and_surveys" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='lists_and_surveys' )? 'colour_blue_on':'colour_blue'; ?>">Exclusive Lists and Surveys</a></li>
				<li><a href="/section/columns" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='columns' )? 'colour_gray1_on':'colour_gray1'; ?>">Columns</a></li>
				<li><a href="/section/blogs" class="<?=( $this->Get_URL_Element( REQUEST_CONTROLLER )=='section' && $this->Get_URL_Element( REQUEST_ACTION )=='blogs' )? 'colour_orange_on':'colour_orange'; ?>">Blogs</a></li>
			</ul>
		</div>
	</div>
	<br />
	<div id="columns_master">
		<div id="columns">
			<ul><li style="width: 120px;"><a href="" class="first_button"><img src="/site/images/icons/columns_arrow.gif" /></a></li>
				<li><a href="/column/all/legislation">Legislation</a></li>
				<li><a href="/column/all/lobbying">Lobbying</a></li>
				<li><a href="/column/all/politics">Politics</a></li>
				<li style="width: 120px;"><a href="/column/all/hillclimbers">Hill Climbers</a></li>
				<li style="width: 100px;"><a href="/column/all/civilcircles">Civil Circles</a></li>
				<li style="width: 120px;"><a href="/column/all/heardonthehill">Heard on the Hill</a></li>
				<li style="width: 120px;"><a href="/column/all/partycentral">Party Central</a></li>
			</ul>
		</div>
	</div>
	<br />
	
	<div id="enclosedarea">
		<table style="width: 100%;">
			<tr>
				<td><?=$this->Get_Data('issue_date');?>

