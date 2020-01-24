<?php

namespace fpcm\modules\nkorg\calendar\events\navigation;

final class add extends \fpcm\module\event {

    public function run()
    {
        $this->data[\fpcm\model\theme\navigationItem::AREA_AFTER][] = (new \fpcm\model\theme\navigationItem())
                ->setDescription('Termine verwalten')
                ->setIcon('fa fa-chart-pie fa-fw')
                ->setUrl('calendar/overview');

        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
