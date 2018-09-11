<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="row no-gutters fpcm-ui-full-height">
    <div class="col-12">
        <div class="fpcm-content-wrapper fpcm-ui-full-height">
            <div class="fpcm-ui-tabs-general">
                <ul>
                    <li><a href="#tabs-config"><?php $theView->write('MODULE_NKORGSITEMAPLINKS_SITEMAPPATH'); ?></a></li>
                </ul>            

                <div id="tabs-config">
                    <div class="row no-gutters">
                        <div class="col-12"><?php $theView->textInput("config[module_nkorgsitemaplinks_sitemappath]")->setValue($options['module_nkorgsitemaplinks_sitemappath']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>