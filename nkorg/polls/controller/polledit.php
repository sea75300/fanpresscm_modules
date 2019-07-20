<?php

namespace fpcm\modules\nkorg\polls\controller;

final class polledit extends pollbase {

    public function request()
    {
        $id = $this->getRequestVar('id', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$id) {
            return false;
        }

        $this->poll = new \fpcm\modules\nkorg\polls\models\poll($id);
        if (!$this->poll->exists()) {
            return false;
        }
        
        if ($this->buttonClicked('save') && !$this->save()) {
            return true;
        }
        
        $this->view->addNoticeMessage('Änderungen gespeichert!');
        return true;
    }

    public function process()
    {
        $this->view->setFormAction('polls/edit&id='.$this->poll->getId());        
        parent::process();
    }

}
