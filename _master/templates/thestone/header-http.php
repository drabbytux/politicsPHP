<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title><?=$this->Get_Data('title');?></title>
<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
<meta name="title" content="<?=$this->Get_Data('title');?>">
<meta name="description" content="Canada's Politics and Government Newsweekly">
<meta name="keywords" content="Canadian politics, Political news, Government of Canada news, Canadian government, Federal, Government, Politics, News, Newspaper, Canada">
<meta name="language" content="english">

<meta name="author" content="The Hill Times">
<meta name="copyright" content="The Hill Times">
<meta name="revisit-after" content="7 days">
<meta name="reply-to" content="webmaster@hilltimes.com">
<meta name="document-class" content="Published">
<meta name="document-classification" content="News">
<meta name="document-rating" content="Safe for Kids">
<meta name="document-distribution" content="Global">
<meta name="document-state" content="Dynamic">
<meta name="cache-control" content="Public">
<script language="javascript" type="text/javascript" src="/site/javascript/main.js"></script>
<? include(FILE_SPRY); ?>
<script src="/site/system/spry/widgets/menubar/SpryMenuBar.js" type="text/javascript"></script>
<link rel="stylesheet" href="/site/styles/main.css" type="text/css">
<link rel="stylesheet" href="/site/styles/thestone.css" type="text/css">
<link href="/site/system/spry/css/samples.css" rel="stylesheet" type="text/css" />
<link href="/site/styles/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

</head>
<body>


<div id="masterarea">
	<div id="logoarea">
	<div style="text-align: right;"><a title="WARNING!!! DELETES EVERYTHING AND REPLENISHES!" href="/_master/import_local_folders_into_sql.php" title="WARNING!!! DELETES EVERYTHING AND REPLENISHES!" >!Complete Import Script!</a><br /><a href="/_master/import_partytime_photos.php">!IMport All PartyTime Photos!</a></div>
		<a href="/thestone"><img src="/site/images/logos/thestone.gif" /></a><br />
		
		
	</div>
	<div id="topmenu">
		<ul  id="menu1"  class="simpleMenuBarHorizontal">
			<li><a href="/thestone/pages">Issues and Pages</a></li>
			<li><a href="/thestone/media">Media</a></li>
			<li><a href="/thestone/users">Users</a>

			<li><a href="/thestone/settings">Settings</a></li>
			<li><a href="/thestone/databasesettings">Database</a></li>
		<ul>
	</div>
	


	
	
	
	<div id="maincontent">
<? if( $this->Get_Data('page_type') == 'home' ) { ?>

		<fieldset style="border: 1px #819FCF solid; background-color: #fff; padding: 20px; width: 860px;margin-top: 10px;">
		<legend style="font-weight: bold;">Step off points</legend>

		<a href="/thestone/loadentireissue" title="Load your text file will some or all of your stories..."><img src="/site/images/icons/folder_down.jpg"> Load an entire issue</a> &nbsp; &nbsp; 
		<a href="/thestone/mysqladmin" title="Load new Classifieds"><img src="/site/images/icons/hall.jpg"> Load Classifieds</a> &nbsp; &nbsp; 
		<a href="/thestone/mysqladmin" title="Administrate the ad server banners and settings"><img src="/site/images/icons/settings.jpg"> Ad/Promotion Server</a> &nbsp; &nbsp; 
		<a href="/thestone/mysqladmin" title="Administrate the raw data in the database"><img src="/site/images/icons/mysql_hd.jpg"> PHPMyAdmin</a> &nbsp; &nbsp; 
		</fieldset>
<? } ?>