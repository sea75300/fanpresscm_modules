<?php

namespace fpcm\modules\nkorg\integration\events\navigation;

final class add extends \fpcm\module\event {

    public function run()
    {
        $this->data[\fpcm\model\theme\navigationItem::AREA_AFTER][] = (new \fpcm\model\theme\navigationItem())
                ->setDescription('MODULE_NKORGINTEGRATION_HEADLINE')
                ->setIcon('fa fa-broadcast-tower fa-fw')
                ->setUrl('integration/main');

        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
