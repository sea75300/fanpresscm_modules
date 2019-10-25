<?php

namespace fpcm\modules\nkorg\extstats\events\cron;

final class includeDumpTables extends \fpcm\module\event {

    public function run()
    {
        $this->data[] = 'module_nkorgextstats_counts_links';
        $this->data[] = 'module_nkorgextstats_counts_visits';
        return true;
    }

    public function init(): bool
    {
        return false;
    }

}