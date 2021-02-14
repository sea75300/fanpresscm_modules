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
        
        elList.append(fpcm.extStats.getHeader(fpcm.vars.jsvars.extStats.chartValues.listValues[0]));
        
        jQuery.each(fpcm.vars.jsvars.extStats.chartValues.listValues, function (index, object) {
            elList.append(fpcm.extStats.getRow(object));
        });

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
    
    getHeader: function (_object) {

        let _return =   '<div class="row my-1">' +
                        '<div class="col-4 col-md-1 align-self-center">' + 
                        '</div><div class="col-4 align-self-center"><b>' + fpcm.ui.translate('MODULE_NKORGEXTSTATS_HITS_LIST_LINK') + '</b>' +
                        '</div><div class="col-1 align-self-center"><b>' + fpcm.ui.translate('MODULE_NKORGEXTSTATS_HITS_LIST_COUNT') + '</b>' +
                        '</div><div class="col-1 align-self-center"><b>' + fpcm.ui.translate('MODULE_NKORGEXTSTATS_HITS_LIST_LATEST') + '</b>';
        
        if (_object.src === 'referrer') {
            return _return + '</div></div>';
        }
        
        _return +=  '</div><div class="col-2 align-self-center"><b>' + fpcm.ui.translate('MODULE_NKORGEXTSTATS_HITS_LIST_IP') + '</b>' +
                    '</div><div class="col-3 align-self-center"><b>' + fpcm.ui.translate('MODULE_NKORGEXTSTATS_HITS_LIST_USERAGENT') + '</b>' +
                    '</div></div>';

        return _return;

    },
    
    getRow: function (_object) {
        
        let btnDelEl = fpcm.vars.jsvars.extStats.deleteButtonStr;
        let btnOpenEl = fpcm.vars.jsvars.extStats.openButtonStr;        
        
        let _return =   '<div class="row my-1">' +
                        '<div class="col-4 col-md-1 align-self-center">' + 
                            btnOpenEl.replace('_{$id}', _object.intid).replace('{$url}', _object.fullUrl) +
                            btnDelEl.replace('_{$id}', _object.intid).replace('{$id}', _object.intid) +
                    
                        '</div><div class="col-4 align-self-center">' + _object.label +
                        '</div><div class="col-1 align-self-center">' + _object.value +
                        '</div><div class="col-1 align-self-center">' + _object.latest;
        
        if (_object.src === 'referrer') {
            return _return + '</div></div>';
        }
        
        _return +=  '</div><div class="col-2 align-self-center">' + (_object.lastip ? _object.lastip : fpcm.ui.translate('GLOBAL_NOTFOUND')) +
                    '</div><div class="col-3 align-self-center">' + (_object.lastagent ? _object.lastagent : fpcm.ui.translate('GLOBAL_NOTFOUND')) +
                    '</div></div>';

        return _return;

    }

};