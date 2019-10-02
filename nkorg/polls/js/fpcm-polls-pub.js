if (fpcm === undefined) {
    var fpcm = {
        vars: {
            jsvars: {}
        }
    };
}

if (typeof window.onload === 'function') {
    window.onload();
}

window.onload = function () {

    if (typeof jQuery !== 'undefined') {
        fpcm.polls_pub = {

            init: function () {

                fpcm.polls_pub._initVote();
                fpcm.polls_pub._initButtons();
            },

            _initVote: function () {

                jQuery('button.fpcm-polls-poll-submit').unbind('click');
                jQuery('button.fpcm-polls-poll-reset').unbind('click');

                jQuery('button.fpcm-polls-poll-submit').click(function () {

                    var data = {
                        rids: [],
                        pid: 0,
                        fn: 'vote'
                    };

                    data.pid = jQuery(this).data('pollid');
                    if (!data.pid) {
                        return false;
                    }


                    jQuery('input.fpcm-polls-poll' + data.pid + '-option:checked').each(function (key, obj) {
                        data.rids.push(parseInt(obj.value));
                    });

                    if (!data.rids.length) {
                        return false;
                    }

                    fpcm.polls_pub._displayLoader(data.pid);
                    fpcm.polls_pub._execAjax({
                        action: 'ajaxpublic',
                        data: data
                    });

                    return false;
                });

                jQuery('button.fpcm-polls-poll-reset').click(function () {

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

                jQuery('button.fpcm-polls-poll-result').click(function () {

                    var data = {
                        pid: 0,
                        fn: 'result'
                    };

                    data.pid = jQuery(this).data('pollid');
                    if (!data.pid) {
                        return false;
                    }

                    fpcm.polls_pub._displayLoader(data.pid);
                    fpcm.polls_pub._execAjax({
                        action: 'ajaxpublic',
                        okCode: 300,
                        data: data,
                        onDone: function () {
                            fpcm.polls_pub._initButtons();
                        }
                    });

                    return false;
                });

                jQuery('button.fpcm-polls-poll-form').click(function () {

                    var data = {
                        pid: 0,
                        fn: 'pollForm'
                    };

                    data.pid = jQuery(this).data('pollid');
                    if (!data.pid) {
                        return false;
                    }

                    fpcm.polls_pub._displayLoader(data.pid);
                    fpcm.polls_pub._execAjax({
                        action: 'ajaxpublic',
                        okCode: 400,
                        data: data,
                        onDone: function () {
                            fpcm.polls_pub._initButtons();
                            fpcm.polls_pub._initVote();
                        }
                    });

                    return false;
                });

            },

            _displayLoader: function (pid) {
                jQuery('#fpcm-poll-poll' + pid).html('<div style="position:relative:left:0;right:0;top:0;bottom:0;text-align:center;"><img src="' + fpcm.vars.jsvars.pollspub.spinner + '"></div>');
            },

            _displayMsg: function (msgData) {

                if (!fpcm.pub) {
                    alert(msgData.msg);
                    return true;
                }

                fpcm.pub.addMessage({
                    id: msgData.msgId,
                    txt: msgData.msg,
                    type: msgData.code < 0 ? 'error' : 'notice'
                });
            },

            _execAjax: function (params) {

                jQuery.ajax({
                    url: fpcm.vars.jsvars.pollspub.actionPath + params.action,
                    type: 'POST',
                    data: params.data,
                    async: false,
                    statusCode: {
                        500: function () {
                            alert('Während der Anfrage ist ein Fehler aufgetreten!');
                        },
                        404: function () {
                            alert('Das Zeil der Anfrage wurde nicht gefunden!');
                        }
                    }
                })
                .done(function (result) {

                    if (result.search('FATAL ERROR:') === 3) {
                        alert('Während der Anfrage ist ein Fehler aufgetreten!');
                        console.error('ERROR MESSAGE: ' + errorThrown + '\n\n STATUS MESSAGE: ' + textStatus);
                        return false;
                    }

                    result = JSON.parse(result);

                    if (result.code !== params.okCode) {
                        result.msgId = params.data.fn + 'pid' + params.data.pid + (new Date()).getTime();
                        fpcm.polls_pub._displayMsg(result);
                    }

                    if (result.html !== undefined) {
                        jQuery('#fpcm-poll-poll' + params.data.pid).html(result.html);
                    }

                    if (!params.onDone) {
                        return false;
                    }

                    params.onDone(result);
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error('ERROR MESSAGE: ' + errorThrown + '\n\n STATUS MESSAGE: ' + textStatus);
                });
            }

        };

        fpcm.polls_pub.init();

    } else {
        console.error('jQuery is no loaded! Check if you included the libary in your page header or enable inclusion in FanPress CM ACP.');
    }

}