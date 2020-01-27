<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php /* @var $appointment fpcm\modules\nkorg\calendar\models\appointment */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general ui-tabs ui-corner-all ui-widget ui-widget-content">
        <ul class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
            <?php print $theView->tabItem('appointment')->setText('MODULE_NKORGCALENDAR_GUI_APPOINTMENT_TAB')->setUrl('#appointment'); ?>
        </ul>            

        <div id="tabs-appointment" class="fpcm tabs-register ui-tabs-panel ui-corner-bottom ui-widget-content">

            <div class="row my-3 mx-1">
                <?php $theView
                        ->dateTimeInput("appointmentdata[date]")
                        ->setText('MODULE_NKORGCALENDAR_GUI_APPOINTMENT_DATETIME')
                        ->setValue(date('Y-m-d', $appointment->getDatetime()))
                        ->setWrapper(false)
                        ->setDisplaySizes(['xs' => 12, 'sm' => 6, 'md' => 3], ['xs' => 12, 'sm' => 6, 'md' => 3])
                        ->setNativeDate(); ?>

                <?php $theView
                        ->dateTimeInput("appointmentdata[time]")
                        ->setText('')
                        ->setValue(date('H:i', $appointment->getDatetime()))
                        ->setWrapper(false)
                        ->setDisplaySizes(['xs' => 12, 'sm' => 6, 'md' => 3], ['xs' => 12, 'sm' => 6, 'md' => 3])
                        ->setClass('ml-1 fpcm-ui-border-radius-all')
                        ->setNativeTime(); ?>
            </div>

            <div class="row my-3 mx-1">
                <?php $theView
                        ->textInput("appointmentdata[description]")
                        ->setText('Beschreibung')
                        ->setSize(255)
                        ->setValue($appointment->getDescription())
                        ->setWrapper(false)
                        ->setDisplaySizesDefault(); ?>
            </div>

            <div class="row my-3 mx-1">
                
                <label class="col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general">
                    <?php $theView->write('MODULE_NKORGCALENDAR_GUI_APPOINTMENT_PENDING'); ?>
                </label>

                <div class="col-12 col-sm-6 col-md-9 fpcm-ui-padding-none-lr">
                    <?php $theView
                            ->boolSelect("appointmentdata[pending]")
                            ->setValue(1)
                            ->setSelected($appointment->getPending()); ?>
                </div>

            </div>

            <div class="row my-3 mx-1">
                
                <label class="col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general">
                    <?php $theView->write('MODULE_NKORGCALENDAR_GUI_APPOINTMENT_VISIBLE'); ?>
                </label>

                <div class="col-12 col-sm-6 col-md-9 fpcm-ui-padding-none-lr">
                    <?php $theView
                            ->boolSelect("appointmentdata[visible]")
                            ->setValue(1)
                            ->setSelected($appointment->getVisible()); ?>
                </div>

            </div>
        </div>
    </div>
</div>