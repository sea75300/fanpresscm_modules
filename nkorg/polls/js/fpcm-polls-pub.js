if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.polls_pub = {

    init: function () {

        fpcm.polls_pub._initVote();
    },
    
    initAfter: function() {
        
    },

    _initVote: function () {

        jQuery('button.fpcm-polls-poll-submit').click(function() {

           var data = {
               rids: [],
               pid: 0,
               fn: 'vote'
           };
           
           data.pid = jQuery(this).data('pollid');
           if (!data.pid) {
               return false;
           }
           
            jQuery('input.fpcm-polls-poll' + data.pid + '-option:checked').each(function( key, obj ) {
                data.rids.push(parseInt(obj.value));
            });

            fpcm.ajax.post('polls/ajaxpublic', {
                data: data,
                execDone: function (result) {
                    
                    result = fpcm.ajax.fromJSON(result);
                    fpcm.ui.addMessage({
                        txt: result.msg,
                        type: result.code < 0 ? 'error' : 'notice'
                    });

                }
            })

            return false;
        });
        
        
        'fpcm-polls-poll1-option';
        
    }

};