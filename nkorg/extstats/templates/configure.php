<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        <ul>
            <li><a href="#tabs-config"><?php $theView->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
        </ul>            

        <div id="tabs-user">                
            <div class="row m-3">
                <?php $theView
                        ->textInput("config[module_nkorgextstats_cookie_duration]")
                        ->setValue($options['module_nkorgextstats_cookie_duration'])
                        ->setText('MODULE_NKORGEXTSTATS_COOKIE_DURATION_VALUE')
                        ->setType('number')
                        ->setIcon('chart-line')
                        ->setSize('lg')
                        ->setDisplaySizesDefault(); ?>
            </div>
            <div class="row m-3">
                <?php $theView
                        ->textInput("config[module_nkorgextstats_timespan_default]")
                        ->setValue($options['module_nkorgextstats_timespan_default'])
                        ->setText('MODULE_NKORGEXTSTATS_DEFAULT_GRAPH_TIMESPAN')
                        ->setType('number')
                        ->setIcon('clock', 'far')
                        ->setSize('lg')
                        ->setDisplaySizesDefault(); ?>
            </div>
            <div class="row m-3">
                <?php $theView
                        ->textInput("config[module_nkorgextstats_link_compress]")
                        ->setValue($options['module_nkorgextstats_link_compress'])
                        ->setText('MODULE_NKORGEXTSTATS_CLEANUP_LIMIT')
                        ->setType('number')
                        ->setIcon('eraser')
                        ->setSize('lg')
                        ->setDisplaySizesDefault(); ?>
            </div>
            <div class="row m-3">
                <div class="col-12 px-0">
                    <div class="row">
                        <label class="col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general">
                            <?php $theView->icon('language'); ?>
                            <?php $theView->write('MODULE_NKORGEXTSTATS_DEAULT_SHOW_VISITORS'); ?>:
                        </label>
                        <div class="col-auto fpcm-ui-padding-none-lr">
                            <?php $theView->boolSelect("config[module_nkorgextstats_show_visitors]")->setSelected($options['module_nkorgextstats_show_visitors']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <?php $theView
                        ->textInput("config[module_nkorgextstats_url_base]")
                        ->setValue($options['module_nkorgextstats_url_base'])
                        ->setText('MODULE_NKORGEXTSTATS_URL_BASE')
                        ->setType('url')
                        ->setIcon('link')
                        ->setSize('lg')
                        ->setDisplaySizesDefault(); ?>
            </div>
        </div>
    </div>
</div>