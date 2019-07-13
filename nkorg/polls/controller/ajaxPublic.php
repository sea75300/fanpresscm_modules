<?php

namespace fpcm\modules\nkorg\polls\controller;

final class deleteentry extends \fpcm\controller\abstracts\module\ajaxController {

    /**
     *
     * @var int
     */
    private $pollId;

    public function request()
    {
        $fn = 'process'.$this->getRequestVar('fn');
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }
        
        $this->pollId = $this->getRequestVar('pollid', [
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
    
    final protected function vote()
    {
        $replyIds = $this->getRequestVar('replyIds', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);

        if (!count($replyIds)) {
            $this->returnData = ['code' => 0, 'msg' => 'noreplies'];
            return false;
        }
        
        array_walk($replyIds, function ($replyId) {


        });
        
    }

    public function hasAccess()
    {
        return true;
    }
}
