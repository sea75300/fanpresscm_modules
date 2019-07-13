<?php

namespace fpcm\modules\nkorg\extstats\models;

class countLink extends dbObj {

    const TABLE = 'module_nkorgextstats_counts_links';

    protected $url = '';
    protected $urlhash = '';
    protected $counthits = 0;
    protected $lasthit = 0;

    public function __construct()
    {
        $this->table = self::TABLE;
        parent::__construct();
        $this->url = \fpcm\classes\http::filter($_SERVER['REQUEST_URI'] ?? 'localhost', [
            \fpcm\classes\http::FILTER_STRIPTAGS,            
            \fpcm\classes\http::FILTER_TRIM,            
        ]);
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