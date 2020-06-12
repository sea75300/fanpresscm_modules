if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.dashboard.onDone.extstatsChartData = {

    execAfter: function () {

        if (fpcm.vars.jsvars.extstatsChartData === undefined) {
            return false;
        }

        fpcm.ui_chart.draw({
            id: 'fpcm-nkorg-extstats-dashchart',
            type: 'bar',
            data: fpcm.vars.jsvars.extstatsChartData,
            options: {
                responsive: true
            }
        });

        return true;
    }

};