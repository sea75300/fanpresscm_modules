<?php

namespace fpcm\modules\nkorg\example\events\view;

final class extendTabs extends \fpcm\modules\nkorg\example\events\eventBase  {

    final public function run()
    {        
        $this->data->tabs[] = (new \fpcm\view\helper\tabItem(md5(self::class)))
                ->setText('Extend tabs item');

        return (new \fpcm\module\eventResult)->setData($this->data);
    }

}
