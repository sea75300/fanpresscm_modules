if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.polls = {

    replyOptionsStart: 0,
    replyOptionsIdSlug: 'fpcm-nkorgpolls-reply-',

    init: function () {
        
        fpcm.polls.replyOptionsStart = fpcm.vars.jsvars.replyOptionsStart;
        
        jQuery('#btnAddReplyOption').click(function () {
            fpcm.polls.replyOptionsStart++;
            jQuery('div.fpcm-ui-nkorgpolls-replyline').last().clone().attr('id', fpcm.polls.replyOptionsIdSlug + fpcm.polls.replyOptionsStart).appendTo('#tabs-replies');

            var id = '#' + fpcm.polls.replyOptionsIdSlug + fpcm.polls.replyOptionsStart;
            jQuery(id).find('label span').text('Antwort ' + fpcm.polls.replyOptionsStart);
            jQuery(id).find('input').val('');
            jQuery(id).find('input').attr('id', 'polldatareplies' + fpcm.polls.replyOptionsStart);
            jQuery(id).find('input[type=text]').attr('id', 'polldatareplies' + fpcm.polls.replyOptionsStart);
            jQuery(id).find('input[type=hidden]').attr('id', 'polldataids' + fpcm.polls.replyOptionsStart);
            jQuery(id).find('button.fpcm-ui-nkorgpolls-removereply').attr('data-idx', fpcm.polls.replyOptionsStart);
            jQuery('.fpcm-ui-nkorgpolls-removereply').unbind('click');
            fpcm.polls.initDeleteButtonAction();
            return false;
        });

        fpcm.polls.initDeleteButtonAction();
        jQuery('.fpcm-ui-input-select').selectmenu( "option", "classes.ui-selectmenu-button", "fpcm-ui-border-radius-right" );
    },
    
    initAfter: function() {
        
        if (fpcm.dataview === undefined) {
            return true;
        }
        
        fpcm.dataview.render('nkorgpolls');
        
    },
    
    initDeleteButtonAction: function () {

        jQuery('.fpcm-ui-nkorgpolls-removereply').click(function () {
            
            var btnIdx = jQuery(this).data('idx');
            if (jQuery('.fpcm-ui-nkorgpolls-removereply').length < 2) {
                return false;
            }
            
            jQuery('#' + fpcm.polls.replyOptionsIdSlug + btnIdx).remove();
            fpcm.polls.replyOptionsStart--;
            
            var replyItems = jQuery('div.fpcm-ui-nkorgpolls-replyline');
            jQuery.each(replyItems, function (idx, obj) {

                idx = (idx + 1);

                jQuery(obj).attr('id', fpcm.polls.replyOptionsIdSlug + idx);
                jQuery(obj).find('label span').text('Antwort ' + idx);
                jQuery(obj).find('input[type=text]').attr('id', 'polldatareplies' + idx);
                jQuery(obj).find('input[type=hidden]').attr('id', 'polldataids' + idx);
                jQuery(obj).find('button.fpcm-ui-nkorgpolls-removereply').attr('data-idx', idx);
                
            });
            
                    
            
            return false;
        });
    }

};