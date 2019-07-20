<?php

namespace fpcm\modules\nkorg\polls\events\navigation;

final class add extends \fpcm\module\event {

    public function run()
    {
        $this->data[\fpcm\model\theme\navigationItem::AREA_AFTER][] = (new \fpcm\model\theme\navigationItem())
                ->setDescription('Umfragen verwalten')
                ->setIcon('fa fa-chars fa-fw')
                ->setUrl('polls/list');

        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
