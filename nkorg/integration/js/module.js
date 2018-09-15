if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_integration = {

    init: function() {
        
        fpcm.ui.controlgroup('#fpcm-ui-integration-modes');
        fpcm.nkorg_integration.accordion = fpcm.ui.accordion('#fpcm-ui-integration-items');
        
        jQuery('#btnProcess').click(function () {
            switch (fpcm.nkorg_integration.getActiveItem()) {
                case 3 :
                case 4 :
                    fpcm.nkorg_integration.processArticles();
                    break;

                case 5 :
                case 6 :
                    fpcm.nkorg_integration.processTitle();
                    break;
            }
            
            
            return false;
            
        });
    },
    
    processArticles: function () {

        var item = fpcm.nkorg_integration.getActiveItem();

        if (item === 3) {
            var itemDestination = 'functionParams';
            var prefix = 'article';
        }
        else if (item === 4) {
            var itemDestination = 'functionParamsLatest';
            var prefix = 'latest';
        }

        fpcm.ui.assignText('#'+itemDestination, '');

        var data = '[';

        var count = jQuery('#' + prefix + 'count').val();
        if (count !== fpcm.vars.jsvars.articlesDefault) {
            data += "\n";
            data += "   'count' => " + parseInt(count) + ",";
        }

        var category = parseInt(jQuery('#' + prefix + 'category').val());
        if (category) {
            data += "\n";
            data += "   'category' => " + category + ",";
        }

        var encoding = parseInt(jQuery('#' + prefix + 'encoding').val());
        if (!encoding) {
            data += "\n";
            data += "   'isUtf8' => false,";
        }

        if (item === 3) {
            var template = jQuery('#' + prefix + 'template').val();
            if (template) {
                data += "\n";
                data += "   'template' => '" + template + "',";
            }
        }

        if (data.length > 1) {
            data += "\n]";
            fpcm.ui.assignText('#'+itemDestination, data);
        }
        
        return true;
    },

    processTitle: function () {
        
        var item = fpcm.nkorg_integration.getActiveItem();

        if (item === 5) {
            var prefix = 'titlePages';
        }
        else if (item === 6) {
            var prefix = 'titleHl';
        }

        fpcm.ui.assignText('#functionParams' + prefix + '1', '');
        fpcm.ui.assignText('#functionParams' + prefix + '2', '');

        fpcm.ui.assignText('#functionParams' + prefix + '1', jQuery('#' + prefix + 'delimited').val());
        fpcm.nkorg_integration.titleHlParam1 = true

        var encoding = parseInt(jQuery('#' + prefix + 'encoding').val());
        if (!encoding) {
            fpcm.ui.assignText('#functionParams' + prefix + '2', fpcm.nkorg_integration.titleHlParam1 ? ', false' : 'false');
        }
        
        return true;
    },
    
    getActiveItem: function () {
        return parseInt(fpcm.nkorg_integration.accordion.accordion('option', 'active'));
    }

};