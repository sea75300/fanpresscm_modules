<?php

namespace fpcm\modules\nkorg\polls\controller;

final class votelog extends \fpcm\controller\abstracts\module\controller {

    /**
     *
     * @var int
     */
    private $pollId;

    public function request()
    {
        $this->returnData = [];

        $this->pollId = $this->getRequestVar('pid', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);
        
        if (!$this->pollId) {
            return false;
        }

        return true;
    }
    
    final public function process()
    {
        $poll = new \fpcm\modules\nkorg\polls\models\poll($this->pollId);
        if (!$poll->exists()) {
            return false;
        }

        $voteLog = $poll->getVoteLog();
        if (!count($voteLog)) {
            print   (new \fpcm\view\helper\icon('list-ul '))->setSize('lg')->setStack(true)->setStack('ban fpcm-ui-important-text')->setStackTop(true).' '.
                    $this->language->translate('GLOBAL_NOTFOUND2');
            return true;
        }

        $replies = $poll->getReplies();

        /* @var $logEntry \fpcm\modules\nkorg\polls\models\vote_log */
        foreach ($voteLog as $logEntry) {
            
            /* @var $reply \fpcm\modules\nkorg\polls\models\poll_reply */
            $reply = $replies[$logEntry->getReplyid()] ?? false;
            if ($reply === false) {
                continue;
            }

            $this->addLine($logEntry->getId(), [
                '<div class="row my-1">',
                '<div class="col-4 align-self-center">'.$reply->getText(),
                '</div><div class="col-4 align-self-center">'.(string) new \fpcm\view\helper\dateText($logEntry->getReplytime()),
                '</div><div class="col-4 align-self-center">'.$logEntry->getIp(),
                '</div></div>'
            ]);            

        }

        exit(implode(PHP_EOL, $this->returnData));
    }
    
    private function addLine($index, array $line) : bool {
        $this->returnData[$index] = implode(PHP_EOL, $line);
        return true;
    }

}
