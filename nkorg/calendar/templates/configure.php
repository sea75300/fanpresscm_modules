<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        <ul>
            <li><a href="#tabs-config"><?php $theView->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
        </ul>            

        <div id="tabs-config">                            
            <div class="row">
                <?php $theView->textInput("config[module_nkorgcalendar_frontend_days]")
                        ->setText('MODULE_NKORGCALENDAR_GUI_APPOINTMENT_FRONTEND_DAYS')
                        ->setValue($options['module_nkorgcalendar_frontend_days'])
                        ->setWrapper(false)
                        ->setType('number')
                        ->setIcon('calendar')
                        ->setSize('lg')
                        ->setDisplaySizesDefault(); ?>
            </div>
        </div>
    </div>
</div>