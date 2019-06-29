<?php

namespace fpcm\modules\nkorg\extstats\controller;

final class deleteentry extends \fpcm\controller\abstracts\module\ajaxController {

    public function request()
    {
        $id = $this->getRequestVar('id', [
            \fpcm\classes\http::FILTER_CASTINT
        ]);

        if (!$id) {
            $this->returnData = 0;
            $this->getSimpleResponse();
        }

        $this->returnData = (new \fpcm\modules\nkorg\extstats\models\counter())->deleteLinkEntry($id) ? 1 : 0;
        $this->getSimpleResponse();
        return true;
    }

}
