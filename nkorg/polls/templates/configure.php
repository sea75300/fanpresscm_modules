<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="fpcm-content-wrapper">
    <div class="fpcm-ui-tabs-general">
        <ul>
            <li><a href="#tabs-config"><?php $theView->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
        </ul>            

        <div id="tabs-user">                
            <div class="row my-3 mx-1">
                <div class="col-12">
                    <fieldset>
                        <legend><?php $theView->write('Templates bearbeiten'); ?></legend>
                        Um die Anzeige anzupassen, erstelle im FanPress CM-Unterordner
                        <em>/data/nkorg_polls/templates</em> eine Kopie der jeweiligen
                        Datei mit der Endung <em>.custom.html</em>.
                        <dl>
                            <dt>voteform_header.html</dt>
                            <dd class="mb-1">Kopfzeile einer Umfrage im Votingformular</dd>
                            <dt>voteform_line.html</dt>
                            <dd class="mb-1">Zeile einer Antwort im Votingformular</dd>
                            <dt>voteform_footer.html</dt>
                            <dd class="mb-1">Fußzeile im Votingformular</dd>
                            <dt>result_header.html</dt>
                            <dd class="mb-1">Kopfzeile einer Umfrage im Ergebnisformular</dd>
                            <dt>result_line.html</dt>
                            <dd class="mb-1">Zeile einer Antwort im Ergebnisformular</dd>
                            <dt>result_footer.html</dt>
                            <dd class="mb-1">Fußzeile im Ergebnisformular</dd>
                            <dt>archive_footer.html</dt>
                            <dd class="mb-1">Fußzeile im Archiv</dd>
                        </dl>
                    </fieldset>
                </div>
            </div>

            <div class="row my-3 mx-1">
                <div class="col-12">
                    <div class="row">
                        <label class="col-12 col-sm-6 col-md-3 fpcm-ui-field-label-general">
                            <?php $theView->icon('language'); ?>
                            <?php $theView->write('Standardmäßig aktuellste Umfrage anzeigen'); ?>:
                        </label>
                        <div class="col-auto fpcm-ui-padding-none-lr">
                            <?php $theView->boolSelect("config[module_nkorgpolls_show_latest_poll]")
                                    ->setSelected($options['module_nkorgpolls_show_latest_poll'])
                                    ->setData(['remove_corner_left' => 1]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>