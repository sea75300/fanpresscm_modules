<?php

namespace fpcm\modules\nkorg\calendar\models;

class appointments extends \fpcm\model\abstracts\tablelist {

    use \fpcm\module\tools;

    public function __construct()
    {
        $this->table = $this->getObject()->getFullPrefix('appointments');
        return parent::__construct();
    }

    public function getAppointments($param = null) : array
    {
        $obj = (new \fpcm\model\dbal\selectParams($this->table))
                ->setFetchAll(true);
        
        $where = ['id > 0'];

        if ($param instanceof search) {
            
            $values = [];
            
            if ($param->description) {
                $where[] = 'description LIKE ?';
                $values[] = '%'.$param->description.'%';
            }
            
            if ($param->start) {
                $where[] = 'datetime >= ?';
                $values[] = (int) $param->start;
            }
            
            if ($param->stop) {
                $where[] = 'datetime < ?';
                $values[] = (int) $param->stop;
            }
            
            if ($param->pending) {
                $where[] = 'pending = ?';
                $values[] = (int) $param->pending;
            }

            if ($param->visible) {
                $where[] = 'visible = ?';
                $values[] = (int) $param->visible;
            }

            $obj->setParams($values);            
        }
        
        $where = implode(' AND ', $where).' '.$this->dbcon->orderBy(['datetime DESC']);
        $obj->setWhere($where);
        
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
