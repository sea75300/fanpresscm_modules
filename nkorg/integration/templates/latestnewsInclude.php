<?php /* @var $theView fpcm\view\viewVars */ ?>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_COUNT'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->textInput('latest[count]')->setValue($articleCount)->setText('')->setWrapper(true); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_CATEGORY'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->select('latest[category]')->setOptions($categories); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_ENCODING'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->boolSelect('latest[encoding]')->setValue(true); ?></div>
</div>

<p><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWLATEST_HEADLINE'); ?></p>

<pre class="fpcm-ui-monospace">
&lt;div class=&quot;fpcm-pub-content&quot;&gt;
&lt;?php
$api->showLatestNews(<span id="functionParamsLatest"></span>);
?&gt;
&lt;/div&gt;
</pre>