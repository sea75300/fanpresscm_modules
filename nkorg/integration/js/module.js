if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_integration = {

    init: function() {

        fpcm.dom.bindClick('#btnProcess', function () {
            fpcm.nkorg_integration.processArticles();
            fpcm.nkorg_integration.processTitle();            
            return false;
        });

    },
    
    processArticles: function () {

        let _lists = [
            {
                dest: 'functionParams',
                pref: 'article'
            },
            {
                dest: 'functionParamsLatest',
                pref: 'latest'
            }
        ];
        
        for (var i = 0; i < _lists.length; i++) {
            
            fpcm.dom.assignText('#'+_lists[i].dest, '');

            var data = '[';

            var count = jQuery('#' + _lists[i].pref + 'count').val();
            if (count !== fpcm.vars.jsvars.articlesDefault) {
                data += "\n";
                data += "   'count' => " + parseInt(count) + ",";
            }

            var category = parseInt(jQuery('#' + _lists[i].pref + 'category').val());
            if (category) {
                data += "\n";
                data += "   'category' => " + category + ",";
            }

            var encoding = parseInt(jQuery('#' + _lists[i].pref + 'encoding').val());
            if (!encoding) {
                data += "\n";
                data += "   'isUtf8' => false,";
            }

            var template = jQuery('#' + _lists[i].pref + 'template').val();
            if (template) {
                data += "\n";
                data += "   'template' => '" + template + "',";
            }

            if (data.length > 1) {
                data += "\n]";
                fpcm.dom.assignText('#'+ _lists[i].dest, data);
            }
        }

        
        return true;
    },

    processTitle: function () {

        let _lists = [
            'titlePages',
            'titleHl'
        ];
        
        for (var i = 0; i < _lists.length; i++) {
            
            let prefix = _lists[i];
            
            fpcm.dom.assignText('#functionParams' + prefix + '1', '');
            fpcm.dom.assignText('#functionParams' + prefix + '2', '');

            fpcm.dom.assignText('#functionParams' + prefix + '1', jQuery('#' + prefix + 'delimited').val());
            fpcm.nkorg_integration.titleHlParam1 = true

            var encoding = parseInt(jQuery('#' + prefix + 'encoding').val());
            if (!encoding) {
                fpcm.dom.assignText('#functionParams' + prefix + '2', fpcm.nkorg_integration.titleHlParam1 ? ', false' : 'false');
            }
        }

        
        return true;
    }

};