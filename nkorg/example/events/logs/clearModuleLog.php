<?php

namespace fpcm\modules\nkorg\example\events\logs;

final class clearModuleLog extends \fpcm\modules\nkorg\example\events\eventBase {

    public function run() : \fpcm\module\eventResult 
    {
        return $this->cleanupLog();
    }

}
