<?php

namespace fpcm\modules\nkorg\inactivity_manager\events\pub;

final class showArchive extends \fpcm\module\event {

    public function run()
    {
        $messageList = (new \fpcm\modules\nkorg\inactivity_manager\models\messages())->getMessages(true);
        foreach ($messageList as $message) {
            array_unshift($this->data, (string) $message);                
        }

        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
