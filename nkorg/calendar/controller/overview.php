<?php

namespace fpcm\modules\nkorg\calendar\controller;

final class overview extends \fpcm\controller\abstracts\module\controller {

    use \fpcm\controller\traits\common\dataView,
        \fpcm\module\tools;

    public function process()
    {
        $this->delete();

        $this->view->addButtons([
            (new \fpcm\view\helper\linkButton('appointmentAdd'))->setText($this->addLangVarPrefix('GUI_ADD_POLL'))->setIcon('plus')->setUrl(\fpcm\classes\tools::getControllerLink('calendar/add')),
            (new \fpcm\view\helper\deleteButton('appointmentDelete')),
        ]);
        
        $this->view->addJsVars([
            'polls' => [],
        ]);

        $this->view->addJsFiles([
            \fpcm\module\module::getJsDirByKey($this->getModuleKey(), 'module.js')
        ]);

        $this->items = (new \fpcm\modules\nkorg\calendar\models\appointments)->getAppointments();
        $this->initDataView();

        $this->view->setFormAction('calendar/overview');
        $this->view->render();
        return true;
    }
    
    private function delete() : bool {
        
        if (!$this->buttonClicked('appointmentDelete')) {
            return true;
        }

        $id = $this->getRequestVar('id', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$id) {
            return false;
        }

        $appointment = new \fpcm\modules\nkorg\calendar\models\appointment($id);
        if (!$appointment->exists()) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_PUB_NOTFOUND'));
            return false;
        }

        if (!$appointment->delete()) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSG_ERR_DELETEPOLL'));
            return false;
        }

        return true;
    }

    protected function getDataViewCols(): array {

        return [
            (new \fpcm\components\dataView\column('select', ''))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('button', ''))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('name', $this->addLangVarPrefix('GUI_POLL_TEXT')))->setSize(4),
            (new \fpcm\components\dataView\column('time', $this->addLangVarPrefix('GUI_POLL_TIMESPAN')))->setSize(4)->setAlign('center'),
            (new \fpcm\components\dataView\column('status', $this->addLangVarPrefix('GUI_POLL_STATE')))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('votes', $this->addLangVarPrefix('GUI_POLL_VOTES')))->setSize(1)->setAlign('center'),
        ];

    }
    
    /**
     * 
     * @param \fpcm\modules\nkorg\calendar\models\poll $appointment
     * @return \fpcm\components\dataView\row
     */
    protected function initDataViewRow($appointment)
    {
        $time = new \fpcm\view\helper\dateText($appointment->getStarttime(), 'd.m.Y');

        if ($appointment->getStoptime()) {
            $time .= ' bis '.new \fpcm\view\helper\dateText($appointment->getStoptime(), 'd.m.Y');
        }

        return new \fpcm\components\dataView\row([
            new \fpcm\components\dataView\rowCol('select', (new \fpcm\view\helper\radiobutton('id', 'chbx' . $appointment->getId()))->setValue($appointment->getId()), '', \fpcm\components\dataView\rowCol::COLTYPE_ELEMENT),
            new \fpcm\components\dataView\rowCol('button', (new \fpcm\view\helper\editButton('edit'))->setUrlbyObject($appointment) ),
            new \fpcm\components\dataView\rowCol('name', $appointment->getText() ),
            new \fpcm\components\dataView\rowCol('time', $time ),
            new \fpcm\components\dataView\rowCol('status', $this->language->translate($this->addLangVarPrefix('POLL_STATUS'.(int) $appointment->getIsclosed()))),
            new \fpcm\components\dataView\rowCol('votes', $appointment->getVotessum() ? $appointment->getVotessum() : 0 ),
        ]);
    }

    protected function getDataViewName() {
        return 'nkorgcalendar';
    }


}
