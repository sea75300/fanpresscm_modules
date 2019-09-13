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
            $this->view->addErrorMessage('MODULE_NKORGPOLLS_MSG_PUB_NOTFOUND');
        }
        
        if ($this->buttonClicked('save') && $this->save()) {
            $this->view->addNoticeMessage('MODULE_NKORGPOLLS_MSG_SUCCESS_SAVEPOLL');
            return true;
        }
        
        return true;
    }

    public function process()
    {
        $this->view->setFormAction('polls/edit&id='.$this->poll->getId());
        
        $replies = $this->poll->getReplies();
        $this->view->assign('replies', $replies);
        $this->view->addJsVars([
            'replyOptionsStart' => count($replies),
            'pollChartData' => $this->getChartData()
        ]);
        
        parent::process();
    }
    
    private function getChartData()
    {
        if (!$this->poll->getId()) {
            return null;
        }

        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $this->getModuleKey() . '/js/chart.min.js'),
        ]);

        $labels = [];
        $data = [];
        $colors = [];

        /* @var $reply \fpcm\modules\nkorg\polls\models\poll_reply */
        foreach ($this->poll->getReplies() as $reply) {
            
            $labels[] = $reply->getText().' ('.$reply->getPercentage($this->poll->getVotessum()).'%)';
            $data[] = $reply->getVotes();
            $colors[] = $this->getRandomColor();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => $this->poll->getText(),
                    'fill' => true,
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => '#000',
                    'borderWidth' => 0
                ]
            ]
        ];
    }

    private function getRandomColor()
    {
        $colStr = '#' . dechex(mt_rand(0, 255)) . dechex(mt_rand(0, 255)) . dechex(mt_rand(0, 255));
        return strlen($colStr) === 7 ? $colStr : str_pad($colStr, 7, dechex(mt_rand(0, 16)));
    }

}
