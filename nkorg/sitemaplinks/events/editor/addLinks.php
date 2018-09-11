<?php

namespace fpcm\modules\nkorg\sitemaplinks\events\editor;

final class addLinks extends \fpcm\module\event {

    public function run()
    {
        /* @var $config \fpcm\model\system\config */
        $config = \fpcm\classes\loader::getObject('\fpcm\model\system\config');
        
        $path = realpath($config->module_nkorgsitemaplinks_sitemappath);
        
        if (!trim($path) || !file_exists($path)) {
            trigger_error('Sitemap xml file '.$config->module_nkorgsitemaplinks_sitemappath.' does not exists!');
            return $this->data;
        }
        
        $xmlObject = new \SimpleXMLElement(file_get_contents($config->module_nkorgsitemaplinks_sitemappath));
        
        foreach($xmlObject->children() as $child) {
            $this->data[] = array(
                'label' => $child->loc->__toString(),
                'value' => $child->loc->__toString()
            );
        };

        return $this->data;
    }

    public function init(): bool
    {
        return true;
    }
}
