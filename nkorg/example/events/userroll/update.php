<?php

namespace fpcm\modules\nkorg\example\events\userroll;

final class update extends \fpcm\modules\nkorg\example\events\eventBase {

    public function run() : \fpcm\module\eventResult 
    {
        $this->data['codex'] .=  ' '. microtime(true).' '.$this->getModuleKey().' '. get_class($this);        
        return (new \fpcm\module\eventResult())->setData($this->data);
    }

}
