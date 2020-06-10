<div  id="bottom_headlines">
	<table>
		<tr>
			<td>
				<h4>News</h4>
					<ul>
					<?
						foreach( $this->_fetchSectionStories( 3, 0, 10, true) as $hitem) { ?>
							<li><a href="/page/view/<?=$this->toURL( $hitem['story_url_id'],NULL,$hitem['story_issue_date'])?>"><?=$hitem['story_title']?></a></li>
						<?}
					?>
					</ul>
			</td>
			<td>
				<h4>Columns</h4>
					<ul>
					<?
						foreach( $this->_fetchSectionStories( 2, 0, 10, true) as $hitem) { ?>
							<li><a href="/page/view/<?=$this->toURL( $hitem['story_url_id'],NULL,$hitem['story_issue_date'])?>"><?=$hitem['story_title']?></a></li>
						<?}
					?>
					</ul>
			</td>
			<td>
				<h4>Opinions</h4>
					<ul>
					<?
						foreach( $this->_fetchSectionStories( 1, 0, 10, true) as $hitem) { ?>
							<li><a href="/page/view/<?=$this->toURL( $hitem['story_url_id'],NULL,$hitem['story_issue_date'])?>"><?=$hitem['story_title']?></a></li>
						<?}
					?>
					</ul>
			</td>
		</tr>
		<tr>
			<td>
				<h4>Letters</h4>
					<ul>
					<?
						foreach( $this->_fetchStories( 13, 0, 10, true) as $hitem) { ?>
							<li><a href="/page/view/<?=$this->toURL( $hitem['story_url_id'],NULL,$hitem['story_issue_date'])?>"><?=$hitem['story_title']?></a></li>
						<?}
					?>
					</ul>
			</td>
			<td>
				<h4>Q&As</h4>
					<ul>
					<?
						foreach( $this->_fetchStories( 20, 0, 10, true) as $hitem) { ?>
							<li><a href="/page/view/<?=$this->toURL( $hitem['story_url_id'],NULL,$hitem['story_issue_date'])?>"><?=$hitem['story_title']?></a></li>
						<?}
					?>
					</ul>
			</td>
			<td>
				<h4>Editorials</h4>
					<ul>
					<?
						foreach( $this->_fetchStories( 4, 0, 10, true) as $hitem) { ?>
							<li><a href="/page/view/<?=$this->toURL( $hitem['story_url_id'],NULL,$hitem['story_issue_date'])?>"><?=$hitem['story_title']?></a></li>
						<?}
					?>
					</ul>
			</td>
		</tr>
	</table>
</div>