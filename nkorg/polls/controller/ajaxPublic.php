<?php

namespace fpcm\modules\nkorg\polls\controller;

final class ajaxPublic extends \fpcm\controller\abstracts\module\ajaxController {

    /**
     *
     * @var int
     */
    private $pollId;

    public function request()
    {
        $this->pollId = $this->request->fromPOST('pid', [
            \fpcm\model\http\request::FILTER_CASTINT
        ]);
        
        if (!$this->pollId) {
            $this->response->setReturnData( new \fpcm\modules\nkorg\polls\models\pubMsg(0) )->fetch();
        }

        usleep(500);

        if ($this->processByParam() === \fpcm\controller\abstracts\controller::ERROR_PROCESS_BYPARAMS) {
            return false;
        }

        return true;
    }

    public function hasAccess()
    {
        return true;
    }
    
    final protected function processVote()
    {
        $replyIds = $this->request->fromPOST('rids', [
            \fpcm\model\http\request::FILTER_CASTINT
        ]);

        if (!count($replyIds)) {
            return false;
        }
        
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists() || !$poll->isOpen() || $poll->hasVoted()) {

            $this->response->setReturnData(
                new \fpcm\modules\nkorg\polls\models\pubMsg(
                    -404,
                    $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_REPLY'))
            ))->fetch();

        }
        
        if (!$poll->pushnewVote($replyIds)) {

            $this->response->setReturnData(
                new \fpcm\modules\nkorg\polls\models\pubMsg(
                    -101,
                    $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_REPLY'))
            ))->fetch();

        }

        $this->response->setReturnData(
            new \fpcm\modules\nkorg\polls\models\pubMsg(
                100,
                $this->language->translate($this->addLangVarPrefix('MSG_PUB_SUCCESS_REPLY')),
                (new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm()
        ))->fetch();

    }
    
    final protected function processResult()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {

            $this->response->setReturnData(
                new \fpcm\modules\nkorg\polls\models\pubMsg(
                    -404,
                    $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_POLL'))
            ))->fetch();

        }

        $this->response->setReturnData(
            new \fpcm\modules\nkorg\polls\models\pubMsg(
                300,
                '',
                (new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm(true)
        ))->fetch();

    }
    
    final protected function processPollForm()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {

            $this->response->setReturnData(
                new \fpcm\modules\nkorg\polls\models\pubMsg(
                    -404,
                    $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_POLL'))
            ))->fetch();

        }

        if (!$poll->isOpen()) {

            $this->response->setReturnData(
                new \fpcm\modules\nkorg\polls\models\pubMsg(
                    -401,
                    $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_CLOSED'))
            ))->fetch();

        }

        $this->response->setReturnData(
            new \fpcm\modules\nkorg\polls\models\pubMsg(
                400,
                '',
                $poll->hasVoted()
                    ? ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm()
                    : ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getVoteForm()
        ))->fetch();

    }
}
