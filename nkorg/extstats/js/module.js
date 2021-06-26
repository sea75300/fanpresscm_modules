if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.extStats = {

    init: function () {
        
        fpcm.extStats.drawList();
        fpcm.extStats.drawChart();

        fpcm.ui.datepicker('#dateFrom', {
            changeMonth: true,
            changeYear: true,
            minDate: fpcm.vars.jsvars.extStats.minDate
        });

        fpcm.ui.datepicker('#dateTo', {
            changeMonth: true,
            changeYear: true
        });

    },

    drawChart: function () {

        if (!fpcm.vars.jsvars.extStats.chart) {
            return true;
        }
        
        window.chart = fpcm.ui_chart.draw(fpcm.vars.jsvars.extStats.chart);
    },

    drawList: function () {

        if (!fpcm.vars.jsvars.extStats.hasList) {
            return true;
        }

        if (fpcm.dataview !== undefined) {
            fpcm.dataview.render('extendedstats-list');
        }

        jQuery('.fpcm-extstats-links-delete').unbind('click');
        jQuery('.fpcm-extstats-links-delete').click(function () {
            
            var btnParent = jQuery(this).parent().parent();
            fpcm.ajax.post('extstats/delete', {
                data: {
                    id: jQuery(this).data('entry'),
                    obj: fpcm.vars.jsvars.extStats.delList
                },
                execDone: function (result) {

                    if (!result.code) {
                        return false;
                    }

                    jQuery(btnParent).remove();
                }
            });

            return false;
        });

    },

};