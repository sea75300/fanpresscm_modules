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
        $key = $this->getModuleKey();

        $this->view->addButtons([
            (new \fpcm\view\helper\saveButton('save')),
            (new \fpcm\view\helper\button('addReplyOption'))->setText('Antwort hinzufügen')->setIcon('plus'),
        ]);
        
        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $key . '/js/module.js')
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
            $this->view->addErrorMessage('Bitte fülle das Formular zum Erstellen der Umfrage aus!');
            return false;
        }

        if (empty($data['text']) || empty($data['maxaw']) || empty($data['replies'])) {
            $this->view->addErrorMessage('Bitte fülle das Formular zum Erstellen der Umfrage aus!');
            return false;
        }
        
        $data['starttime'] = empty($data['starttime']) ? time() : strtotime($data['starttime']);
        $data['stoptime'] = empty($data['stoptime']) ? 0 : strtotime($data['stoptime']);

        $this->poll->setText($data['text'])
                    ->setMaxreplies((int) $data['maxaw'])
                    ->setStarttime((int) $data['starttime'])
                    ->setStoptime((int) $data['stoptime'])
                    ->setIsclosed(isset($data['closed']))
                    ->setShowarchive(isset($data['inarchive']));

        if (!$this->poll->getId()) {
            $this->poll->setCreatetime(time())
                       ->setCreateuser($this->session->getUserId());
        }

        $saveFn = $this->poll->getId() ? 'update' : 'save';
        if (!call_user_func([$this->poll, $saveFn])) {
            $this->view->addErrorMessage('Fehler beim Speichern der Umfrage!');
            return false;
        }
        
        if ($saveFn === 'save' && !$this->poll->addReplies($data['replies'])) {
            $this->view->addErrorMessage('Fehler beim Speichern der Umfrage, eine Antwort konnte nicht gespeichert werden!');
            return false;
        }
        
        return true;
    }

}
