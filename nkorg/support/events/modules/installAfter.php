<?php

namespace fpcm\modules\nkorg\support\events\modules;

class installAfter extends \fpcm\module\event {

    public function run()
    {
        $pass = str_shuffle(chr(mt_rand(65, 90)).uniqid().mt_rand(0, 255));

        $author = new \fpcm\model\users\author();
        $author->setUserName('support');
        $author->setPassword($pass);
        $author->setRoll(1);
        $author->setDisplayName('Support User');
        $author->setEmail('sea75300@yahoo.de');
        
        if (!$author->save()) {
            trigger_error('Unable to create support user.');
            return false;
        }

        /* @var $config \fpcm\model\system\config */
        $config = \fpcm\classes\loader::getObject('\fpcm\model\system\config');

        $text = [];
        $text[] = 'Das Support-Modul wurde im System '.\fpcm\classes\dirs::getRootUrl('').' installiert!';
        $text[] = '';
        $text[] = 'Basis-Informationen:';
        $text[] = '';
        $text[] = '* System-Version: '. \fpcm\classes\baseconfig::getVersionFromFile();
        $text[] = '* PHP-Version: '. phpversion();
        $text[] = '* Datenbank: '. \fpcm\classes\loader::getObject('\fpcm\classes\database')->getDbtype();
        $text[] = '* Datenbank-Version: '. \fpcm\classes\loader::getObject('\fpcm\classes\database')->getDbVersion();
        $text[] = '';
        $text[] = '* Benutzer-Name: '.$author->getUsername();
        $text[] = '* Passwort: '.$pass;

        $email = new \fpcm\classes\email($author->getEmail(), 'Support module installed', implode(PHP_EOL, $text));
        if (!$email->submit()) {
            trigger_error('Unable to submit e-mail.');
            return false;
        }
        
        return true;
    }

    public function init()
    {
        return true;
    }

}
