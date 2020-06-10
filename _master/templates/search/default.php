<script src="http://www.google.com/jsapi?key=ABQIAAAA0DEsSRsvgz4UNjpHhQdOZxQt9jg4dxCjb3n_p7Pi0XQ4WbPghBSUcanPfR0OSuO8iSTs4ELtGQuwUQ" type="text/javascript"></script>
<script language="Javascript" type="text/javascript" >
//<![CDATA[
google.load("search", "1");
function OnLoad() {
  var sterm = '<?=$this->Get_Data('search_string'); ?>';
  var query = window.location.search.substring(1);
  if(query) {
  	var vars = query.split("&");
    if(vars[0] && vars[0].match(/q=/)) {
		qvars = vars[0].split("=");
		sterm = qvars[1];
	}
  }
	
  var searchControl = new google.search.SearchControl();
  searchControl.setResultSetSize(GSearch.LARGE_RESULTSET);
  var ws = new google.search.WebSearch()
  var site = "<?=SEARCH_URL;?>";
  ws.setSiteRestriction(site);
  ws.setUserDefinedLabel("<?=SEARCHL_URL_BASIC; ?>");
  var options = new GsearcherOptions();
  options.setExpandMode(GSearchControl.EXPAND_MODE_OPEN);
  searchControl.addSearcher(ws, options);
  searchControl.draw(document.getElementById("searchcontrol"));
  if(! sterm || sterm != '') {
 	searchControl.execute(sterm);
  }
 
}
google.setOnLoadCallback(OnLoad);

//]]>
</script>

<div style="text-align: left; font-size: 9pt;">Basic Search | <a href="/search/advanced">Advanced Search</a></div>

<link href="http://www.google.com/uds/css/gsearch.css" type="text/css" rel="stylesheet"/>
<style type="text/css">
    .gsc-control { width : 590px; }
    .gs-webResult .gs-title				{ color: #440000; font-size: 13pt; }
    .gs-webResult .gs-visibleUrl-long 	{ display:none; }
    .gs-webResult .gs-visibleUrl-short 	{ display:none; }
</style>

<div id="searchcontrol" style="width: 590px;">Loading...</div>

