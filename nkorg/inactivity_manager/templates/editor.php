<?php /* @var $theView fpcm\view\viewVars */ ?>
<div class="p-2 border-5 border-primary border-top">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="row g-0">
                <?php $theView->dateTimeInput('msg[dateFrom]')->setText('MODULE_NKORGINACTIVITY_MANAGER_MSGSTART')->setValue(date('Y-m-d', $obj->getStarttime())); ?>
            </div>
        </div>
        <div class="col align-self-center mb-3">
            <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGSTART_TIME'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="row g-0">
                <?php $theView->dateTimeInput('msg[dateTo]')->setText('MODULE_NKORGINACTIVITY_MANAGER_MSGEND')->setValue(date('Y-m-d', $obj->getStarttime())); ?>
            </div>
        </div>
        <div class="col align-self-center mb-3">
            <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGEND_TIME'); ?>
        </div>
    </div>

    <div class="row mx-3">
        <?php $theView->checkbox('msg[comments]')->setText('MODULE_NKORGINACTIVITY_MANAGER_MSGNOCOMMENTS')->setSelected($obj->getNocomments())->setSwitch(true); ?>
    </div>

    <div class="row">
        <div class="col-12 fw-bold fs-3">
            <?php $theView->write('MODULE_NKORGINACTIVITY_MANAGER_MSGTEXT'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php $theView->textarea('msg[text]')->setValue($obj->getText(), ENT_QUOTES | ENT_COMPAT)->setClass('fpcm-ui-textarea-medium'); ?>
        </div>
    </div>
</div>