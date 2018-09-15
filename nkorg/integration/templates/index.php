<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        
        <div id="fpcm-ui-integration-items">
            
            <?php foreach ($items as $descr => $value) : ?>
                <?php if ($value === null) continue; ?>

                <h2><?php $theView->write($descr) ?></h2>
                <div>
                    <?php include __DIR__.DIRECTORY_SEPARATOR.$value.'.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</div>