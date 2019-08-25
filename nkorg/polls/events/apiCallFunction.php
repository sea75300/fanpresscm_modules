<?php

namespace fpcm\modules\nkorg\polls\events;

use fpcm\classes\loader;

final class apiCallFunction extends \fpcm\module\event {

    private $jsVars = [];

    public function run()
    {
        $fn = $this->data['name'];
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }

        $pollId = $this->data['args'][0] ?? 0;
        call_user_func([$this, $fn], $pollId);
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
        $this->jsVars['pollspub']['spinner'] = \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $key . '/js/spinner.gif');
        $view->assign('pollJsVars', $this->jsVars);
        return $view;
    }

    final public function displayPoll($pollId = 0)
    {
        $showLatest = loader::getObject('\fpcm\model\system\config')->module_nkorgpolls_show_latest_poll;
        if (!$pollId && $showLatest) {
            $pollId = (new \fpcm\modules\nkorg\polls\models\polls())->getLatestPoll();
        }

        if (!$pollId) {
            return false;
        }

        $poll = new \fpcm\modules\nkorg\polls\models\poll($pollId);
        if (!$poll->exists()) {
            print "Die ausgewählte Umfrage wurde nicht gefunden.";
            return false;
        }

        if (!$poll->isOpen() || $poll->hasVoted()) {
            $content = ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getResultForm();
        }
        else {
            $content = ( new \fpcm\modules\nkorg\polls\models\pollform($poll))->getVoteForm();
        }

        $view = $this->getViewObj();
        $view->assign('pollId', $poll->getId() );
        $view->assign('content', $content);
        $view->render();
        return true;
    }

    final protected function displayArchive($pollId = 0)
    {
        return true;
    }

}