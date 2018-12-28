<?php

namespace fpcm\modules\nkorg\inactivity_manager\controller;

final class edit extends \fpcm\controller\abstracts\module\controller {

    /**
     *
     * @var \fpcm\modules\nkorg\inactivity_manager\models\message
     */
    protected $obj;

    protected function getViewPath() : string
    {
        return 'index';
    }

    public function request()
    {
        $id = $this->getRequestVar('id', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$id) {
            $this->view = new \fpcm\view\error($this->addLangVarPrefix('MSGSAVE_NOTFOUND'));
            $this->view->render();
            exit;
        }
        
        $this->obj = new \fpcm\modules\nkorg\inactivity_manager\models\message($id);
        if (!$this->obj->exists()) {
            $this->view = new \fpcm\view\error($this->addLangVarPrefix('MSGSAVE_NOTFOUND'));
            $this->view->render();
            exit;
        }

        $msgData = $this->getRequestVar('msg');
        if (!$this->buttonClicked('save') || !count($msgData)) {
            return true;
        }

        \fpcm\modules\nkorg\inactivity_manager\models\message::assignData($this->obj, $msgData);
        if ($this->obj->getStarttime() >= $this->obj->getStoptime()) {
            $this->obj->setStoptime(time() + FPCM_DATE_SECONDS);
            $this->view->addErrorMessage($this->addLangVarPrefix('MSGDATE_FROMTO'));
            return true;
        }

        if (!$this->obj->update()) {
            $this->obj->setStoptime(time() + FPCM_DATE_SECONDS);
            $this->view->addErrorMessage($this->addLangVarPrefix('MSGSAVE_FAILED'));
            return true;
        }
        
        $this->view->addNoticeMessage($this->addLangVarPrefix('MSGSAVE_SUCCESS'));
        return true;
    }
    
    public function process()
    {
        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $this->getModuleKey() . '/js/module.js')
        ]);

        $this->view->addButton(new \fpcm\view\helper\saveButton('save'));
        $this->view->setViewVars([
            'modeStr' => 'ADDMSG',
            'obj' => $this->obj
        ]);
        $this->view->setFormAction('message/edit', [
            'id' => $this->obj->getId()
        ]);
        $this->view->render();
        return true;
    }

}
