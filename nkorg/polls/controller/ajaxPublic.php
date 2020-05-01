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
        $this->response = new \fpcm\model\http\response;
        
        $this->returnData = ['code' => 0, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_GEN'))];
        
        $this->pollId = $this->request->fromPOST('pid', [
            \fpcm\model\http\request::FILTER_CASTINT
        ]);
        
        if (!$this->pollId) {
            $this->response->setReturnData($this->returnData)->fetch();
        }

        if ($this->processByParam() === \fpcm\controller\abstracts\controller::ERROR_PROCESS_BYPARAMS) {
            return false;
        }

        usleep(500);

        $this->response->setReturnData($this->returnData)->fetch();
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
            $this->returnData = [
                'code' => -404,
                'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_REPLY')),
                'html' => ''
            ];

            return true;
        }
        
        if (!$poll->pushnewVote($replyIds)) {
            $this->returnData = [
                'code' => -101,
                'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_REPLY')),
                'html' => ''
            ];

            return true;
        }

        $this->returnData = [
            'code' => 100,
            'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_SUCCESS_REPLY')),
            'html' => (new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm()
        ];

        return true;
    }
    
    final protected function processResult()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {
            $this->returnData = ['code' => -404, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_POLL')), 'html' => ''];
            return true;
        }

        $this->returnData = [
            'code' => 300,
            'msg' => '',
            'html' => (new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm(true)
        ];

        return true;
    }
    
    final protected function processPollForm()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {
            $this->returnData = ['code' => -404, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_POLL'))];
            return true;
        }

        if (!$poll->isOpen()) {
            $this->returnData = ['code' => -401, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_CLOSED'))];
            return true;
        }

        $this->returnData = [
            'code' => 400,
            'msg' => '',
            'html' => $poll->hasVoted()
                    ? ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm()
                    : ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getVoteForm()
        ];

        return true;

    }
}
