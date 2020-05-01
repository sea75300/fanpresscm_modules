<?php

namespace fpcm\modules\nkorg\extstats\controller;

final class deleteentry extends \fpcm\controller\abstracts\module\ajaxController {

    public function request()
    {
        $this->response = new \fpcm\model\http\response;
        
        $id = $this->request->fromPOST('id', [
        \fpcm\model\http\request::FILTER_CASTINT
        ]);

        if (!$id) {
            $this->response->setReturnData(0)->fetch();
        }

        $this->response->setReturnData( (new \fpcm\modules\nkorg\extstats\models\counter())->deleteLinkEntry($id) ? 1 : 0 )->fetch();
    }

}
