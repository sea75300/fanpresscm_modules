if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.polls_pub = {

    init: function () {

        fpcm.polls_pub._initVote();
        fpcm.polls_pub._initButtons();
    },
    
    initAfter: function() {
        
    },

    _initVote: function () {

        jQuery('button.fpcm-polls-poll-submit').unbind('click');
        jQuery('button.fpcm-polls-poll-reset').unbind('click');

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
            
            if (!data.rids.length) {
                return false;
            }

            fpcm.polls_pub._displayLoader(data.pid);
            fpcm.ajax.post('polls/ajaxpublic', {
                data: data,
                execDone: function (result) {
                    
                    result = fpcm.ajax.fromJSON(result);
                    fpcm.ui.addMessage({
                        txt: result.msg,
                        type: result.code < 0 ? 'error' : 'notice'
                    });
                    
                    if (!result.html) {
                        return false;
                    }

                    jQuery('#fpcm-poll-poll' + data.pid).html(result.html);
                }
            });

            return false;
        });

        jQuery('button.fpcm-polls-poll-reset').click(function() {

            var pid = jQuery(this).data('pollid');
            if (!pid) {
                return false;
            }

            jQuery('input.fpcm-polls-poll' + pid + '-option:checked').prop('checked', false);
            return false;
        });

    },

    _initButtons: function () {
        
        jQuery('button.fpcm-polls-poll-result').unbind('click');
        jQuery('button.fpcm-polls-poll-form').unbind('click');

        jQuery('button.fpcm-polls-poll-result').click(function() {

            var data = {
                pid: 0,
                fn: 'result'
            };

            data.pid = jQuery(this).data('pollid');
            if (!data.pid) {
                return false;
            }
           
            fpcm.polls_pub._displayLoader(data.pid);

            fpcm.ajax.post('polls/ajaxpublic', {
                data: data,
                execDone: function (result) {
                    
                    result = fpcm.ajax.fromJSON(result);
                    if (!result.html) {
                        return false;
                    }
                    
                    if (result.code !== 300) {
                        fpcm.ui.addMessage({
                            txt: result.msg,
                            type: result.code < 0 ? 'error' : 'notice'
                        });
                        return false;
                    }

                    jQuery('#fpcm-poll-poll' + data.pid).html(result.html);
                    fpcm.polls_pub._initButtons();
                }
            });

            return false;
        });

        jQuery('button.fpcm-polls-poll-form').click(function() {

            var data = {
                pid: 0,
                fn: 'pollForm'
            };

            data.pid = jQuery(this).data('pollid');
            if (!data.pid) {
                return false;
            }
            
            fpcm.polls_pub._displayLoader(data.pid);

            fpcm.ajax.post('polls/ajaxpublic', {
                data: data,
                execDone: function (result) {
                    
                    result = fpcm.ajax.fromJSON(result);
                    if (!result.html) {
                        return false;
                    }
                    
                    if (result.code !== 400) {
                        fpcm.ui.addMessage({
                            txt: result.msg,
                            type: result.code < 0 ? 'error' : 'notice'
                        });
                        return false;
                    }

                    jQuery('#fpcm-poll-poll' + data.pid).html(result.html);
                    fpcm.polls_pub._initButtons();
                    fpcm.polls_pub._initVote();
                }
            });

            return false;
        });

    },
    
    _displayLoader: function (pid) {
        jQuery('#fpcm-poll-poll' + pid).html('<div style="position:relative:left:0;right:0;top:0;bottom:0;text-align:center;"><img src="' + fpcm.vars.jsvars.pollspub.spinner + '"></div>');
    }

};