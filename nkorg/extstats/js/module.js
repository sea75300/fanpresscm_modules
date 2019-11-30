if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.extStats = {

    init: function () {
        
        fpcm.extStats.drawList();
        fpcm.extStats.drawChart(fpcm.vars.jsvars.extStats.chartType);

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
                jQuery('#fpcm-nkorg-extendedstats-chart').empty();
                fpcm.extStats.drawChart(jQuery(this).val());
            }

        });

        fpcm.ui.selectmenu('#chartMode', {
            classes: {
                'ui-selectmenu-button' : fpcm.vars.jsvars.extStats.showMode ? '' : 'fpcm-ui-hidden'
            }
        });

        fpcm.ui.selectmenu('#source', {
            change: function (event, ui) {
                
                var noModes = ['shares' , 'links'];
                if (noModes.includes(ui.item.value)) {
                    jQuery('#chartMode-button').hide();
                }
                else {
                    jQuery('#chartMode-button').show();
                }

                if (ui.item.value == 'links') {
                    jQuery('#fpcm-nkorg-extendedstats-dateform').hide();
                }
                else {
                    jQuery('#fpcm-nkorg-extendedstats-dateform').show();
                }
                
                fpcm.ui.controlgroup(fpcm.ui.mainToolbar, 'refresh');
            }
        });

    },

    drawChart: function (type) {

        if (window.chart) {
             window.chart.destroy();
        }

        if (!fpcm.vars.jsvars.extStats.chartValues.datasets) {
            return true;
        }

        if (fpcm.vars.jsvars.extStats.chartValues.datasets[0].borderWidth = (type === 'line' ? 5 : 0)) {
            fpcm.vars.jsvars.extStats.chartValues.datasets[0].borderWidth = (type === 'line' ? 5 : 0);
        }
        
        if (fpcm.vars.jsvars.extStats.chartValues.datasets[1]) {
            fpcm.vars.jsvars.extStats.chartValues.datasets[1].borderWidth = (type === 'line' ? 5 : 0);
        }

        var isBarOrLine = (type === 'line' || type === 'bar');

        var chartOptions = {
            legend: {
                display: (isBarOrLine ? false : true),
                position: 'right',
                labels: {
                    boxWidth: 25,
                    fontSize: 12
                }
            },
            responsive: true
        }

        if (isBarOrLine) {

            chartOptions.scales = {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
            };

        }

        window.chart = new Chart(jQuery('#fpcm-nkorg-extendedstats-chart'), {
            type: type,
            data: fpcm.vars.jsvars.extStats.chartValues,
            options: chartOptions
        });
    },

    drawList: function () {

        if (!fpcm.vars.jsvars.extStats.showDate || !fpcm.vars.jsvars.extStats.chartValues.datasets || !fpcm.vars.jsvars.extStats.chartValues.datasets[0]) {
            return true;
        }

        var elList = jQuery('#fpcm-nkorg-extendedstats-list');
        var btnDelEl = '';
        var btnOpenEl = '';
        
        jQuery.each(fpcm.vars.jsvars.extStats.chartValues.listValues, function (index, object) {
            btnDelEl = fpcm.vars.jsvars.extStats.deleteButtonStr;
            btnOpenEl = fpcm.vars.jsvars.extStats.openButtonStr;
            
            elList.append(
                '<div class="row my-1">' +
                '<div class="col-1 align-self-center">' + 
                    btnOpenEl.replace('_{$id}', object.intid).replace('{$url}', object.fullUrl) +
                    btnDelEl.replace('_{$id}', object.intid).replace('{$id}', object.intid) +
                    
                '</div><div class="col align-self-center">' + object.label +
                '</div><div class="col-1 align-self-center">' + object.value +
                '</div><div class="col-3 align-self-center">' + fpcm.ui.translate('MODULE_NKORGEXTSTATS_HITS_LIST_LATEST') + ': ' + object.latest +
                '</div></div>'
            );
        });

        jQuery('.fpcm-extstats-links-delete').click(function () {
            
            var btnParent = jQuery(this).parent().parent();
            fpcm.ui.showLoader(1);
            fpcm.ajax.exec('extstats/delete', {
                data: {
                    id: jQuery(this).data('entry')
                },
                execDone: function (result) {
                    
                    if (result == 0) {
                        return false;
                    }

                    jQuery(btnParent).remove();
                    fpcm.ui.showLoader(0);
                }
            });

            return false;
        });

    }

};