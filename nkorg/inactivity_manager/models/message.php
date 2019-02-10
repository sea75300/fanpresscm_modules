<?php

namespace fpcm\modules\nkorg\inactivity_manager\models;

class message extends \fpcm\model\abstracts\dataset {
    
    protected $text      = '';
    
    protected $starttime = 0;
    
    protected $stoptime  = 0;
    
    protected $nocomments = 0;

    public function __construct($id = null) {
        $this->table = 'module_nkorginactivity_manager_messages';
        $this->editAction   = 'message/edit&id=';
        $this->starttime = time();
        $this->stoptime = $this->starttime + FPCM_DATE_SECONDS;
        return parent::__construct($id);
    }
    
    public function getText() {
        return $this->text;
    }

    public function getStarttime() {
        return (int) $this->starttime;
    }

    public function getStoptime() {
        return (int) $this->stoptime;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setStarttime($starttime) {
        $this->starttime = (int) $starttime;
    }

    public function setStoptime($stoptime) {
        $this->stoptime = (int) $stoptime;
    }
    
    public function getNocomments() {
        return (int) $this->nocomments;
    }

    public function setNocomments($nocomments) {
        $this->nocomments = (int) $nocomments;
    }
            
    public function save() {     
        return $this->dbcon->insert($this->table, $this->getPreparedSaveParams());
    }

    public function update() {
        $params     = $this->getPreparedSaveParams();
        $fields     = array_keys($params);
        $params[]   = $this->getId();
        return $this->dbcon->update($this->table, $fields, array_values($params), 'id = ?');
    }
    
    public function __toString() {
        
        $html   = array();
        $html[] = '<div class="fpcm-inactivity-manager-box">';
        $html[] = ' <div class="fpcm-inactivity-manager-box-inner">';
        $html[] = '     <span class="fpcm-inactivity-manager-date">'.date('d.m.Y', $this->getStarttime()).' - '.date('d.m.Y', $this->getStoptime()).'</span>';
        $html[] = '     <span class="fpcm-inactivity-manager-text">'.$this->getText().'</span>';
        $html[] = ' </div>';
        $html[] = '</div>';
        
        return implode(PHP_EOL, $html);
    }

    /**
     * 
     * @param message $obj
     * @param array $param
     */
    public static function assignData(&$obj, array $param)
    {
        $obj->setText($param['text']);
        $obj->setStarttime(strtotime($param['dateFrom'].' 00:00:00'));
        $obj->setStoptime(strtotime($param['dateTo'].' 23:59:59'));
        $obj->setNocomments(isset($param['comments']) ? true : false);
    }

    /**
     * unused
     * @return string
     * @since FPCM 4.1
     */
    protected function getEventModule() : string
    {
        return '';
    }
}
