<div class="gradient_background">

<h2>PartyTime - Creating a New Party</h2>

<?
print $this->Get_Data('messages');
print $this->Get_Data('errors');
?>

	<form action="/thestone/processPartyTimePhotos" method="post">
	<input type=hidden name="party_time_date" value="<?=$this->get_Data('party_date'); ?>" />
	
		<table style="width: 100%;">
		
		<?if( $this->get_data('party_time_photos') ){
		
			foreach( $this->get_data('party_time_photos') as $pt_photo_key=>$pt_photo ) { ?>
			
			<tr>
				<td style="width: 50%;">
							<img src="<?=$this->get_data('party_time_url_folder') .'/'. $pt_photo; ?>" style="width: 400px;" />
				</td>
				<td style="width: 50%;">
				
						<table>
							<tr>
								<td>Details</td>
								<td><?=$pt_photo; ?><input type=hidden name="<?=$pt_photo_key; ?>_photo" value="<?=$pt_photo; ?>" /></td>
							</tr>
							<tr>
								<td>Party Name (lowercase, no spaces)</td>
								<td><input type="text" class="text" name="<?=$pt_photo_key; ?>_party" value="<?=$this->get($pt_photo_key . '_party'); ?>" />
							</tr>
							<tr>
								<td>Caption</td>
								<td><textarea class="text" name="<?=$pt_photo_key; ?>_caption" ><?=$this->get($pt_photo_key . '_caption'); ?></textarea>
							</tr>
							<tr>
								<td>By Line</td>
								<td><input type="text" class="text" name="<?=$pt_photo_key; ?>_byline" value="<?=$this->get($pt_photo_key . '_byline'); ?>" />
							</tr>
							<tr>
								<td>Order within Party</td>
								<td><select name="<?=$pt_photo_key; ?>_order" >
									<?=dropdown('NUMBERS', 1, array(1,18) ); ?>
								</select>
								</td>
							</tr>
						</table>
						
				</td>
			</tr>
		
		<? }  } else { ?>
				<h4>Alright wiseguy.... There aren't any suitable photos in there...try again.</h4>
							
		<? } ?>
		</table>
		<div style="background-color: #4E6710; border: 1px #111 solid; padding: 10px; text-align: right;">
			<input type="submit"  class="button_good" name="submit_process_party_time_photos" value="Save it all!">
		</div>
	</form>

</div>