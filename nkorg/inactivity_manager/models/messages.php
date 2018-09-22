<?php

namespace fpcm\modules\nkorg\inactivity_manager\models;

class messages extends \fpcm\model\abstracts\tablelist {

    public function __construct()
    {
        $this->table = 'module_nkorginactivity_manager_messages';
        return parent::__construct();
    }

    /**
     * 
     * @return array
     */
    public function getMessages($filter = false, $nocomments = false)
    {
        $where = "id > 0";
        $params = [];

        if ($filter) {
            $dtz = new \DateTimeZone($this->config->system_timezone);

            $start = new \DateTime('now', $dtz);
            $start->setTime(0, 0, 0);

            $stop = new \DateTime('now', $dtz);
            $stop->setTime(23, 59, 59);

            $where .= " AND starttime <= ? AND stoptime >= ?";

            $params[] = $start->getTimestamp();
            $params[] = $stop->getTimestamp();

            if ($nocomments) {
                $where .= " AND nocomments = 1";
            }
        }

        $where .= " ORDER BY starttime ASC, stoptime ASC";
        $messageRows = $this->dbcon->fetch($this->dbcon->select($this->table, '*', $where, $params), true);

        $messages = array();
        foreach ($messageRows as $messageRow) {
            $message = new message();
            $message->createFromDbObject($messageRow);
            $messages[] = $message;
        }

        return $messages;
    }

    public function deleteMessage(array $ids)
    {
        if (!count($ids)) {
            return false;
        }

        $ids = array_map('intval', $ids);
        return $this->dbcon->delete($this->table, 'id IN (' . implode(',', $ids) . ')');
    }

}
