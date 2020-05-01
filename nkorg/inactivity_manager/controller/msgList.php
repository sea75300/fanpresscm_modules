<?php

namespace fpcm\modules\nkorg\inactivity_manager\controller;

final class msgList extends \fpcm\controller\abstracts\module\controller {

    use \fpcm\controller\traits\common\dataView;

    /**
     *
     * @var \fpcm\modules\nkorg\inactivity_manager\models\messages
     */
    protected $obj;

    public function request()
    {
        if ($this->request->hasMessage('msg')) {
            $this->view->addNoticeMessage($this->addLangVarPrefix('MSGSAVE_SUCCESS'));
        }

        $ids = $this->request->getIDs();
        if (!$this->buttonClicked('delete') || !is_array($ids) || !count($ids)) {
            return true;
        }
        
        if (!$this->obj->deleteMessage($ids)) {
            $this->view->addErrorMessage($this->addLangVarPrefix('MSGDELETE_FAILED'));
            return true;
        }

        $this->view->addNoticeMessage($this->addLangVarPrefix('MSGDELETE_SUCCESS'));
        return true;
    }
    
    public function process()
    {
        $this->items = $this->obj->getMessages();
        $this->itemsCount = count($this->items);

        $this->initDataView();
        $this->view->addButtons([
            (new \fpcm\view\helper\linkButton('add'))
                ->setText($this->addLangVarPrefix('ADDMSG'))
                ->setUrl(\fpcm\classes\tools::getFullControllerLink('message/add'))
                ->setIcon('plus'),
            new \fpcm\view\helper\deleteButton('delete'),
        ]);

        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $this->getModuleKey() . '/js/module.js')
        ]);

        $this->view->assign('headline', $this->addLangVarPrefix('HEADLINE'));
        $this->view->setFormAction('message/list');
        $this->view->render();
        return true;
    }

    protected function getDataViewCols()
    {
        return [
            (new \fpcm\components\dataView\column('select', ''))->setSize('05')->setAlign('center'),
            (new \fpcm\components\dataView\column('button', ''))->setSize(1)->setAlign('center'),
            (new \fpcm\components\dataView\column('text', $this->addLangVarPrefix('MSGTEXT_PREVIEW')))->setSize(5),
            (new \fpcm\components\dataView\column('start', $this->addLangVarPrefix('MSGSTART')))->setSize(2),
            (new \fpcm\components\dataView\column('stop', $this->addLangVarPrefix('MSGEND')))->setSize(2),
            (new \fpcm\components\dataView\column('icon', ''))->setSize(1),
        ];
    }

    protected function getDataViewName()
    {
        return 'messageslist';
    }

    /**
     * 
     * @param \fpcm\modules\nkorg\inactivity_manager\model\message $item
     * @return \fpcm\components\dataView\row
     */
    protected function initDataViewRow($item)
    {
        return new \fpcm\components\dataView\row([
            new \fpcm\components\dataView\rowCol('select', (new \fpcm\view\helper\checkbox('ids[]', 'ids' . $item->getId()))->setValue($item->getId()), '', \fpcm\components\dataView\rowCol::COLTYPE_ELEMENT),
            new \fpcm\components\dataView\rowCol('button', (new \fpcm\view\helper\editButton('edit'))->setUrlbyObject($item) , '', \fpcm\components\dataView\rowCol::COLTYPE_ELEMENT),
            new \fpcm\components\dataView\rowCol('text', new \fpcm\view\helper\escape(substr($item->getText(), 0, 64)) ),
            new \fpcm\components\dataView\rowCol('start', new \fpcm\view\helper\dateText($item->getStarttime()) ),
            new \fpcm\components\dataView\rowCol('stop', new \fpcm\view\helper\dateText($item->getStoptime()) ),
            new \fpcm\components\dataView\rowCol(
                'icon',
                (new \fpcm\view\helper\icon('comment-slash'))->setText($this->addLangVarPrefix('MSGNOCOMMENTS'))->setClass('fpcm-ui-editor-metainfo fpcm-ui-status-'.$item->getNocomments())->setSize('lg'),
                'fpcm-ui-metabox fpcm-ui-dataview-align-center', \fpcm\components\dataView\rowCol::COLTYPE_ELEMENT )
        ]);
    }

    protected function initActionObjects()
    {
        $this->obj = new \fpcm\modules\nkorg\inactivity_manager\models\messages();
        return true;
    }

}
