<? // -- Most Popular -----  ?>
<div>
	<div class="TabbedPanelsHeading">
		<div class="TabbedPanelsHeadingContent">Popular Stories This Month</div>
	</div>
		<div class="TabbedPanels" id="tp1" style="margin-bottom: 15px;">
			<ul class="TabbedPanelsTabGroup">
				<li class="TabbedPanelsTab" tabindex="0">Emailed</li>
				<li class="TabbedPanelsTab" tabindex="1">Viewed</li>
			</ul>
			<div class="TabbedPanelsContentGroup">
				<div class="TabbedPanelsContent">
					<ol>
					<?
						$most_emailed_array = $this->MostEmailed(10);
						if( is_array( $most_emailed_array  ) ) {
						foreach( $most_emailed_array as $item ){ ?>
							<li><a href="/page/view/<?=$this->Get_Folder_Name_For_View( $item['story_url_id'] );?>"><?=$item['story_title'];?></a></li>
					<? } } ?>
					</ol>
				</div>
				<div class="TabbedPanelsContent">
					<ol>
					<?
						$most_searched_array = $this->MostViewed(10);
						if( is_array( $most_searched_array  ) ) {
						foreach( $most_searched_array as $item ){ ?>
							<li><a href="/page/view/<?=$this->Get_Folder_Name_For_View( $item['story_url_id'] );?>"><?=$item['story_title'];?></a></li>
					<? } } ?>
					</ol>
				</div>
				<!--  
				<div class="TabbedPanelsContent">
					<ol>
					<?
					/*
						$most_bookmarked_array = $this->MostBookmarked(10);
						if( is_array( $most_bookmarked_array  ) ) {
						foreach( $most_bookmarked_array as $item ){ ?>
							<li><a href="/page/view/<?=$this->Get_Folder_Name_For_View( $item['story_url_id'] );?>"><?=$item['story_title'];?></a></li>
					<? } } */ ?>
					</ol>
				</div>
				// -->
			</div>
		</div>
	
</div>
