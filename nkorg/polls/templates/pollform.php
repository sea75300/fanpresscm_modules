<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php /* @var $poll fpcm\modules\nkorg\polls\models\poll */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        <ul>
            <li><a href="#tabs-poll"><?php $theView->write('Umfrage'); ?></a></li>
            <li><a href="#tabs-replies"><?php $theView->write('Antworten'); ?></a></li>
        </ul>            

        <div id="tabs-poll">                
            <div class="row my-3 mx-1">
                <?php $theView
                        ->textInput("polldata[text]")
                        ->setText('Frage')
                        ->setSize(255)
                        ->setValue($poll->getText())
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-9 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->textInput("polldata[maxaw]")
                        ->setText('Anzahl wählbarer Antworten')
                        ->setType('number')
                        ->setValue($poll->getMaxreplies())
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("polldata[starttime]")
                        ->setText('Beginn')
                        ->setWrapper(false)
                        ->setValue($theView->dateText($poll->getStarttime(), 'Y-m-d'))
                        ->setClass('col-12 col-sm-6 col-md-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("polldata[stoptime]")
                        ->setText('Ende')
                        ->setValue($poll->getStoptime ? $theView->dateText($poll->getStoptime(), 'Y-m-d') : '')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
            </div>

        </div>
        
        <div id="tabs-replies">                
            <div class="row my-3 mx-1 fpcm-ui-nkorgpolls-replyline" id="fpcm-nkorgpolls-reply-1">
                <?php $theView
                        ->textInput("polldata[replies][]")
                        ->setText('Antwort 1')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-7 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
                
                <div class="col-12 col-sm-6 col-md-2">
                    <?php $theView->deleteButton('removeReply1')->setClass('fpcm-ui-nkorgpolls-removereply')->setData(['idx' => 1]); ?>
                </div>
                
            </div>
            <div class="row my-3 mx-1 fpcm-ui-nkorgpolls-replyline" id="fpcm-nkorgpolls-reply-2">
                <?php $theView
                        ->textInput("polldata[replies][]")
                        ->setText('Antwort 2')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-7 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
                
                <div class="col-12 col-sm-6 col-md-2">
                    <?php $theView->deleteButton('removeReply2')->setClass('fpcm-ui-nkorgpolls-removereply')->setData(['idx' => 2]); ?>
                </div>
            </div>
            <div class="row my-3 mx-1 fpcm-ui-nkorgpolls-replyline" id="fpcm-nkorgpolls-reply-3">
                <?php $theView
                        ->textInput("polldata[replies][]")
                        ->setText('Antwort 3')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-7 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
                
                <div class="col-12 col-sm-6 col-md-2">
                    <?php $theView->deleteButton('removeReply3')->setClass('fpcm-ui-nkorgpolls-removereply')->setData(['idx' => 3]); ?>
                </div>
            </div>
        </div>
    </div>
</div>