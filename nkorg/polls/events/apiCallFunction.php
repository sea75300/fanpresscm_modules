<?php

namespace fpcm\modules\nkorg\polls\events;

use fpcm\classes\loader;

final class apiCallFunction extends \fpcm\module\event {

    public function run()
    {
        $fn = $this->data['name'];
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }

        call_user_func([$this, $fn],$this->data['args']);
        return true;
    }

    public function init()
    {
        return true;
    }

    final protected function displayPoll($pollId = 0)
    {

        return true;
    }

    final protected function displayArchive($pollId = 0)
    {

        return true;
    }

}
