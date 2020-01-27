<?php

namespace fpcm\modules\nkorg\calendar\controller;

class base extends \fpcm\controller\abstracts\module\controller implements \fpcm\controller\interfaces\isAccessible {

    /**
     *
     * @var \fpcm\modules\nkorg\calendar\models\appointment
     */
    protected $appointment;
    
    public function process()
    {
        $this->view->addButton(new \fpcm\view\helper\saveButton('save'));

        $this->view->addJsLangVars([
            $this->addLangVarPrefix('GUI_POLL_REPLY_TXT')
        ]);

        $this->view->addJsFiles([
            \fpcm\module\module::getJsDirByKey($this->getModuleKey(), 'module.js')
        ]);

        $this->view->assign('appointment', $this->appointment);        
        $this->view->render();
        return true;
    }
    
    protected function save()
    {
        $data = $this->getRequestVar('appointmentdata', [
            \fpcm\classes\http::FILTER_TRIM,
            \fpcm\classes\http::FILTER_STRIPTAGS,
            \fpcm\classes\http::FILTER_STRIPSLASHES
        ]);
        
        if (!is_array($data) || !count($data)) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERROR_INSERTDATA'));
            return false;
        }

        if (empty($data['description']) || empty($data['date']) || empty($data['time'])) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERROR_INSERTDATA'));
            return false;
        }

        $data['datetime'] = strtotime($data['date'].' '.$data['time']);
        if ($data['datetime'] === false || date('Y-m-d H:s', $data['datetime']) !== $data['date'].' '.$data['time']) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERROR_INSERTDATA'));
            return false;
        }

        $this->appointment
                ->setDescription($data['description'])
                ->setDatetime($data['datetime'])
                ->setPending($data['pending'] ?? 0)
                ->setVisible($data['visible'] ?? 0);

        if (!$this->appointment->getId()) {

            $this->appointment->setCreatetime(time())->setCreateuser($this->session->getUserId());

            if (!$this->appointment->save()) {
                $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERROR_SAVE'));
                return false;
            }

            return true;
        }
        
        if (!$this->appointment->update()) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERROR_SAVE'));
            return false;
        }

        return true;
    }

    public function isAccessible(): bool
    {
        return true;
    }
    
    protected function getViewPath() : string
    {
        return 'editor';
    }

}
