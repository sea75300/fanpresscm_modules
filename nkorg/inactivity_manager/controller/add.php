<?php

namespace fpcm\modules\nkorg\inactivity_manager\controller;

final class add extends base {
    
    public function process()
    {
        $this->view->setFormAction('message/add');
        parent::process();
    }

}
