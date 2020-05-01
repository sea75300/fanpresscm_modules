<?php

namespace fpcm\modules\nkorg\extstats\controller;

final class statistics extends \fpcm\controller\abstracts\module\controller {

    protected function getViewPath() : string
    {
        return 'index';
    }

    public function process()
    {
        $key = $this->getModuleKey();

        $chartTypes = [
            $this->addLangVarPrefix('TYPEBAR') => 'bar',
            $this->addLangVarPrefix('TYPELINE') => 'line',
            $this->addLangVarPrefix('TYPEPIE') => 'pie',
            $this->addLangVarPrefix('TYPEDOUGHNUT') => 'doughnut',
            $this->addLangVarPrefix('TYPEPOLAR') => 'polarArea',
        ];

        $chartModes = [
            $this->addLangVarPrefix('BYYEAR') => \fpcm\modules\nkorg\extstats\models\counter::MODE_YEAR,
            $this->addLangVarPrefix('BYMONTH') => \fpcm\modules\nkorg\extstats\models\counter::MODE_MONTH,
            $this->addLangVarPrefix('BYDAY') => \fpcm\modules\nkorg\extstats\models\counter::MODE_DAY
        ];

        $dataSource = [
            $this->addLangVarPrefix('FROMARTICLES') => \fpcm\modules\nkorg\extstats\models\counter::SRC_ARTICLES,
            $this->addLangVarPrefix('FROMSHARES') => \fpcm\modules\nkorg\extstats\models\counter::SRC_SHARES,
            $this->addLangVarPrefix('FROMCOMMENTS') => \fpcm\modules\nkorg\extstats\models\counter::SRC_COMMENTS,
            $this->addLangVarPrefix('FROMFILES') => \fpcm\modules\nkorg\extstats\models\counter::SRC_FILES,
            $this->addLangVarPrefix('FROMVISITS') => \fpcm\modules\nkorg\extstats\models\counter::SRC_VISITORS,
            $this->addLangVarPrefix('FROMLINKS') => \fpcm\modules\nkorg\extstats\models\counter::SRC_LINKS
        ];

        $this->getSettings($source, $chartType, $chartMode, $modeStr, $start, $stop);

        $hideMode = in_array($source, [\fpcm\modules\nkorg\extstats\models\counter::SRC_SHARES, \fpcm\modules\nkorg\extstats\models\counter::SRC_LINKS]);
        $isLinks = $source === \fpcm\modules\nkorg\extstats\models\counter::SRC_LINKS ? true : false;

        $this->view->assign('modeStr',  $hideMode ? '' : strtoupper($modeStr));
        $this->view->assign('sourceStr', array_search($source, $dataSource));
        $this->view->assign('isLinks', $isLinks);
        $this->view->assign('start', trim($start) ? $start : '');
        $this->view->assign('stop', trim($stop) ? $stop : '');
        $this->view->assign('chartTypes', $chartTypes);
        $this->view->assign('chartType', $chartType);

        $buttons = [
            (new \fpcm\view\helper\select('source'))
                ->setClass('fpcm-ui-input-select-articleactions')
                ->setOptions($dataSource)->setSelected($source)
                ->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED),

            (new \fpcm\view\helper\select('chartMode'))
                ->setClass('fpcm-ui-input-select-articleactions ')
                ->setOptions($chartModes)->setSelected($chartMode)
                ->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED),

            (new \fpcm\view\helper\submitButton('setdatespan'))
                ->setText('GLOBAL_OK')
        ];

        if ($isLinks) {
            $buttons[] = (new \fpcm\view\helper\submitButton('removeEntries'))
                ->setText($this->addLangVarPrefix('HITS_LIST_DELETE'), [
                    'limit' => $this->config->module_nkorgextstats_link_compress
                ])
                ->setIcon('file-archive')
                ->setIconOnly(true);
        }

        $this->view->addButtons($buttons);

        $counter = new \fpcm\modules\nkorg\extstats\models\counter();
        if ($this->buttonClicked('removeEntries')) {
            if (!$counter->cleanupLinks()) {
                $this->view->addNoticeMessage($this->addLangVarPrefix('CLEANUP_FAILED'), [
                    'limit' => $this->config->module_nkorgextstats_link_compress
                ]);
            }
            else {
                $this->view->addNoticeMessage($this->addLangVarPrefix('CLEANUP_SUCCESS'), [
                    'limit' => $this->config->module_nkorgextstats_link_compress
                ]);
            }
        }

        $articleList = new \fpcm\model\articles\articlelist();
        $minMax = $articleList->getMinMaxDate();

        $fn = 'fetch' . ucfirst($source);
        if (!method_exists($counter, $fn)) {
            $this->view->render();
            return true;
        }

        $values = call_user_func([$counter, $fn], $start, $stop, $chartMode);
        $this->view->assign('notfound', empty($values['datasets']) ? true : false);

        $this->view->addJsVars([
            'extStats' => [
                'chartValues' => $values,
                'chartType' => trim($chartType) ? $chartType : 'bar',
                'minDate' => date('Y-m-d', $minMax['minDate']),
                'showMode' => $hideMode ? false : true,
                'showDate' => $isLinks,
                'deleteButtonStr' => $isLinks ? (string) (new \fpcm\view\helper\button('entry_{$id}'))->setText('GLOBAL_DELETE')->setIcon('trash')->setIconOnly(true)->setData(['entry' => '{$id}'])->setClass('fpcm-extstats-links-delete') : '',
                'openButtonStr' => $isLinks ? (string) (new \fpcm\view\helper\openButton('open_{$id}'))->setText('GLOBAL_OPEN')->setUrl('{$url}')->setTarget('_blank')->setRel('external') : ''
            ]
        ]);
        
        $this->view->addJslangVars([$this->addLangVarPrefix('HITS_LIST_LATEST')]);
        $this->view->addJsFiles([
            \fpcm\classes\loader::libGetFileUrl('chart-js/chart.min.js'),
            \fpcm\classes\dirs::getDataUrl(\fpcm\classes\dirs::DATA_MODULES, $key . '/js/module.js')
        ]);

        $this->view->setFormAction('extstats/statistics');
        $this->view->render();
        return true;
    }
    
    private function getSettings(&$source, &$chartType, &$chartMode, &$modeStr, &$start, &$stop)
    {
        $source = $this->request->fromPOST('source');
        if (!trim($source)) {
            $source = $this->config->module_nkorgextstats_show_visitors
                    ? \fpcm\modules\nkorg\extstats\models\counter::SRC_VISITORS
                    : \fpcm\modules\nkorg\extstats\models\counter::SRC_ARTICLES;
        }
        
        $chartType = $this->request->fromPOST('chartType');
        if (!trim($chartType)) {
            $chartType = 'bar';
        }

        $chartMode = $this->request->fromPOST('chartMode', [
            \fpcm\model\http\request::FILTER_CASTINT
        ]);

        if (!trim($chartMode)) {
            $chartMode = $this->config->module_nkorgextstats_show_visitors
                    ? \fpcm\modules\nkorg\extstats\models\counter::MODE_DAY
                    : \fpcm\modules\nkorg\extstats\models\counter::MODE_MONTH;
        }

        $modeStr = $chartMode === \fpcm\modules\nkorg\extstats\models\counter::MODE_YEAR
                 ? 'YEAR'
                 : ($chartMode === \fpcm\modules\nkorg\extstats\models\counter::MODE_DAY ? 'DAY' : 'MONTH' );

        $start = $this->request->fromPOST('dateFrom');
        $stop = $this->request->fromPOST('dateTo');
        
        if ($start === null || !\fpcm\classes\tools::validateDateString($start)) {
            $start = date('Y-m-d', time() - $this->config->module_nkorgextstats_timespan_default * 86400);
        }
        
        if (trim($stop) && !\fpcm\classes\tools::validateDateString($stop)) {
            $stop = '';
        }

        return true;
    }

}
