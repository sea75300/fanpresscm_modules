<?php

namespace fpcm\modules\nkorg\polls\models;

class pollform {

    private $templateConfigPaths;

    /**
     *
     * @var poll
     */
    private $poll;

    public function __construct(poll $poll) {
        
        $this->poll = $poll;
        $this->templateConfigPaths = dirname(__DIR__).'/config/templates/';
    }
    
    private function getTemplates(string $name) {
        
        $data = [];
        
        $customTpls = glob($this->templateConfigPaths.$name.'_*.custom.html');
        foreach ($customTpls as $tpl) {
            $data[basename($tpl)] = $tpl;
        }
        
        unset($tpl);

        $defaultTpls = glob($this->templateConfigPaths.$name.'_*.html');
        foreach ($defaultTpls as $tpl) {

            if (isset($data[basename($tpl)])) {
                continue;
            }

            $data[basename($tpl)] = $tpl;
        }

        unset($tpl);

        return array_map('file_get_contents', $data);
    }
    
    private function replaceTags(string &$str, array $data) {

        $str = str_replace(array_keys($data), array_values($data), $str);
        return true;
    }

    public function getVoteForm() {

        $templates = glob($this->templateConfigPaths.'voteform_*.custom.html');
        
        $tpl = $this->getTemplates('voteform');

        $this->replaceTags($tpl['voteform_header.html'], [
            '{{poll_text}}' => $this->poll->getText()
        ]);

        $this->replaceTags($tpl['voteform_footer.html'], [
            '{{poll_button_sumit}}' => ( new \fpcm\view\helper\button('vote'.$this->poll->getId()) )->setClass('fpcm-polls-poll-submit')->setData(['pollid' => $this->poll->getId()])->setText('Abstimmen'),
            '{{poll_button_reset}}' => ( new \fpcm\view\helper\button('reset'.$this->poll->getId()) )->setClass('fpcm-polls-poll-reset')->setData(['pollid' => $this->poll->getId()])->setText('Zurücksetzen'),
            '{{poll_button_results}}' => ( new \fpcm\view\helper\button('result'.$this->poll->getId()) )->setClass('fpcm-polls-poll-result')->setData(['pollid' => $this->poll->getId()])->setText('Ergebnisse anzeigen')
        ]);

        if ($this->poll->getMaxreplies() > 1) {
            $replyClass = '\fpcm\view\helper\checkbox';
            $optionName = 'reply{{$pollid}}_{{$replyId}}';
        }
        else {
            $replyClass = '\fpcm\view\helper\radiobutton';
            $optionName =  'reply{{$pollid}}';
        }

        $options = [];

        /* @var $reply poll_reply */
        foreach ($this->poll->getReplies() as $reply) {
            $options[$reply->getId()] = $tpl['voteform_line.html'];
            
            $optObj = ( new $replyClass(str_replace(
                    ['{{$pollid}}', '{{$replyId}}'],
                    [$reply->getPollid(), $reply->getId()],
                    $optionName)
            ) )
            ->setValue($reply->getId())
            ->setClass('fpcm-polls-poll-options fpcm-polls-poll'.$reply->getPollid().'-option');
            
            $this->replaceTags($options[$reply->getId()], [
                '{{poll_reply_option}}' => $optObj,
                '{{poll_reply_text}}' => $reply->getText()
            ]);
        }

        return $tpl['voteform_header.html'].PHP_EOL.implode(PHP_EOL, $options).$tpl['voteform_footer.html'];
    }

}
