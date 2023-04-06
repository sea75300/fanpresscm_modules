<?php

namespace fpcm\modules\nkorg\inactivity_manager\controller;

class base extends \fpcm\controller\abstracts\module\controller implements \fpcm\controller\interfaces\requestFunctions {

    /**
     *
     * @var \fpcm\modules\nkorg\inactivity_manager\models\message
     */
    protected $obj;

    /**
     *
     * @var string
     */
    protected $modeStr = 'ADDMSG';

    /**
     *
     * @var int
     */
    protected $oid = 0;

    protected function getViewPath() : string
    {
        return 'editor';
    }

    public function request()
    {
        $this->obj = new \fpcm\modules\nkorg\inactivity_manager\models\message($this->oid ? $this->oid : null);
        return true;
    }
    
    public function process()
    {
        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $this->getModuleKey() . '/js/module.js')
        ]);

        $this->view->addButton(new \fpcm\view\helper\saveButton('save'));
        
        $this->view->addTabs('message', [
            (new \fpcm\view\helper\tabItem('main'))
                ->setText($this->addLangVarPrefix($this->modeStr))
                ->setModulekey($this->getModuleKey())
                ->setFile( \fpcm\view\view::PATH_MODULE . $this->getViewPath() )
        ]);

        $this->view->assign('obj', $this->obj);        
        $this->view->render();
        return true;
    }
    
    protected function onSave()
    {
        $msgData = $this->request->fetchAll('msg');
        if (!count($msgData)) {
            return true;
        }
       
        \fpcm\modules\nkorg\inactivity_manager\models\message::assignData($this->obj, $msgData);
        if ($this->obj->getStarttime() >= $this->obj->getStoptime()) {
            $this->obj->setStoptime(time() + FPCM_DATE_SECONDS);
            $this->view->addErrorMessage($this->addLangVarPrefix('MSGDATE_FROMTO'));
            return true;
        }

        $fn = $this->oid ? 'update' : 'save';
        if (!call_user_func([$this->obj, $fn])) {
            $this->obj->setStoptime(time() + FPCM_DATE_SECONDS);
            $this->view->addErrorMessage($this->addLangVarPrefix('MSGSAVE_FAILED'));
            return true;
        }
        
        if ($this->oid) {
            $this->view->addNoticeMessage($this->addLangVarPrefix('MSGSAVE_SUCCESS'));        
            return true;
        }

        $this->redirect('message/list', [
            'msg' => 1
        ]);
        
        return true;
    }

}
