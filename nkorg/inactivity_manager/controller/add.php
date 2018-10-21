<?php

namespace fpcm\modules\nkorg\inactivity_manager\controller;

final class add extends \fpcm\controller\abstracts\controller {

    use \fpcm\controller\traits\modules\tools;

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
        $this->obj = new \fpcm\modules\nkorg\inactivity_manager\models\message();

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

        if (!$this->obj->save()) {
            $this->obj->setStoptime(time() + FPCM_DATE_SECONDS);
            $this->view->addErrorMessage($this->addLangVarPrefix('MSGSAVE_FAILED'));
            return true;
        }
        
        $this->redirect('message/list', [
            'msg' => 1
        ]);
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
        $this->view->setFormAction('message/add');
        $this->view->render();
        return true;
    }

}
