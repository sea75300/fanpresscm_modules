<?php

namespace fpcm\modules\nkorg\inactivity_manager\events\template;

final class parseArticle extends \fpcm\module\event {

    public function run()
    {
        $messageList = (new \fpcm\modules\nkorg\inactivity_manager\models\messages())->getMessages(true);

        $messageString = '';
        if (!count($messageList)) {
            return $this->data;
        }

        foreach ($messageList as $message) {
            $messageString .= (string) $message;
        }

        $this->data['{{inactivityManagerMessages}}'] = $messageString;

        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
