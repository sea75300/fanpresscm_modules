<?php

namespace fpcm\modules\nkorg\extstats\models;

class countVisit extends dbObj {

    protected $table = 'module_nkorgextstats_counts_visits';

    protected $year;
    protected $month;
    protected $day;
    protected $countunique = 0;
    protected $counthits = 0;

    public function __construct()
    {
        parent::__construct();
        $this->year = (int) date('Y');
        $this->month = (int) date('n');
        $this->day = (int) date('j');
        $this->init();
    }
    
    public function init()
    {
        $data = $this->dbcon->selectFetch(
            (new \fpcm\model\dbal\selectParams($this->table))
            ->setWhere('year = ? AND month = ? AND day = ?')
            ->setParams([$this->year, $this->month, $this->day])
        );

        if (!$data) {
            return false;
        }

        $this->objExists = true;
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getCountUnique() {
        return $this->countunique;
    }

    public function getCountHits() {
        return $this->counthits;
    }

    public function setCountUnique($countunique) {
        $this->countunique = $countunique;
        return $this;
    }

    public function setCountHits($counthits) {
        $this->counthits = $counthits;
        return $this;
    }

    public function updateUnique()
    {
        return (\fpcm\classes\http::cookieOnly('extstatsts') ? false : true);        
    }
}
