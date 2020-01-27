<?php

namespace fpcm\modules\nkorg\calendar\controller;

final class EDIT extends base {

    public function request()
    {
        $id = $this->getRequestVar('id', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$id) {
            return false;
        }

        $this->appointment = new \fpcm\modules\nkorg\calendar\models\appointment($id);
        if (!$this->appointment->exists()) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERROR_NOTFOUND'));
        }
        
        if ($this->buttonClicked('save') && $this->save()) {
            $this->view->addNoticeMessage($this->addLangVarPrefix('MSG_SUCCESS_SAVE'));
            return true;
        }
        
        return true;
    }

    public function process()
    {
        $this->view->addButtons([
            (new \fpcm\view\helper\linkButton('backList'))->setUrl(\fpcm\classes\tools::getControllerLink('calendar/overview')) ->setText($this->addLangVarPrefix('GUI_GOtO_OVERVIEW'))->setIcon('arrow-circle-left'),
        ]);

        $this->view->setFormAction('calendar/edit&id='.$this->appointment->getId());

        parent::process();
    }

}
