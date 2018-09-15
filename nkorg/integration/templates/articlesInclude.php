<?php /* @var $theView fpcm\view\viewVars */ ?>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_COUNT'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->textInput('article[count]')->setValue($articleCount); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_CATEGORY'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->select('article[category]')->setOptions($categories); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_TEMPLATENAME'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->select('article[template]')->setOptions($templates); ?></div>
</div>

<div class="row no-gutters fpcm-ui-padding-md-tb">
    <div class="col-12 col-sm-6"><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_ENCODING'); ?>:</div>
    <div class="col-12 col-sm-3"><?php $theView->boolSelect('article[encoding]')->setValue(true); ?></div>
</div>

<p><?php $theView->write('MODULE_NKORGINTEGRATION_TEXT_SHOWARTICLES_HEADLINE'); ?></p>

<pre class="fpcm-ui-monospace">
&lt;div class=&quot;fpcm-pub-content&quot;&gt;
&lt;?php
$api->showArticles(<span id="functionParams"></span>);
?&gt;
&lt;/div&gt;
</pre>