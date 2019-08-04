<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php /* @var $poll fpcm\modules\nkorg\polls\models\poll */ ?>
<?php /* @var $reply fpcm\modules\nkorg\polls\models\poll_reply */ ?>
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
                        ->setValue($poll->getStoptime() ? $theView->dateText($poll->getStoptime(), 'Y-m-d') : '')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
            </div>
            <?php if ($poll->getId()) : ?>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("polldata[votessum]")
                        ->setText('Stimmenanzahl')
                        ->setValue($poll->getVotessum())
                        ->setType('number')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <label class="col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general">
                    <?php $theView->write('Umfrage geschlossen'); ?>
                </label>
                <div class="col-12 col-sm-6 col-md-1 fpcm-ui-padding-none-lr">
                <?php $theView->boolSelect("polldata[closed]")->setSelected($poll->getIsclosed()); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div id="tabs-replies">
            
            <?php foreach ($replies as $idx => $reply) : ?>
            <div class="row my-3 mx-1 fpcm-ui-nkorgpolls-replyline" id="fpcm-nkorgpolls-reply-<?php print $idx; ?>">
                <?php $theView->hiddenInput("polldata[ids][]", "polldataids{$idx}")->setValue($reply->getId()); ?>

                <?php $theView
                        ->textInput("polldata[replies][]", "polldatareplies{$idx}")
                        ->setText('Antwort '. ($idx + 1) )
                        ->setValue($reply->getText())
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-md-5 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general'); ?>
                
                <?php if ($poll->getId()) : ?>
                <div class="col-12 col-sm-3 col-md-1">
                    <?php $theView
                            ->textInput("polldata[sums][]", "polldatareplies{$idx}")
                            ->setValue($reply->getVotes())
                            ->setType('number'); ?>
                </div>
                <?php endif; ?>

                <div class="col-12 col-sm-6 col-md-2">
                    <?php $theView->deleteButton('removeReply1')->setClass('fpcm-ui-nkorgpolls-removereply')->setData(['idx' => $idx ]); ?>
                </div>
                
            </div>
            <?php endforeach;  ?>
        </div>
    </div>
</div>