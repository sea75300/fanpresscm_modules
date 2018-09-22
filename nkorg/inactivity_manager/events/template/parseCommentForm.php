<?php

namespace fpcm\modules\nkorg\inactivity_manager\events\template;

final class parseCommentForm extends \fpcm\module\event {

    public function run()
    {
        $lang = \fpcm\classes\loader::getObject('\fpcm\classes\language');
        
        $messageList = (new \fpcm\modules\nkorg\inactivity_manager\models\messages())->getMessages(true, true);
        if (!count($messageList)) {
            $this->data['{{inactivityManagerCommentsDiabled}}'] = '';
            return $this->data;
        }

        $this->data['{{submitButton}}'] = "<button type=\"button\" disabled=\"disabled\" \">{$lang->translate('GLOBAL_SUBMIT')}</button>";
        return $this->data;
    }

    public function init()
    {
        return true;
    }

}
