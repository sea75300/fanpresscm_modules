<?php

namespace fpcm\modules\nkorg\example\events\userroll;

final class save extends \fpcm\modules\nkorg\example\events\eventBase {

    public function run() : \fpcm\module\eventResult 
    {
        return (new \fpcm\module\eventResult())->setData( $this->data.' '. microtime(true).' '.$this->getModuleKey().' '. get_class($this) );
    }

}
