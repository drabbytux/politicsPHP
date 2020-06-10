<div style="margin: 10px 0px; padding: 10px; border: 1px #B7B5A6 solid; border-bottom: 10px #B7B5A6 solid; border-top: 10px #B7B5A6 solid; background: url(/site/images/backgrounds/light_brown_tps.jpg) top right;">
	<table style="width: 100%; background: transparent;"><tr>
		<td style="width: 250px; background: transparent;"><img src="/site/images/logos/talking_points.gif" /><br />
			<?
				$x=0;
				foreach($this->Get_Data('talking_point_items') as $tp ){
					if( $this->Get_Data('taling_point_random_number') != $x ){ ?>
						<a style="font-size: 9pt;" href="/page/view/<?=$tp['story_url_id']; ?>"><?=$tp['story_title']; ?></a><br />
			<?		}
					$x++;
				}
			
			?>
		</td>
		<td style=" background: transparent;">
				<h3 style="color: #444; border-bottom: 1px #333 solid;"><?=$this->Get_Data('talking_point_random','story_title');?></h3>
				<p style="font-size: 11pt;">
					<?=$this->Get_Data('talking_point_random','story_content');?>
				</p>
		</td>
	</tr></table>
</div>