if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_inactivity_manager = {

    init: function() {
        
        if (fpcm.dataview && fpcm.dataview.exists('messageslist')) {
            fpcm.dataview.render('messageslist');
        }

    }

};