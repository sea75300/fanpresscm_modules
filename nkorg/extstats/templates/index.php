<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="row border-top border-5 border-primary">
    <div class="col-12 col-md-6">
        <fieldset>

            <div class="row my-2">
            <?php $theView->dateTimeInput('dateFrom')->setValue($start)->setText('ARTICLE_SEARCH_DATE_FROM')->setMIn($minDate); ?>
            </div>

            <div class="row my-2">
            <?php $theView->dateTimeInput('dateTo')->setValue($stop)->setWrapperClass('fpcm-ui-datepicker-inputwrapper')->setText('ARTICLE_SEARCH_DATE_TO'); ?>
            </div>

            <div class="row my-2">
            <?php $theView->select('chartType')->setText('MODULE_NKORGEXTSTATS_LABEL_FIELD_CHARTTYPE')->setClass('fpcm-ui-input-select-articleactions')->setOptions($chartTypes)->setSelected($chartType)->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
            </div>

            <div class="row my-2 <?php if ($isLinks) : ?>d-none<?php endif; ?>">
            <?php $theView->select('chartMode')->setText('MODULE_NKORGEXTSTATS_LABEL_FIELD_CHARTMODE')->setClass('fpcm-ui-input-select-articleactions')->setOptions($chartModes)->setSelected($chartMode)->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
            </div>

            <div class="row my-2 <?php if (!$isLinks) : ?>d-none<?php endif; ?>">
            <?php $theView->select('sortType')->setText('MODULE_NKORGEXTSTATS_LABEL_FIELD_SORTTYPE')->setOptions($sortTypes)->setSelected($sortType)->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
            </div>
        </fieldset>
    </div>
</div>            

<div class="row align-self-center align-content-center justify-content-center">
    <div class="col-12 col-md-8">
    <?php if ($notfound) : ?>
        <p class="fpcm-ui-padding-none fpcm-ui-margin-none"><?php $theView->icon('images', 'far')->setStack('ban fpcm-ui-important-text')->setSize('lg')->setStackTop(true); ?> <?php $theView->write('GLOBAL_NOTFOUND2'); ?></p>
    <?php else : ?>
        <canvas id="fpcm-nkorg-extendedstats-chart"></canvas>
    <?php endif; ?>
    </div>
</div>

<?php if (!$notfound) : ?>
<h3 class="<?php if (!$isLinks) : ?>d-none<?php else : ?>p-3<?php endif; ?>"><?php $theView->write('MODULE_NKORGEXTSTATS_HITS_LIST'); ?></h3>

<div id="fpcm-dataview-extendedstats-list">
<?php endif; ?>
</div>
