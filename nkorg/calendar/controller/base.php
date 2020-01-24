<?php

namespace fpcm\modules\nkorg\calendar\controller;

class base extends \fpcm\controller\abstracts\module\controller {

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

        $this->view->addTabs('calendar', [
            (new \fpcm\view\helper\tabItem('appointmentform'))->setText('Termin')->setFile('templates/appointmentform.php')
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
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERR_INSERTDATA'));
            return false;
        }

        if (empty($data['description']) || empty($data['datetime'])) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERR_INSERTDATA'));
            return false;
        }

        $this->appointment
                ->setDescription($data['description'])
                ->setDatetime(strtotime($data['datetime']))
                ->setPending($data['pending'] ?? 0)
                ->setVisible($data['visible'] ?? 0);

        if (!$this->appointment->getId()) {

            $this->appointment->setCreatetime(time())->setCreateuser($this->session->getUserId());

            if (!$this->appointment->save()) {
                $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERR_SAVEPOLL'));
                return false;
            }

            if (!$this->appointment->addReplies($data['replies'])) {
                $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERR_SAVEREPLY'));
                return false;
            }

            return true;
        }
        
        if (!$this->appointment->update()) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERR_UPDATEPOLL'));
            return false;
        }

        return true;
    }

}
