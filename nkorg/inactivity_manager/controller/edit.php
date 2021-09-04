<?php

namespace fpcm\modules\nkorg\inactivity_manager\controller;

final class edit extends base {

    /**
     *
     * @var string
     */
    protected $modeStr = 'EDITMSG';

    public function request()
    {
        $this->oid = $this->request->getID();
        
        if (!$this->oid) {
            $this->view = new \fpcm\view\error($this->addLangVarPrefix('MSGSAVE_NOTFOUND'));
            $this->view->render();
            exit;
        }

        parent::request();
        
        if ($this->obj->exists()) {
            return true;
        }

        $this->view = new \fpcm\view\error($this->addLangVarPrefix('MSGSAVE_NOTFOUND'));
        $this->view->render();
        exit;
    }
    
    public function process()
    {
        $this->view->setFormAction('message/edit', [
            'id' => $this->obj->getId()
        ]);
        
        parent::process();
    }

}
