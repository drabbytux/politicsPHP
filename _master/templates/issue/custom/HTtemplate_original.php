<? /**
    *  Original template
    * a POST 2008 template, for generic Issues
    * 
    */

?>

<div id="issue_master">
	<table style="width: 100%;">
		<tr>
			<td style="width: 300px"><? // [ HOME PAGE THROW ] ?>
				<? // Find a way to remove the anchor tag if the throw source is the issue and NOT the story
					if( is_array($this->Get_Data('throw') ) ) { ?>

						<a href="/page/view/<?=$this->getIssueStoryElement(FRONT_PAGE,0,'story_url_id');?>"><img title="<?=htmlentities( $this->Get_Data('throw', 'photo_cutline') );?>" style="border: 1px #999 solid;" src="<?=URL_PHOTOS_DIR;?>/<?=$this->Get_Data('throw', 'photo_inserted_year');?>/<?=$this->Get_Data('throw', 'photo_inserted_month');?>/<?=$this->Get_Data('throw', 'photo_file_name');?>" /></a>
						<div style="font-size: 7pt; font-family: verdana; text-align: right;"><?=$this->Get_Data('throw', 'photo_byline');?></div>
						<div class="cutline" ><?=($this->Get_Data('issue_override_throw_photo_id') )? $this->Get_Data('issue_override_throw_photo_cutline') : $this->Get_Data('throw', 'photo_cutline');?></div>
				 <?	} ?>
<? // [ HOME PAGE STORY ] ?>
					<h2><a href="/page/view/<?=$this->getIssueStoryElement(FRONT_PAGE,0,'story_url_id');?>"><?=$this->getIssueStoryElement(FRONT_PAGE,0,'story_title')?></a></h2>
					<?=$this->outputStoryAuthors( $this->getIssueStoryElement(FRONT_PAGE,0,'story_id') );?>
					<p>
						<?=$this->getIssueStoryElement(FRONT_PAGE,0,'story_kicker');?>
						<?=$this->getIssueStoryElement(FRONT_PAGE,0,'story_brief');?>
					</p>
					<?=$this->outputIssueAdminSection( $this->getIssueStoryElement(FRONT_PAGE,0,'story_id') );?>
			</td>
			<td style="width: 340px;">

				<? if( is_array($this->getIssueSectionArray(FRONT_PAGE, '0', true ) )) {
					$first_one = true;
					foreach( $this->getIssueSectionArray(FRONT_PAGE, '0', true ) as $front_page_stories ) { ?>
					<div class="<?=($first_one)? 'storyseperator_first': 'storyseperator';?>">
							
						<h2><a href="/page/view/<?=$front_page_stories['story_url_id'];?>"><?=$front_page_stories['story_title'];?></a></h2>
							<?=$this->outputStoryAuthors( $front_page_stories['story_id'] );?>
							<?=$this->outputStoryPhoto( $front_page_stories['story_id'], SMALL, 'smallphotoleft' );?>
							<p>
								<?=$front_page_stories['story_kicker'];?>
								<?=$front_page_stories['story_brief'];?>
							</p>
							<?=$this->outputIssueAdminSection( $front_page_stories['story_id'] ) ;?>
					</div>
				<? $first_one=false; } } ?>
			</td>
		</tr>
	</table>

	<? // End of the Front Page stuff. ?>

	<table style="width: 100%;">
		<tr>
			<td style="width: 400px"><?// Master left column ?>

			
			<? // NEWS ?>
				<?=$this->outputHeader('NEWS', array(NEWS, 30) ); ?>
				<?=$this->outputSection(NEWS);?>
				
				<?=$this->outputSection(30);?>
			
			<?=$this->outputHeader('COLUMNS', array(COLUMNS) ); ?>
			<?=$this->outputSection(COLUMNS, false);?>
								
			<? // FEATURES ?>
				<?=$this->outputHeader('FEATURES', array(FEATURE, QA) ); ?>
				<?=$this->outputSection(FEATURE);?>
				<?=$this->outputSection(QA);?>
	
			<? // POLICY BRIEFING ?>
				<?=$this->outputHeader('POLICY BRIEFING', array(POLICYBRIEFING) ); ?>
				<?=$this->outputSection(POLICYBRIEFING, false);?>
				
			</td>
			<td style="width: 2px;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff;width: 2px; padding: 0px 0px 0px 0px;"><img src="/site/images/spacer.gif" style="width: 1px height: 1px;" /></td>
			<td><? // Master right column ?>
				<?=$this->outputHeader('OPINION', array(EDITORIAL,COLUMNS,OPED) ); ?>
				<?=$this->outputSection(EDITORIAL, false);?>

				<?=$this->outputSection(OPED, false);?>
				
				
				<?=$this->outputHeader('EVENTS, ARTS & CULTURE', array(CALENDAR) ); ?>
				<?=$this->outputSection(CALENDAR, false);?>
			</td> 
		</tr>
	</table>
	

	
</div>
