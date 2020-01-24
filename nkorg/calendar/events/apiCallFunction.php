<?php

namespace fpcm\modules\nkorg\calendar\events;

use fpcm\classes\loader;
use fpcm\model\system\session;

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

    final protected function display()
    {

        return true;
    }

}
