<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">

        <ul>
            <li><a href="#maintab"><?php $theView->write($sourceStr); ?><?php if ($modeStr) : ?> <?php $theView->write('MODULE_NKORGEXTSTATS_BY' . $modeStr); ?><?php endif; ?></a></li>
        </ul>

        <div id="maintab">

            <div class="row no-gutters" id="fpcm-nkorg-extendedstats-dateform"<?php if ($showDate) : ?> style="display:none;"<?php endif; ?>>
                <div class="col-12 fpcm-ui-padding-lg-bottom">
                    <?php $theView->textInput('dateFrom')->setValue($start)->setClass('fpcm-ui-datepicker')->setWrapperClass('fpcm-ui-datepicker-inputwrapper')->setText('ARTICLE_SEARCH_DATE_FROM')->setPlaceholder(true); ?>
                    <?php $theView->textInput('dateTo')->setValue($stop)->setClass('fpcm-ui-datepicker')->setWrapperClass('fpcm-ui-datepicker-inputwrapper')->setText('ARTICLE_SEARCH_DATE_TO')->setPlaceholder(true); ?>
                </div>
            </div>

            <div class="row no-gutters align-self-center align-content-center justify-content-center">
                <div class="col-12<?php if (!$notfound) : ?> col-md-10 col-lg-7<?php endif; ?>">
                <?php if ($notfound) : ?>
                    <p class="fpcm-ui-padding-none fpcm-ui-margin-none"><?php $theView->icon('images', 'far')->setStack('ban fpcm-ui-important-text')->setSize('lg')->setStackTop(true); ?> <?php $theView->write('GLOBAL_NOTFOUND2'); ?></p>
                <?php else : ?>
                    <canvas id="fpcm-nkorg-extendedstats-chart"></canvas>
                <?php endif; ?>
                </div>
            </div>

        <?php if (!$notfound) : ?>
            <h3<?php if (!$showDate) : ?> style="display:none;"<?php endif; ?>><?php $theView->write('MODULE_NKORGEXTSTATS_HITS_LIST'); ?></h3>
            
            <div id="fpcm-nkorg-extendedstats-list" class="fpcm-ui-padding-lg-top">
        <?php endif; ?>
            </div>

        </div>
    </div>
</div>