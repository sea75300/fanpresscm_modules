<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="row no-gutters fpcm-ui-full-height">
    <div class="col-12">
        <div class="fpcm-content-wrapper fpcm-ui-full-height">
            <div class="fpcm-ui-tabs-general">
                <ul>
                    <li><a href="#tabs-config"><?php $theView->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
                </ul>            

                <div id="tabs-config">
                    <div class="row no-gutters">
                        <div class="col-12">
                            <?php $theView
                                    ->textInput("config[module_nkorgextstats_cookie_duration]")
                                    ->setValue($options['module_nkorgextstats_cookie_duration'])
                                    ->setText('MODULE_NKORGEXTSTATS_COOKIE_DURATION_VALUE')
                                    ->setWrapper(false)
                                    ->setIcon('chart-line')
                                    ->setSize('lg')
                                    ->setClass('col-6 col-md-8 fpcm-ui-border-blue-light fpcm-ui-border-radius-right fpcm-ui-input-wrapper-inner')
                                    ->setLabelClass('col-6 col-md-1 fpcm-ui-padding-none-lr fpcm-ui-border-blue-light fpcm-ui-border-none-right fpcm-ui-label-bg-grey fpcm-ui-input-wrapper-inner fpcm-ui-border-radius-left fpcm-ui-element-min-height-md'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>