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

        fpcm.ui.selectmenu('#chartType', {
            change: function () {

                if (!fpcm.vars.jsvars.extStats.chart) {
                    return true;
                }

                fpcm.extStats.drawChart(this.value);
            }

        });

    },

    drawChart: function (type) {

        if (!fpcm.vars.jsvars.extStats.chart) {
            return true;
        }
        
        if (window.chart) {
            window.chart.destroy();
        }

        let _cnf = fpcm.vars.jsvars.extStats.chart;        
        if (type) {
            _cnf.type = type;
            delete(_cnf.options.legend);
            delete(_cnf.options.scales);
        }
        
        window.chart = fpcm.ui_chart.draw(_cnf);
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