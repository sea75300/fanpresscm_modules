if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.moduleConfig = {

    init: function () {
        fpcm.ui.selectmenu('.fpcm-ui-input-select',{
            removeCornerLeft: true
        });
    },
    
    initAfter: function() {

    }

};