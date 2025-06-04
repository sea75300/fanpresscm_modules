<?php

namespace fpcm\modules\nkorg\example\events\article;

final class saveAfter extends \fpcm\modules\nkorg\example\events\eventBase {

    public function run() : \fpcm\module\eventResult 
    {
        return \fpcm\events\abstracts\event::RETURNTYPE_VOID;
    }

}
