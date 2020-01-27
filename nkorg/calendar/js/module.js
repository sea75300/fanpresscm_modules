if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.calendar = {

    init: function () {

        fpcm.ui.selectmenu('.fpcm-ui-input-select', {
            removeCornerLeft: true
        });

    },
    
    initAfter: function() {

        if (fpcm.dataview !== undefined) {
            fpcm.dataview.render('nkorgcalendar');
        }

    }

};