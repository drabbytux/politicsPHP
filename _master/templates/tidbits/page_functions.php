<? // -- Page functions -----  ?>
<a href="/page/printpage/<?=$this->Get_URL_Element( VAR_1 ); ?>" title="View a printable version of this page"><img src="/site/images/icons/paper.gif" style="width: 12px; height: 12px;">PRINT</a>
<a href="#" onClick="changeTextSize('-');return false;" title="Make the text smaller"><img src="/site/images/icons/text_small.gif" style="width: 12px; height: 12px;">SMALL</a>
<a href="#" onClick="changeTextSize('+');return false;" class="lastone" title="Make the text larger"><img src="/site/images/icons/text_large.gif" style="width: 12px; height: 12px;">LARGE</a>
<input type="hidden" id="currentFontSize" value="16" />