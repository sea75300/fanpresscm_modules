<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWTITLE_DELIMITER'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->textInput('titleHl[delimited]')->setValue('&bull;'); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_ENCODING'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->boolSelect('titleHl[encoding]')->setValue(true); ?></div>
</div>

<p><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWTITLE_HEADLINE'); ?></p>

<pre class="fpcm-ui-monospace">
&lt;?php $api->showTitle('<span id="functionParamstitleHl1">&amp;bull;</span>'<span id="functionParamstitleHl2"></span>); ?&gt;
</pre>