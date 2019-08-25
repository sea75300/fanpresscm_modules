<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php if (isset($pollJsVars) && is_array($pollJsVars)) : ?><script>jQuery.extend(fpcm.vars.jsvars, <?php print json_encode($pollJsVars); ?>);</script>
    <?php endif; ?>
<script src="<?php print $pollJsFile; ?>"></script>

<div id="fpcm-poll-poll<?php print $pollId; ?>" class="fpcm-polls fpcm-polls-wrapper">
    <?php print $content; ?>
</div>