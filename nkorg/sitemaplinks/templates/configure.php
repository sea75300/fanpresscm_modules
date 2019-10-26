<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        <ul>
            <li><a href="#tabs-config"><?php $theView->write('MODULE_NKORGSITEMAPLINKS_LABEL_FIELD_CONFIG_MODULE_NKORGSITEMAPLINKS_SITEMAPPATH'); ?></a></li>
        </ul>            

        <div id="tabs-config">
            <div class="row">
                <?php $theView->textInput("config[module_nkorgsitemaplinks_sitemappath]")
                    ->setText('MODULE_NKORGSITEMAPLINKS_LABEL_FIELD_CONFIG_MODULE_NKORGSITEMAPLINKS_SITEMAPPATH')
                    ->setValue($options['module_nkorgsitemaplinks_sitemappath'])
                    ->setDisplaySizesDefault(); ?>
            </div>
        </div>
    </div>
</div>