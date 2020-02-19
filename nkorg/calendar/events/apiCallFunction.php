<?php

namespace fpcm\modules\nkorg\calendar\events;

final class apiCallFunction extends \fpcm\module\event {

    public function run()
    {
        $fn = $this->data['name'];
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }

        call_user_func([$this, $fn],$this->data['args']);
        return true;
    }

    public function init()
    {
        return true;
    }

    final protected function display()
    {
        $search = new \fpcm\modules\nkorg\calendar\models\search();
        $search->start = mktime(0,0,0);
        $search->visible = 1;
        
        $appointments = (new \fpcm\modules\nkorg\calendar\models\appointments)->getAppointments($search);
        if (!count($appointments)) {            
            print '<p>'.\fpcm\classes\loader::getObject('\fpcm\classes\language')->translate($this->addLangVarPrefix('MSG_ERROR_NOTFOUND_PUB')).'</p>';
            return true;
        }

        $html = ['<ul>'];
        /* @var $appointment \fpcm\modules\nkorg\calendar\models\appointment */
        foreach ($appointments as $appointment) {
            
            $html[] = '<li>';
            $html[] = '<strong>'.(new \fpcm\view\helper\dateText($appointment->getDatetime(), $appointment->getPending() ? 'M / Y' : 'd.m.Y')).'</strong>: ';
            $html[] = (new \fpcm\view\helper\escape($appointment->getDescription()));
            $html[] = '</li>';
        }

        $html[] = '</ul>';
        
        print implode(PHP_EOL, $html);
        return true;
    }

}
