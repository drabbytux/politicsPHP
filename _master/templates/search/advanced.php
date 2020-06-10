<?include('site/system/yahoo_calendar_init.php'); ?>
<script type="text/javascript">
<!--
	function checkIt(obj_id){
		document.getElementById(obj_id). checked=true;
	}
//-->
</script>
<div style="text-align: left; font-size: 9pt;"><a href="/search/">Basic Search</a> | Advanced Search</div>

<h1>Advanced Search</h1>

<form action="/search/advanced_results/" method="post">
<? include('templates/search/advanced_form.php');  ?>
</form>