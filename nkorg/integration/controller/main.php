<?php

namespace fpcm\modules\nkorg\integration\controller;

final class main extends \fpcm\controller\abstracts\module\controller {

    protected function getViewPath(): string
    {
        return 'index';
    }

    public function process()
    {
        $this->view->assign('items', [
            $this->addLangVarPrefix('GERNERALNOTES') => 'notes',
            $this->addLangVarPrefix('INCLUDE_API') => 'api',
            $this->addLangVarPrefix('CSS_STYLES') => 'styles',
            $this->addLangVarPrefix('SHOW_ARTICLES') => 'articlesInclude',
            $this->addLangVarPrefix('SHOW_LATESTNEWS') => 'latestnewsInclude',
            $this->addLangVarPrefix('SHOW_PAGENUMBERS') => 'titlePages',
            $this->addLangVarPrefix('SHOW_ARTICLETITLE') => 'titleHeadline',
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

        $this->view->addTabs('integration', [
            (new \fpcm\view\helper\tabItem('editor'))
                ->setText($this->addLangVarPrefix('HEADLINE'))
                ->setModulekey($this->getModuleKey())
                ->setFile( \fpcm\view\view::PATH_MODULE . $this->getViewPath() )
        ]);

        $this->view->addFromModule(['module.js']);
        $this->view->setFormAction('integration/main');
        $this->view->render();
        return true;
    }

}
