<?php

namespace fpcm\modules\nkorg\polls\events;

use fpcm\classes\loader;

final class apiCallFunction extends \fpcm\module\event {

    public function run()
    {
        $fn = $this->data['name'];
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }

        call_user_func([$this, $fn],$this->data['args'][0]);
        return true;
    }

    public function init()
    {
        return true;
    }
    
    private function getViewObj()
    {
        $key = \fpcm\module\module::getKeyFromClass(get_called_class());

        $view = new \fpcm\view\view('publicform', $key);
        //$view->showHeaderFooter(\fpcm\view\view::INCLUDE_HEADER_NONE);
        $view->showHeaderFooter(\fpcm\view\view::INCLUDE_HEADER_SIMPLE);
        $view->assign('pollJsFile', \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $key . '/js/fpcm-polls-pub.js'));
        return $view;
    }

    final protected function displayPoll($pollId = 0)
    {
        if (!$pollId) {
            return false;
        }
        
        $poll = new \fpcm\modules\nkorg\polls\models\poll($pollId);
        if (!$poll->exists()) {
            print "Die ausgewählte Umfrage wurde nicht gefunden.";
            return false;
        }

        if (!$poll->isOpen()) {
            $content = "Die ausgewählte Umfrage wurde geschlossen oder beendet.";
        }
        elseif ($poll->hasVoted()) {
            $content = "Du hast bei dieser Umfrage bereits abgestimmt.";
        }
        else {
            $content = ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getVoteForm();
        }

        $view = $this->getViewObj();
        $view->assign('pollId', $poll->getId() );
        $view->assign('content', $content);
        $view->assign('pollJsVars', [ ]);
        $view->render();
        return true;
    }

    final protected function displayArchive($pollId = 0)
    {

        return true;
    }

}