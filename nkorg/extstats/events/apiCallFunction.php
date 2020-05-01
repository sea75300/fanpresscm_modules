<?php

namespace fpcm\modules\nkorg\extstats\events;

use fpcm\classes\loader;
use fpcm\model\system\session;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

final class apiCallFunction extends \fpcm\module\event {

    /**
     * @var session
     */
    protected $session;

    /**
     * @var bool
     */
    protected $excludeCount = null;

    public function run()
    {
        $fn = $this->data['name'];
        if (!method_exists($this, $fn)) {
            trigger_error('Function '.$fn.' does not exists!');
            return false;
        }

        $this->session = loader::getObject('\fpcm\model\system\session');
        $this->excludeCount = $this->excludeCount() || $this->session->exists();
        call_user_func([$this, $fn],$this->data['args']);
        return true;
    }

    public function init()
    {
        return true;
    }
    
    final protected function countAll()
    {
        $this->visitorsCount();
        $this->linksCount();
    }

    final protected function visitorsCount()
    {
        if ($this->excludeCount) {
            return true;
        }

        $countObj = new \fpcm\modules\nkorg\extstats\models\countVisit();

        $fn = 'save';
        if ($countObj->exists()) {
            $countObj->init();
            $fn = 'update';
        }

        if ($countObj->updateUnique()) {
            $countObj->setCountUnique($countObj->getCountUnique() + 1);
        }

        $countObj->setCountHits($countObj->getCountHits() + 1);
        call_user_func([$countObj, $fn]);

        /* @var $config \fpcm\model\system\config */
        $duration = (int) \fpcm\classes\loader::getObject('\fpcm\model\system\config')->module_nkorgextstats_cookie_duration;
        if (!$duration || $duration < 600) {
            $duration = 3600;
        }
        
        $expire = time() + $duration;
        
        /* @var $request \fpcm\model\http\request */
        $request = \fpcm\classes\loader::getObject('\fpcm\model\http\request');
        $str = 'This cookie marks you as unique visitor until '. date(DATE_ISO8601, $expire).'. Source: '. $request->filter($_SERVER['REQUEST_URI'] ?? 'localhost', [
            \fpcm\model\http\request::FILTER_STRIPTAGS,            
            \fpcm\model\http\request::FILTER_TRIM,            
        ]);

        setcookie('extstatsts', $str, $expire, '/', '', false, true);
        return true;
    }

    final protected function linksCount()
    {
        if ($this->excludeCount) {
            return true;
        }

        $countObj = new \fpcm\modules\nkorg\extstats\models\countLink();

        $fn = 'save';
        if ($countObj->exists()) {
            $countObj->init();
            $fn = 'update';
        }

        $countObj->setCountHits($countObj->getCountHits() + 1);
        $countObj->setLastHit(time());
        call_user_func([$countObj, $fn]);
        return true;
    }

    private function excludeCount()
    {
        if ($this->excludeCount !== null) {
            return $this->excludeCount;
        }
        
        $base = dirname(__DIR__).DIRECTORY_SEPARATOR.'crawlerDetect'.DIRECTORY_SEPARATOR;

        require_once $base.'Fixtures/AbstractProvider.php';
        require_once $base.'Fixtures/Crawlers.php';
        require_once $base.'Fixtures/Exclusions.php';
        require_once $base.'Fixtures/Headers.php';
        require_once $base.'CrawlerDetect.php';

        return (new CrawlerDetect())->isCrawler();
    }

}
