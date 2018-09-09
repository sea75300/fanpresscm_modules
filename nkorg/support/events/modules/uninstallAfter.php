<?php

namespace fpcm\modules\nkorg\support\events\modules;

class uninstallAfter extends \fpcm\module\event {

    public function run()
    {
        $author = (new \fpcm\model\users\userList())->getUserByUsername('support');
        if (!$author->getId()) {
            return true;
        }
        
        if (!$author->delete()) {
            trigger_error('Unable to remove support user');
            return false;
        }
        
        return true;
    }

    public function init()
    {
        return true;
    }

}
