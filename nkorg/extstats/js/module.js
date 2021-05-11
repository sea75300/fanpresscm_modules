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
                    return;
                }

                fpcm.dom.fromId('fpcm-nkorg-extendedstats-chart').empty();

                fpcm.vars.jsvars.extStats.chart.type = this.value;
                fpcm.vars.jsvars.extStats.chart.options.legend.display = ((this.value === 'line' || this.value === 'bar') ? false : true);
                fpcm.extStats.drawChart();
            }

        });

        fpcm.ui.selectmenu('#chartMode', {
            classes: {
                'ui-selectmenu-button' : fpcm.vars.jsvars.extStats.showMode ? '' : 'fpcm-ui-hidden'
            }
        });

        fpcm.ui.selectmenu('#source', {
            change: function (event, ui) {
                
                var noModes = ['shares' , 'links' , 'referrer'];
                if (noModes.includes(ui.item.value)) {
                    jQuery('#chartMode-button').hide();
                }
                else {
                    jQuery('#chartMode-button').show();
                }

                if (ui.item.value == 'links' || ui.item.value == 'referrer') {
                    jQuery('#fpcm-nkorg-extendedstats-dateform').hide();
                }
                else {
                    jQuery('#fpcm-nkorg-extendedstats-dateform').show();
                }
                
                fpcm.ui.controlgroup(fpcm.ui.mainToolbar, 'refresh');
            }
        });

    },

    drawChart: function () {

        if (window.chart) {
            window.chart.destroy();
        }

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