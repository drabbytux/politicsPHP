</div>
<? if( $this->Get_Data('page_type') == 'issue') {
		include('templates/common/bottom_block_headlines.php');
	}
?>

<?=$this->Get_Data('footer_links'); ?>

	</div><? // End Enclosed Area ?>
	<div style="text-align: right; margin-top: 10px; padding: 8px;">
		
	</div>

</div><? //End Master Area ?>
<? // Get the common javascript stuff at the bottom ?>
<? include( $_SERVER['DOCUMENT_ROOT'].'/site/javascript/common_js.php');?>
					
	</body>
</html>
