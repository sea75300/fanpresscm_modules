<?php /* @var $theView \fpcm\view\viewVars */ ?>
<?php /* @var $appointment fpcm\modules\nkorg\calendar\models\appointment */ ?>
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
    <?php $theView
            ->dateTimeInput("appointmentdata[datetime]")
            ->setText('Datum und Uhrzeit')
            ->setValue($appointment->getDatetime())
            ->setWrapper(false)
            ->setDisplaySizesDefault()
            ->setNativeDateTime(); ?>
</div>
<div class="row my-3 mx-1">
    <?php $theView
            ->checkbox("appointmentdata[pending]")
            ->setText('Termin steht fest')
            ->setValue(1)
            ->setSelected($appointment->getPending())
            ->setDisplaySizesDefault(); ?>
</div>
<div class="row my-3 mx-1">
    <?php $theView
            ->checkbox("appointmentdata[visible]")
            ->setText('Termin ist sichtbar')
            ->setValue(1)
            ->setSelected($appointment->getVisible())
            ->setDisplaySizesDefault(); ?>
</div>