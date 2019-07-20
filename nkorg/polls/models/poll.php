<?php

namespace fpcm\modules\nkorg\polls\models;

class poll extends dbObj {

    protected $table = 'module_nkorgpolls_polls';
    protected $text = '';
    protected $maxreplies = 1;
    protected $isclosed = 0;
    protected $showarchive = 0;
    protected $starttime = 0;
    protected $stoptime = 0;
    protected $createtime = 0;
    protected $createuser = 0;

    public function getText() {
        return $this->text;
    }

    public function getMaxreplies() {
        return (int) $this->maxreplies;
    }

    public function getIsclosed() {
        return (bool) $this->isclosed;
    }

    public function getShowarchive() {
        return (bool) $this->showarchive;
    }

    public function getStarttime() {
        return (int) $this->starttime;
    }

    public function getStoptime() {
        return (int) $this->stoptime;
    }

    public function getCreatetime() {
        return (int) $this->createtime;
    }

    public function getCreateuser() {
        return (int) $this->createuser;
    }

    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    public function setMaxreplies(int $maxreplies) {
        $this->maxreplies = $maxreplies;
        return $this;
    }

    public function setIsclosed($isclosed) {
        $this->isclosed = (int) $isclosed;
        return $this;
    }

    public function setShowarchive($showarchive) {
        $this->showarchive = (int) $showarchive;
        return $this;
    }

    public function setStarttime(int $starttime) {
        $this->starttime = $starttime;
        return $this;
    }

    public function setStoptime(int $stoptime) {
        $this->stoptime = $stoptime;
        return $this;
    }

    public function setCreatetime(int $createtime) {
        $this->createtime = $createtime;
        return $this;
    }

    public function setCreateuser(int $createuser) {
        $this->createuser = $createuser;
        return $this;
    }

    final public function addReplies(array $replies) {
        
        if (!$replies) {
            return false;
        }

        foreach ($replies as $reply) {
            $obj = new poll_reply();
            $obj->setPollid($this->getId())->setText($reply)->setCreatetime($this->getCreatetime())->setCreateuser($this->getCreateuser());
            if (!$obj->save()) {
                trigger_error('Unable to save reply "'.$reply.'" for poll "'.$this->getText().'"!');
                return false;
            }

        }
        
        return true;
    }

    public function getEditLink() {
        return \fpcm\classes\tools::getControllerLink('polls/edit', [
            'id' => $this->getId()
        ]);
    }

}
