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

    private int $start;

    private int $stop;

    public function getContent() : string
    {
        $this->start = mktime(0, 0, 0);
        $this->stop = mktime(23, 59, 59);

        $search = new \fpcm\modules\nkorg\calendar\models\search();
        $search->start = mktime(0,0,0);
        $search->visible = 1;

        $appointments = (new \fpcm\modules\nkorg\calendar\models\appointments)->getAppointments($search);

        if (!count($appointments)) {
            return $this->language->translate('GLOBAL_NOTFOUND2');
        }
        
        $html = ['<div class="list-group me-2">'];
        /* @var $appointment \fpcm\modules\nkorg\calendar\models\appointment */
        foreach ($appointments as $appointment) {
            
            $dt = $appointment->getDatetime();

            $html[] = sprintf(
                '<a class="list-group-item list-group-item-action %s" href="%s">%s <strong>%s</strong> %s</a>',
                $this->isCurrent($dt),
                $appointment->getEditLink(),
                (string) (new \fpcm\view\helper\icon('edit')),
                (new \fpcm\view\helper\dateText($appointment->getDatetime(), $appointment->getPending() ? 'M / Y' : 'd.m.Y')),
                (new \fpcm\view\helper\escape($appointment->getDescription()))
            );            
        }

        $html[] = '</div>';
        
        return implode(PHP_EOL, $html);
    }

    public function getHeadline() : string
    {
        return $this->language->translate(
            $this->addLangVarPrefix('HEADLINE_DASHBOARD'),
            [
                (string) (new \fpcm\view\helper\icon('calendar-day'))
            ],
            true
        );
    }

    public function getName() : string
    {
        return 'nkorg_calendar_recentpoll';
    }

    public function getPosition()
    {
        return self::DASHBOARD_POS_MAX;
    }

    private function isCurrent(int $dt) : string
    {
        return $dt >= $this->start && $dt <= $this->stop ? 'list-group-item-warning' : '';
    }

}
