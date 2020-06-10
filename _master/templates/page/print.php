<div id="story">
<small><?=$this->Get_Data('story_date');?> - <?=$this->Get_URL(); ?></small><br />
<h1><?=$this->Get_Data('story_title');?></h1>

<?=$this->outputStoryAuthors( $this->Get_Data('story_id') );?>
<?=$this->outputStoryPhotoArea();?>
<?=$this->Get_Data('story_content');?>
<small><?=$this->Get_URL(); ?></small>
</div>