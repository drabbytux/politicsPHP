
</div>
<? if( $this->Get_Data('page_type') == 'issue') {
		include('templates/common/EMbottom_block_headlines.php');
	}
?>



<?=$this->Get_Data('footer_links'); ?>

	</div><? // End Enclosed Area ?>
	<div style="text-align: right; margin-top: 10px; padding: 8px;">
		
	</div>

</div><? //End Master Area ?>
<? // Get the common javascript stuff at the bottom ?>
<? include( $_SERVER['DOCUMENT_ROOT'].'/site/javascript/common_js.php');?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1271965-2";
urchinTracker();
</script>	
	</body>
</html>
