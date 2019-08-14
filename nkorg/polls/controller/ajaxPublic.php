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
            $this->returnData = ['code' => 0, 'msg' => 'nofound'];
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
            $this->returnData = ['code' => 0, 'msg' => 'noreplies'];
            return false;
        }
        
        fpcmLogSystem([
            __METHOD__,
            $this->pollId,
            $replyIds
        ]);
        
//        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        
//        array_walk($replyIds, function ($replyId) {
//
//
//        });
        
    }

    public function hasAccess()
    {
        return true;
    }
}
