<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php /* @var $poll fpcm\modules\nkorg\polls\models\poll */ ?>
<?php /* @var $reply fpcm\modules\nkorg\polls\models\poll_reply */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        <ul>
            <?php if ($poll->getId() && $poll->getVotessum()) : ?>
            <li><a href="#tabs-graphic"><?php $theView->write('MODULE_NKORGPOLLS_GUI_RESULT'); ?></a></li>
            <?php endif; ?>
            <li><a href="#tabs-poll"><?php $theView->write('MODULE_NKORGPOLLS_GUI_POLL'); ?></a></li>
            <li><a href="#tabs-replies"><?php $theView->write('MODULE_NKORGPOLLS_GUI_REPLIES'); ?></a></li>
            <?php if ($poll->getId() && $poll->getVotessum()) : ?>
            <li><a href="<?php print $theView->controllerLink('polls/votelog', ['pid' => $poll->getId()]); ?>"><?php $theView->write('MODULE_NKORGPOLLS_GUI_VOTESLIST'); ?></a></li>
            <?php endif; ?>
        </ul>            

        <?php if ($poll->getId() && $poll->getVotessum()) : ?>
        <div id="tabs-graphic">
            <div class="row no-gutters align-self-center align-content-center justify-content-center">
                <div class="col-12 col-lg-9 col-lg-6">
                    <canvas id="fpcm-nkorg-polls-chart" class="fpcm-ui-full-width fpcm-ui-full-height"></canvas>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div id="tabs-poll">                
            <div class="row my-3 mx-1">
                <?php $theView
                        ->textInput("polldata[text]")
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_TEXT')
                        ->setSize(255)
                        ->setValue($poll->getText())
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-lg-9 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->textInput("polldata[maxaw]")
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_MAXVOTES')
                        ->setType('number')
                        ->setValue($poll->getMaxreplies())
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-lg-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("polldata[starttime]")
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_START')
                        ->setWrapper(false)
                        ->setValue($theView->dateText($poll->getStarttime(), 'Y-m-d'))
                        ->setClass('col-12 col-sm-6 col-lg-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("polldata[stoptime]")
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_STOP')
                        ->setValue($poll->getStoptime() ? $theView->dateText($poll->getStoptime(), 'Y-m-d') : '')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-lg-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->textInput("polldata[voteexpiration]")
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_COOKIE')
                        ->setValue($poll->getVoteExpiration())
                        ->setType('number')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-lg-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
            </div>
            <?php if ($poll->getId()) : ?>
            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("polldata[votessum]")
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_VOTES')
                        ->setValue($poll->getVotessum())
                        ->setType('number')
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-lg-1 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
            </div>
            <div class="row my-3 mx-1">
                <label class="col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general">
                    <?php $theView->write('MODULE_NKORGPOLLS_GUI_POLL_ISCLOSED'); ?>
                </label>
                <div class="col-12 col-sm-6 col-lg-1 fpcm-ui-padding-none-lr">
                <?php $theView->boolSelect("polldata[closed]")->setSelected($poll->getIsclosed()); ?>
                </div>
            </div>
            <div class="row my-3 mx-1">
                <label class="col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general">
                    <?php $theView->write('MODULE_NKORGPOLLS_GUI_POLL_INARCHIVE'); ?>
                </label>
                <div class="col-12 col-sm-6 col-lg-1 fpcm-ui-padding-none-lr">
                <?php $theView->boolSelect("polldata[inarchive]")->setSelected($poll->getShowarchive()); ?>
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
                        ->setText('MODULE_NKORGPOLLS_GUI_POLL_REPLY_TXT', [
                            'id' => ($idx + 1)
                        ])
                        ->setValue($reply->getText())
                        ->setWrapper(false)
                        ->setClass('col-12 col-sm-6 col-lg-5 fpcm-ui-field-input-nowrapper-general pr-0')
                        ->setLabelClass('col-12 col-sm-6 col-lg-3 fpcm-ui-field-label-general'); ?>
                
                <?php if ($poll->getId()) : ?>
                <div class="col-12 col-sm-3 col-lg-1">
                    <?php $theView
                            ->textInput("polldata[sums][]", "polldatareplies{$idx}")
                            ->setText('')
                            ->setValue($reply->getVotes())
                            ->setType('number'); ?>
                </div>
                <?php endif; ?>

                <div class="col-12 col-sm-6 col-lg-2">
                    <?php $theView->deleteButton('removeReply1')->setClass('fpcm-ui-nkorgpolls-removereply')->setData(['idx' => $idx ]); ?>
                </div>
                
            </div>
            <?php endforeach;  ?>
        </div>
    </div>
</div>