<?php

namespace fpcm\modules\nkorg\calendar\models;

class appointments extends \fpcm\model\abstracts\tablelist {

    use \fpcm\module\tools;

    public function __construct()
    {
        $this->table = $this->getObject()->getFullPrefix('appointments');
        return parent::__construct();
    }

    public function getAppointments($param = null)
    {
        
        $obj = (new \fpcm\model\dbal\selectParams($this->table))
                ->setFetchAll(true);
        
        
        $appointments = $this->dbcon->selectFetch($obj);
        if (!$appointments) {
            return [];
        }

        foreach ($appointments as $appointment) {
            $res = new appointment;
            $res->createFromDbObject($appointment);
            $this->data[] = $res;
        }

        return $this->data;
    }
}
