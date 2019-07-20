if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.polls = {

    replyOptionsStart: 3,
    replyOptionsIdSlug: 'fpcm-nkorgpolls-reply-',

    init: function () {
        
        jQuery('#btnAddReplyOption').click(function () {
            var newEl = jQuery('div.fpcm-ui-nkorgpolls-replyline').last().clone();
            fpcm.polls.replyOptionsStart++;

            jQuery(newEl).attr('id', fpcm.polls.replyOptionsIdSlug + fpcm.polls.replyOptionsStart).appendTo('#tabs-replies');
            jQuery(newEl).find('label span').text('Antwort ' + fpcm.polls.replyOptionsStart);
            jQuery(newEl).find('input').val('');
            jQuery(newEl).find('button.fpcm-ui-nkorgpolls-removereply').data('idx', fpcm.polls.replyOptionsStart);

            jQuery('.fpcm-ui-nkorgpolls-removereply').unbind('click');
            fpcm.polls.initDeleteButtonAction();
            return false;
        });

        fpcm.polls.initDeleteButtonAction();
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
            if (!btnIdx || btnIdx > fpcm.polls.replyOptionsStart || fpcm.polls.replyOptionsStart == 1) {
                return false;
            }
            
            jQuery('#' + fpcm.polls.replyOptionsIdSlug + btnIdx).remove();
            fpcm.polls.replyOptionsStart--;
            
            var replyItems = jQuery('div.fpcm-ui-nkorgpolls-replyline');
            jQuery.each(replyItems, function (idx, obj) {

                idx = (idx + 1);

                jQuery(obj)
                    .attr('id', fpcm.polls.replyOptionsIdSlug + idx)
                    .find('label span').text('Antwort ' + idx)
                    .find('button.fpcm-ui-nkorgpolls-removereply').data('idx', idx);
                
            });
            
                    
            
            return false;
        });
    }

};