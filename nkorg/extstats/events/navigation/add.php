<?php

namespace fpcm\modules\nkorg\extstats\events\navigation;

final class add extends \fpcm\module\event {

    public function run()
    {
        $item = (new \fpcm\model\theme\navigationItem())
                ->setDescription('MODULE_NKORGEXTSTATS_HEADLINE')
                ->setIcon('fa fa-chart-pie fa-fw')
                ->setUrl('extstats/statistics');
        
        if (class_exists('\fpcm\model\theme\navigationList') && $this->data instanceof \fpcm\model\theme\navigationList) {
            $this->data->add(\fpcm\model\theme\navigationItem::AREA_AFTER, $item);
            return $this->data;
        }
        
        $this->data[\fpcm\model\theme\navigationItem::AREA_AFTER][] = $item;
        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
