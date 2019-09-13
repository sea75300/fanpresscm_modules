if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.moduleConfig = {

    init: function () {
        fpcm.ui.selectmenu('#configmodule_nkorgpolls_show_latest_poll',{
            removeCornerLeft: true
        });
    },
    
    initAfter: function() {

    }

};