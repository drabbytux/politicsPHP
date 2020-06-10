<? if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR && !$this->Get_Data('file_used') )) { ?>
<div style="border: 1px red dashed; background-color: #eee; padding: 4px 10px;width: 80%;">
	<a href="/<?=$this->Get_URL_Element( REQUEST_CONTROLLER );?>/edit/<?=$this->Get_URL_Element( VAR_1 );?>">Edit</a> | <a href="/<?=$this->Get_URL_Element( REQUEST_CONTROLLER );?>/edit">Create new</a>
	<?=$this->Get_Data('messages');?>
	<?=$this->Get_Data('errors');?>
</div>
<? } ?>