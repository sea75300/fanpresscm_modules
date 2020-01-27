<?php

namespace fpcm\modules\nkorg\calendar\controller;

final class add extends base {

    public function request()
    {
        $this->appointment = new \fpcm\modules\nkorg\calendar\models\appointment;
        if ($this->buttonClicked('save') && $this->save()) {
            $this->redirect('calendar/edit', [
                'id' => $this->appointment->getId()
            ]);
        }

        return true;
    }

    public function process()
    {
        $this->appointment->setDatetime(time());
        $this->appointment->setPending(0);
        $this->appointment->setVisible(1);
        $this->view->setFormAction('calendar/add');

        parent::process();
    }

}
