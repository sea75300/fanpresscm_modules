<?php

namespace fpcm\modules\nkorg\polls\controller;

final class polllist extends \fpcm\controller\abstracts\module\controller {

    use \fpcm\controller\traits\common\dataView;
    
    protected function getViewPath() : string
    {
        return 'index';
    }

    public function process()
    {
        $this->deletePoll();
        
        $key = $this->getModuleKey();

        $this->view->addButtons([
            (new \fpcm\view\helper\linkButton('pollAdd'))->setText('Umfrage erstellen')->setIcon('plus')->setUrl(\fpcm\classes\tools::getControllerLink('polls/add')),
            (new \fpcm\view\helper\submitButton('pollClose'))->setText('Umfrage schließen')->setIcon('lock'),
            (new \fpcm\view\helper\deleteButton('pollDelete'))
        ]);
        
        $this->view->addJsVars([
            'polls' => []
        ]);
        
        $this->view->addJslangVars([$this->addLangVarPrefix('HITS_LIST_LATEST')]);
        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $key . '/js/module.js')
        ]);
        
        $this->items = (new \fpcm\modules\nkorg\polls\models\polls())->getAllPolls();
        $this->initDataView();

        $this->view->setFormAction('polls/list');
        $this->view->render();
        return true;
    }
    
    private function deletePoll() : bool {
        
        if (!$this->buttonClicked('pollDelete')) {
            return true;
        }

        $id = $this->getRequestVar('id', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$id) {
            return false;
        }

        $poll = new \fpcm\modules\nkorg\polls\models\poll($id);
        if (!$poll->exists()) {
            $this->view->addErrorMessage('Die gewählte Umfrage wurde nicht gefunden!');
            return false;
        }

        if (!$poll->delete()) {
            $this->view->addErrorMessage('Die gewählte Umfrage konnte nicht gelöscht werden!');
            return false;
        }

        return true;
    }

    protected function getDataViewCols(): array {

        return [
            (new \fpcm\components\dataView\column('select', ''))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('button', ''))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('name', 'Umfrage'))->setSize(4),
            (new \fpcm\components\dataView\column('time', 'Zeitraum'))->setSize(4)->setAlign('center'),
            (new \fpcm\components\dataView\column('status', 'Status'))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('votes', 'Stimmen'))->setSize(1)->setAlign('center'),
        ];

    }

    protected function getDataViewName() {
        return 'nkorgpolls';
    }
    
    /**
     * 
     * @param \fpcm\modules\nkorg\polls\models\poll $poll
     * @return \fpcm\components\dataView\row
     */
    protected function initDataViewRow($poll)
    {
        $time = new \fpcm\view\helper\dateText($poll->getStarttime(), 'd.m.Y');
        
        if ($poll->getStoptime()) {
            $time .= ' bis '.new \fpcm\view\helper\dateText($poll->getStoptime(), 'd.m.Y');
        }

        return new \fpcm\components\dataView\row([
            new \fpcm\components\dataView\rowCol('select', (new \fpcm\view\helper\radiobutton('id', 'chbx' . $poll->getId()))->setValue($poll->getId()), '', \fpcm\components\dataView\rowCol::COLTYPE_ELEMENT),
            new \fpcm\components\dataView\rowCol('button', (new \fpcm\view\helper\editButton('edit'))->setUrlbyObject($poll) ),
            new \fpcm\components\dataView\rowCol('name', $poll->getText() ),
            new \fpcm\components\dataView\rowCol('time', $time ),
            new \fpcm\components\dataView\rowCol('status', $poll->getIsclosed() ? 'geschlossen' : 'offen' ),
            new \fpcm\components\dataView\rowCol('votes', $poll->getVotessum() ),
        ]);
    }


}
