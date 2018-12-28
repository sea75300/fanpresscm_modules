<?php

namespace fpcm\modules\nkorg\integration\controller;

final class main extends \fpcm\controller\abstracts\module\controller {

    protected function getViewPath(): string
    {
        return 'index';
    }

    public function process()
    {
      
        $mode = $this->config->system_mode == 0 ? 'Frame' : 'Include';
        
        call_user_func([$this, 'addNotification'.$mode]);

        $this->view->assign('items', [
            $this->addLangVarPrefix('GERNERALNOTES') => 'notes',
            $this->addLangVarPrefix('INCLUDE_API') => $this->config->system_mode == 1 ? 'api' : null,
            $this->addLangVarPrefix('CSS_STYLES') => 'styles',
            $this->addLangVarPrefix('SHOW_ARTICLES') => 'articles'.$mode,
            $this->addLangVarPrefix('SHOW_LATESTNEWS') => 'latestnews'.$mode,
            $this->addLangVarPrefix('SHOW_PAGENUMBERS') => $this->config->system_mode == 1 ? 'titlePages' :  null,
            $this->addLangVarPrefix('SHOW_ARTICLETITLE') => $this->config->system_mode == 1 ? 'titleHeadline'  :null,
            $this->addLangVarPrefix('USE_RSS') => 'feed',
        ]);
        
        $this->view->assign('articleCount', $this->config->articles_limit);
        $this->view->assign('cssPath', $this->config->system_css_path);

        $this->view->assign('categories', (new \fpcm\model\categories\categoryList())->getCategoriesNameListAll());
        $this->view->assign('templates', (new \fpcm\model\pubtemplates\templatelist())->getArticleTemplates() );

        $this->view->addButtons([
            (new \fpcm\view\helper\submitButton('process'))
                ->setText('GLOBAL_OK')
                ->setIcon('sync')
        ]);

        $this->view->addJsVars([
            'articlesDefault' => $this->config->articles_limit
        ]);

        $this->view->addJsFiles([
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $this->getModuleKey() . '/js/module.js')
        ]);

        $this->view->setFormAction('integration/main');
        $this->view->render();
        return true;
    }
    
    private function addNotificationFrame()
    {
        $this->notifications->addNotification(new \fpcm\model\theme\notificationItem((new \fpcm\view\helper\icon('code'))->setText($this->addLangVarPrefix('NOTIFICATION_IFRAMEMODE'))));
    }
    
    private function addNotificationInclude()
    {
        $this->notifications->addNotification(new \fpcm\model\theme\notificationItem((new \fpcm\view\helper\icon('php', 'fab'))->setText($this->addLangVarPrefix('NOTIFICATION_PHPMODE'))));
    }

}
