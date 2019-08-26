<?php

namespace fpcm\modules\nkorg\polls\models;

class polls extends \fpcm\model\abstracts\tablelist {

    protected $table = 'module_nkorgpolls_polls';

    public function getAllPolls($force = false)
    {
        if (isset($this->data[__FUNCTION__]) && !$force) {
            return $this->data[__FUNCTION__];
        }

        return $this->getResultFromDB(__FUNCTION__, 'id > 0');
    }

    public function getLatestPoll()
    {
        if (isset($this->data[__FUNCTION__])) {
            return $this->data[__FUNCTION__];
        }

        $params = (new \fpcm\model\dbal\selectParams($this->table))
                ->setItem('id')
                ->setWhere( 'isclosed = 0 AND stoptime >= ? '.$this->dbcon->orderBy(['starttime DESC']).' '.$this->dbcon->limitQuery(1, 0) )
                ->setParams([ time() ]);
        
        $result = $this->dbcon->selectFetch($params);
        return (int) ($result->id ?? 0);
    }

    public function getArchivedPolls($force = false)
    {
        if (isset($this->data[__FUNCTION__]) && !$force) {
            return $this->data[__FUNCTION__];
        }

        return $this->getResultFromDB(__FUNCTION__, 'showarchive = 1 AND isclosed = 1 AND (stoptime > 0 OR stoptime <= ?)', [
            time()
        ]);
    }

    private function getResultFromDB($cache, string $where, array $params = [])
    {
        $params = (new \fpcm\model\dbal\selectParams($this->table))
                ->setFetchAll(true)
                ->setWhere($where)
                ->setParams($params);
        
        $result = $this->dbcon->selectFetch($params);
        if (!is_array($result) || !count($result)) {
            return [];
        }

        foreach ($result as $data) {
            
            $obj = new poll();
            $obj->createFromDbObject($data);
            $this->data[$cache][$obj->getId()] = $obj;
        }

        return $this->data[$cache];
    }
    
    

}
