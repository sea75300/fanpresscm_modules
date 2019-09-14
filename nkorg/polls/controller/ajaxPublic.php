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
        $this->returnData = ['code' => 0, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_GEN'))];

        $fn = 'process'.$this->getRequestVar('fn', [
            \fpcm\classes\http::FILTER_FIRSTUPPER
        ]);

        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }
        
        $this->pollId = $this->getRequestVar('pid', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$this->pollId) {
            $this->getSimpleResponse();
        }
        
        
        call_user_func([$this, $fn]);
        usleep(500);

        $this->getSimpleResponse();
        return true;
    }

    public function hasAccess()
    {
        return true;
    }
    
    final protected function processVote()
    {
        $replyIds = $this->getRequestVar('rids', [
            \fpcm\classes\http::FILTER_CASTINT
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
            $this->getSimpleResponse();
        }
        
        if (!$poll->pushnewVote($replyIds)) {
            $this->returnData = [
                'code' => -101,
                'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_REPLY')),
                'html' => ''
            ];

            $this->getSimpleResponse();
        }

        $this->returnData = [
            'code' => 100,
            'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_SUCCESS_REPLY')),
            'html' => (new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm()
        ];

    }
    
    final protected function processResult()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {
            $this->returnData = ['code' => -404, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_POLL')), 'html' => ''];
            $this->getSimpleResponse();
        }

        $this->returnData = [
            'code' => 300,
            'msg' => '',
            'html' => (new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm(true)
        ];

    }
    
    final protected function processPollForm()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {
            $this->returnData = ['code' => -404, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_POLL'))];
            $this->getSimpleResponse();
        }

        if (!$poll->isOpen()) {
            $this->returnData = ['code' => -401, 'msg' => $this->language->translate($this->addLangVarPrefix('MSG_PUB_ERRCODE_CLOSED'))];
            $this->getSimpleResponse();
        }

        $this->returnData = [
            'code' => 400,
            'msg' => '',
            'html' => $poll->hasVoted()
                    ? ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm()
                    : ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getVoteForm()
        ];

    }
}
