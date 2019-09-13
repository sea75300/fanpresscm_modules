<?php

namespace fpcm\modules\nkorg\polls\controller;

class pollbase extends \fpcm\controller\abstracts\module\controller {

    /**
     *
     * @var \fpcm\modules\nkorg\polls\models\poll
     */
    protected $poll;

    protected function getViewPath() : string
    {
        return 'pollform';
    }
    
    public function process()
    {
        $this->view->addButtons([
            (new \fpcm\view\helper\saveButton('save')),
            (new \fpcm\view\helper\button('addReplyOption'))->setText('MODULE_NKORGPOLLS_GUI_ADD_REPLY')->setIcon('plus'),
        ]);

        $this->view->addJsLangVars([
            'MODULE_NKORGPOLLS_GUI_POLL_REPLY_TXT'
        ]);

        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $this->getModuleKey() . '/js/module.js')
        ]);

        $this->view->assign('poll', $this->poll);        
        $this->view->render();
        return true;
    }
    
    protected function save()
    {
        $data = $this->getRequestVar('polldata', [
            \fpcm\classes\http::FILTER_TRIM,
            \fpcm\classes\http::FILTER_STRIPTAGS,
            \fpcm\classes\http::FILTER_STRIPSLASHES
        ]);

        if (!is_array($data) || !count($data)) {
            $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_ERR_INSERTDATA');
            return false;
        }

        if (empty($data['text']) || empty($data['maxaw']) || empty($data['replies'])) {
            $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_ERR_INSERTDATA');
            return false;
        }
        
        $data['starttime'] = empty($data['starttime']) ? time() : strtotime($data['starttime']);
        $data['stoptime'] = empty($data['stoptime']) ? 0 : strtotime($data['stoptime']);
        $data['votessum'] = isset($data['votessum']) ? (int) $data['votessum'] : 0;

        $this->poll->setText($data['text'])
                    ->setMaxreplies((int) $data['maxaw'])
                    ->setStarttime((int) $data['starttime'])
                    ->setStoptime((int) $data['stoptime'])
                    ->setVotessum((int) $data['votessum'])
                    ->setVoteExpiration((int) $data['voteexpiration'])
                    ->setIsclosed(isset($data['closed']) && $data['closed'])
                    ->setShowarchive(isset($data['inarchive']) && $data['inarchive']);

        if (!$this->poll->getId()) {

            $this->poll->setCreatetime(time())->setCreateuser($this->session->getUserId());

            if (!$this->poll->save()) {
                $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_ERR_SAVEPOLL');
                return false;
            }

            if (!$this->poll->addReplies($data['replies'])) {
                $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_ERR_SAVEREPLY');
                return false;
            }

            return true;
        }

        if (!$this->poll->updateReplies($data['ids'], $data['replies'], $data['sums'])) {
            $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_ERR_UPDATEREPLY');
            return false;
        }
        
        if (!$this->poll->update()) {
            $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_ERR_UPDATEPOLL');
            return false;
        }

        return true;
    }

}
