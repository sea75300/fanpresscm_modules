<?php

namespace fpcm\modules\nkorg\polls\models;

class poll extends dbObj {

    protected $table = 'module_nkorgpolls_polls';
    protected $text = '';
    protected $maxreplies = 1;
    protected $isclosed = 0;
    protected $showarchive = 0;
    protected $votessum = 0;
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

    public function getVotessum() {
        return (int) $this->votessum;
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

    public function setVotessum($votessum) {
        $this->votessum = (int) $votessum;
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

    public function getEditLink() {
        return \fpcm\classes\tools::getControllerLink('polls/edit', [
            'id' => $this->getId()
        ]);
    }
    
    public function delete() {
        
        if (!$this->dbcon->delete('module_nkorgpolls_polls_replies', 'pollid = ?', [$this->getId()])) {
            return false;
        }

        if (!$this->dbcon->delete('module_nkorgpolls_vote_log', 'pollid = ?', [$this->getId()])) {
            return false;
        }

        if (!parent::delete()) {
            return false;
        }

        return true;
    }

    final public function addReplies(array $replies) {

        if (!$replies) {
            return false;
        }

        foreach ($replies as $reply) {
            
            if (!trim($reply)) {
                continue;
            }

            $obj = new poll_reply();
            $obj->setPollid($this->getId())->setText($reply)->setCreatetime($this->getCreatetime())->setCreateuser($this->getCreateuser());
            if (!$obj->save()) {
                trigger_error('Unable to save reply "'.$reply.'" for poll "'.$this->getText().'"!');
                return false;
            }

        }
        
        return true;
    }

    final public function updateReplies(array $replyIds, array $replies, array $sums = []) {

        if (!count($replyIds) || !count($replies)) {
            return false;
        }
        
        $replyIds = array_map('intval', $replyIds);
        $sums = array_map('intval', $sums);

        $addedRepliues = [];
        foreach ($replyIds as $i => $id) {
            
            $reply = $replies[$i] ?? false;
            $sum = $sums[$i] ?? 0;
            if (!trim($reply)) {
                continue;
            }
            
            if (!$id) {
                $addedRepliues[] = $reply;
                continue;
            }

            $obj = new poll_reply($id);
            $obj->setText(trim($reply));            
            $obj->setVotes($sum);
            if (!$obj->update()) {
                trigger_error('Unable to update reply "'.$reply.'" for poll "'.$this->getText().'"!');
                return false;
            }
        }
        
        $res = $this->dbcon->delete(
            'module_nkorgpolls_polls_replies', 'pollid = ? AND id NOT IN ('. implode(', ', array_fill(0, count($replyIds), '?')).')',
            array_merge([$this->getId()], $replyIds)        
        );
        
        if (!$res) {
            trigger_error('Unable to remove deleted replies from poll "'.$this->getText().'"!');
            return false;
        }

        $this->addReplies($addedRepliues);
        return true;
    }
    
    final public function getReplies($empty = false) {
        
        if ($empty) {

            $r1 = new poll_reply();
            $r1->setId(1);
            $r2 = new poll_reply();
            $r2->setId(2);
            $r3 = new poll_reply();
            $r3->setId(3);
            
            return [$r1, $r2, $r3];
        }
        
        if (isset($this->data[__FUNCTION__])) {
            return $this->data[__FUNCTION__];
        }
        
        $obj = (new \fpcm\model\dbal\selectParams('module_nkorgpolls_polls_replies'))
                ->setWhere('pollid = ? ' . $this->dbcon->orderBy(['id ASC']))
                ->setParams([$this->getId()])
                ->setFetchAll(true);
        
        $replies = $this->dbcon->selectFetch($obj);

        if (!$replies) {
            return [];
        }

        foreach ($replies as $reply) {
            $obj = new poll_reply();
            $obj->createFromDbObject($reply);
            $this->data[__FUNCTION__][] = $obj;
        }

        return $this->data[__FUNCTION__];
    }

}
