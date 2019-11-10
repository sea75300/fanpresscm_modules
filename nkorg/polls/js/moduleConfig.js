if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.moduleConfig = {

    init: function () {
        fpcm.ui.selectmenu('#configmodule_nkorgpolls_show_latest_poll',{
            removeCornerLeft: true
        });
        fpcm.ui.selectmenu('#configmodule_nkorgpolls_chart_type',{
            removeCornerLeft: true
        });
    },
    
    initAfter: function() {

    }

};