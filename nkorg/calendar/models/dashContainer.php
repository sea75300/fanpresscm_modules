<?php

namespace fpcm\modules\nkorg\calendar\models;

class dashContainer extends \fpcm\model\abstracts\dashcontainer {

    use \fpcm\module\tools;

    /**
     * Container chart
     * @var \fpcm\components\charts\chart
     */
    private $chart;

    /**
     * Poll for chart
     * @var poll
     */
    private $poll = false;

    public function getContent() : string
    {
        $search = new \fpcm\modules\nkorg\calendar\models\search();
        $search->start = mktime(0,0,0);
        $search->visible = 1;

        $appointments = (new \fpcm\modules\nkorg\calendar\models\appointments)->getAppointments($search);

        if (!count($appointments)) {
            return $this->language->translate('GLOBAL_NOTFOUND2');
        }
        
        $html = ['<ul>'];
        /* @var $appointment \fpcm\modules\nkorg\calendar\models\appointment */
        foreach ($appointments as $appointment) {
            
            $html[] = '<li>';
            $html[] = '<strong>'.(new \fpcm\view\helper\dateText($appointment->getDatetime(), $appointment->getPending() ? 'M / Y' : 'd.m.Y')).'</strong>: ';
            $html[] = (new \fpcm\view\helper\escape($appointment->getDescription()));
            $html[] = '</li>';
        }

        $html[] = '</ul>';;
        
        return implode(PHP_EOL, $html);
    }

    public function getHeadline() : string
    {
        return $this->language->translate($this->addLangVarPrefix('HEADLINE'));
    }

    public function getName() : string
    {
        return 'nkorg_calendar_recentpoll';
    }

    public function getPosition()
    {
        return self::DASHBOARD_POS_MAX;
    }

}
