<?php

namespace fpcm\modules\nkorg\calendar\controller;

final class polladd extends base {

    public function request()
    {
        $this->poll = new \fpcm\modules\nkorg\calendar\models\poll();
        if ($this->buttonClicked('save') && $this->save()) {
            $this->redirect('polls/edit', [
                'id' => $this->poll->getId()
            ]);
        }

        return true;
    }

    public function process()
    {
        $this->poll->setVoteExpiration($this->config->module_nkorgpolls_vote_expiration_default);
        $this->poll->setStarttime(time());   
        $this->view->setFormAction('polls/add');

        $replies = $this->poll->getReplies(true);
        $this->view->assign('replies', $replies);
        $this->view->addJsVars([
            'replyOptionsStart' => count($replies)
        ]);        
        
        parent::process();
    }

}
