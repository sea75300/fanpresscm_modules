<?php

namespace fpcm\modules\nkorg\extstats\models;

class countLink extends dbObj {

    protected $table = 'module_nkorgextstats_counts_links';

    protected $url = '';
    protected $urlhash = '';
    protected $counthits = 0;
    protected $lasthit = 0;

    public function __construct()
    {
        parent::__construct();
        $this->url = $_SERVER['REQUEST_URI'];
        $this->urlhash = \fpcm\classes\tools::getHash($this->url);
        $this->init();
    }
    
    public function init()
    {
        $data = $this->dbcon->selectFetch(
            (new \fpcm\model\dbal\selectParams($this->table))
            ->setWhere('urlhash = ?')
            ->setParams([$this->urlhash])
        );

        if (!$data) {
            return false;
        }

        $this->objExists = true;
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function getCountHits() {
        return $this->counthits;
    }

    public function getLastHit() {
        return $this->lasthit;
    }

    public function setCountHits($counthits) {
        $this->counthits = $counthits;
        return $this;
    }

    public function setLastHit($lasthit) {
        $this->lasthit = $lasthit;
        return $this;
    }


}