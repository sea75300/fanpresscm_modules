<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWTITLE_DELIMITER'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->textInput('titlePages[delimited]')->setValue('&bull; Page')->setText('')->setWrapper(true); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_ENCODING'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->boolSelect('titlePages[encoding]')->setValue(true); ?></div>
</div>

<p><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWTITLE_HEADLINE'); ?></p>

<pre class="fpcm-ui-monospace">
&lt;?php $api->showPageNumber('<span id="functionParamstitlePages1">&amp;bull; Page</span>'<span id="functionParamstitlePages2"></span>); ?&gt;
</pre>