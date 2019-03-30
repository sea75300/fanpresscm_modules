<?php

namespace fpcm\modules\nkorg\extstats\events;

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
    
    final protected function countAll()
    {
        $this->visitorsCount();
        $this->linksCount();
    }

    final protected function visitorsCount()
    {
        $countObj = new \fpcm\modules\nkorg\extstats\models\countVisit();

        $fn = 'save';
        if ($countObj->exists()) {
            $countObj->init();
            $fn = 'update';
        }

        if ($countObj->updateUnique()) {
            $countObj->setCountUnique($countObj->getCountUnique() + 1);
        }

        $countObj->setCountHits($countObj->getCountHits() + 1);
        call_user_func([$countObj, $fn]);
        
        setcookie('extstatsts', uniqid().' Unused cookie value', time() + 3600, '/', '', false, true);
        return true;
    }

    final protected function linksCount()
    {
        $countObj = new \fpcm\modules\nkorg\extstats\models\countLink();

        $fn = 'save';
        if ($countObj->exists()) {
            $countObj->init();
            $fn = 'update';
        }

        $countObj->setCountHits($countObj->getCountHits() + 1);
        $countObj->setLastHit(time());
        call_user_func([$countObj, $fn]);
        return true;
    }

}
