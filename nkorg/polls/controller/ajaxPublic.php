<?php

namespace fpcm\modules\nkorg\polls\controller;

final class ajaxPublic extends \fpcm\controller\abstracts\module\ajaxController {

    /**
     *
     * @var int
     */
    private $pollId;

    public function request()
    {
        $this->returnData = ['code' => 0, 'msg' => 'nofound'];

        $fn = 'process'.$this->getRequestVar('fn', [
            \fpcm\classes\http::FILTER_FIRSTUPPER
        ]);
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }
        
        $this->pollId = $this->getRequestVar('pid', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$this->pollId) {
            $this->getSimpleResponse();
        }
        
        call_user_func([$this, $fn]);
        $this->getSimpleResponse();

        return true;
    }
    
    final protected function processVote()
    {
        $replyIds = $this->getRequestVar('rids', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);

        if (!count($replyIds)) {
            return false;
        }
        
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {
            $this->getSimpleResponse();
        }

        if (!$poll->pushnewVote($replyIds)) {
            $this->returnData = ['code' => -100, 'msg' => 'Die Antwort konnte nicht gespeichert werden, bitte versuche es später noch einmal.'];
            $this->getSimpleResponse();
        }

        $this->returnData = ['code' => 100, 'msg' => 'Vielen Dank für deine Antwort!'];
        $this->getSimpleResponse();
    }

    public function hasAccess()
    {
        return true;
    }
}
