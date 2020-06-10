<? /**
    *  Original template
    * a POST 2008 template, for generic Issues
    *
    */
?>

<div id="issue_master">
	<table style="width: 100%;">
		<tr>
			<td style="width: 400px; height:600px;background-image: url('/EM/2008/november/111908_throw.jpg');"><? // [ HOME PAGE THROW ] ?>
				&nbsp;
			</td>
			<td style="width: 240px;">


<? // [ HOME PAGE STORY ] ?>
<img src="/EM/2008/november/111908_throw2.jpg" /><br /><br />
<style>
<!--
#a111908_throws div {padding: 8px 0px 10px 8px; }
#a111908_throws div a {font-family:  arial,verdana; font-size: 150%; line-height: 130%; font-weight: bold; color: #000; }
// -->
</style>
<div id="a111908_throws">
	<div><a href="/page/view/foreign_affairs-11-19-2008">The Burning Issues</a></div>
	
	<div><a href="/page/view/staffers_settle-11-19-2008">Staffers a Movin'</a></div>
	
	<div><a href="/page/view/lobby_circles-11-19-2008">'3 Es' of Lobbying</a></div>
	
	<div><a href="/page/view/parliamentary_secretaries-11-19-2008">Meet the Secretaries</a></div>
	
	<div><a href="/page/view/best_days-11-19-2008">The Life of a Critic</a></div>
	
	<div><a href="/page/view/chatterhouse-11-19-2008">Milliken the New Old Speaker</a></div>
	
	<div><a href="/page/view/list-11-19-2008">Who to Know</a></div>
</div>

			</td>
		</tr>
	</table>

	<? // End of the Front Page stuff. ?>

<?=$this->Get_Data('talking_points_highlight'); ?>

<? // Bottom content for the issue ?>
	<table style="width: 100%;">
		<tr>
			<td style="width: 400px"><?// Master left column ?>


			<? // NEWS ?>
				<?=$this->outputHeader('NEWS', array(NEWS, 26, 30, 5, 23) ); ?>
				
				
				<?=$this->outputSection(NEWS);?>

				<?=$this->outputSection(30);?>
				<?=$this->outputSection(26);?>
				<?=$this->outputSection(5);?>
				<?=$this->outputSection(23);?>
				
			<? // FEATURES ?>
				<?=$this->outputHeader('FEATURES', array(FEATURE, QA) ); ?>
				<?=$this->outputSection(FEATURE);?>
				<?=$this->outputSection(QA);?>

			<? // POLICY BRIEFING ?>
				<?=$this->outputHeader('POLICY BRIEFING', array(POLICYBRIEFING), 'policy_briefing_box_on_issue' ); ?>
				<?=$this->outputSection(POLICYBRIEFING, false);?>
				<?=$this->outputFooter( array(POLICYBRIEFING) ); ?>

			</td>
			<td style="width: 2px;background: url('/site/images/backgrounds/line_1.gif') repeat-y #fff;width: 2px; padding: 0px 0px 0px 0px;"><img src="/site/images/spacer.gif" style="width: 1px height: 1px;" /></td>
			<td><? // Master right column ?>
				<?=$this->outputHeader('OPINION', array(EDITORIAL,COLUMNS,OPED, 32) ); // 32 inside defence ?>
				<?=$this->outputSection(EDITORIAL, false);?>
				
			<? // COLUMNS ?>
				<?=$this->outputHeader('COLUMNS', array(COLUMNS, 32,33) ); ?>
				<?=$this->outputSection(COLUMNS, false);?>
				<?=$this->outputSection(32, false);?>
				<?=$this->outputSection(33, false);?>
				
				
				<?=$this->outputSection(OPED, false);?>

				<?=$this->outputHeader('CULTURE', array(LISTINGS, 34) ); ?>
				<?=$this->outputSection(11, false);?>
				<?=$this->outputSection(34, false);?>
				<?=$this->outputSection(LISTINGS, false);?>
			</td>
		</tr>
	</table>

		<?// Cartoon, Party time and others! ?>
		 <div>
			<?=$this->outputRotationItems(); ?>
		 </div>
</div>
