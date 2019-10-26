<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">

        <ul>
            <li><a href="#maintab"><?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_' . $modeStr); ?></a></li>
        </ul>

        <div id="maintab">

            <div class="row no-gutters">
                <div class="col-12 col-md-3 fpcm-ui-padding-lg-bottom fpcm-ui-padding-md-top">
                    <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGTEXT'); ?>
                </div>
                <div class="col-12 col-md-4 fpcm-ui-padding-lg-bottom">
                    <?php $theView->textarea('msg[text]')->setClass('fpcm-ui-full-width')->setValue($obj->getText()); ?>
                </div>
            </div>

            <div class="row no-gutters">
                <div class="col-12 col-md-3 fpcm-ui-padding-lg-bottom align-self-center">
                    <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGSTART'); ?>
                </div>
                <div class="col-12 col-md-6 fpcm-ui-padding-lg-bottom align-self-center">
                    <?php $theView->textInput('msg[dateFrom]')->setText('')->setWrapper(true)->setValue(date('Y-m-d', $obj->getStarttime()))->setClass('fpcm-ui-datepicker')->setWrapperClass('fpcm-ui-datepicker-inputwrapper'); ?>
                    <span class="fpcm-ui-padding-md-left"><?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGSTART_TIME'); ?></span>
                </div>
            </div>

            <div class="row no-gutters">
                <div class="col-12 col-md-3 fpcm-ui-padding-lg-bottom align-self-center">
                    <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGEND'); ?>
                </div>
                <div class="col-12 col-md-6 fpcm-ui-padding-lg-bottom align-self-center">
                    <?php $theView->textInput('msg[dateTo]')->setText('')->setWrapper(true)->setValue(date('Y-m-d', $obj->getStoptime()))->setClass('fpcm-ui-datepicker')->setWrapperClass('fpcm-ui-datepicker-inputwrapper'); ?>
                    <span class="fpcm-ui-padding-md-left"><?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGEND_TIME'); ?></span>
                </div>
            </div>

            <div class="row no-gutters">
                <div class="col-12 col-md-3 fpcm-ui-padding-lg-bottom align-self-center">
                    <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGNOCOMMENTS'); ?>
                </div>
                <div class="col-12 col-md-9 fpcm-ui-padding-lg-bottom">
                    <?php $theView->checkbox('msg[comments]')->setSelected($obj->getNocomments()); ?>
                </div>
            </div>

            <div class="row no-gutters">
                <div class="col-12">
                    <canvas id="fpcm-nkorg-extendedstats-chart"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>