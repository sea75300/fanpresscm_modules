<?php

namespace fpcm\modules\nkorg\inactivity_manager\events\navigation;

final class add extends \fpcm\module\event {

    public function run()
    {
        $item = (new \fpcm\model\theme\navigationItem())
                ->setDescription('MODULE_NKORGINACTIVITY_MANAGER_HEADLINE')
                ->setIcon('fa fa-calendar-alt fa-fw', 'far')
                ->setUrl('message/list');
        
        $this->data->add(\fpcm\model\theme\navigationItem::AREA_AFTER, $item);
        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
