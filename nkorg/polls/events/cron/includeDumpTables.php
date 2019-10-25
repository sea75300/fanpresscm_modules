<?php

namespace fpcm\modules\nkorg\polls\events\cron;

final class includeDumpTables extends \fpcm\module\event {

    public function run()
    {
        $this->data[] = 'module_nkorgpolls_polls';
        $this->data[] = 'module_nkorgpolls_poll_replies';
        $this->data[] = 'module_nkorgpolls_vote_log';
        return true;
    }

    public function init(): bool
    {
        return false;
    }

}