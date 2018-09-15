<?php

/**
 * Example module language file
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
$lang = [
    'HEADLINE' => 'Integrationsassistent',
    'GERNERALNOTES' => 'Allgemeine Hinweise',
    'INCLUDE_API' => 'API-Klasse einbinden',
    'CSS_STYLES' => 'CSS-Klassen für Gestaltung',
    'SHOW_ARTICLES' => 'Anzeige von Artikeln',
    'SHOW_LATESTNEWS' => 'Anzeige von Latest News',
    'SHOW_PAGENUMBERS' => 'Anzeige von Seiten-Zahlen im Seitentitel',
    'SHOW_ARTICLETITLE' => 'Anzeige von Artikel-Überschriften im Seitentitel',
    'USE_RSS' => 'RSS-Feed verwenden',
    'TEXT_NOTES' => 'Dieses Module hilft dir bei der Integration von FanPress CM 4.x in deine Seite. Sollten trotz der Beschreibungen noch Fragen bestehen, nutze bitte eine der ' .
    'in unter Kontakt und Support angegebenen Möglichkeiten!!',
    'TEXT_API' => 'Wenn du deine Seite mittels PHP include verwendest, binde wie im Beispiel beschrieben die API-Datei aus dem FanPress-Verzeichnis z. B. iun deiner index.php' .
    ' ein und erzeuge dann ein neues API-Objekt.',
    'TEXT_CSS' => 'Zur Gestaltung der Frontend-Ausgabe stellt FanPress CM folgende CSS-Klassen zur Verfügung zusätzliche zu eigenen Klassen z. B. aus deinen'
    . ' Templates. Für diese Klasse in die CSS-Datei <em>{{cssPath}}</em> ein.',
    
    'TEXT_SHOWARTICLES_HEADLINE' => 'Füge an die Stelle, an der du deine verfassten Artikel ausgeben lassen willst folgenden Code ein. Die Umgebenden DIV-Box kannst du u. U. weglassen.',
    'TEXT_SHOWARTICLES_COUNT' => 'Trage die Anzahl an Artikeln ein, welche angezeigt werden sollen',
    'TEXT_SHOWARTICLES_CATEGORY' => 'Kategorie',
    'TEXT_SHOWARTICLES_TEMPLATENAME' => 'Template',
    'TEXT_SHOWARTICLES_ENCODING' => 'utf8-Kodierung',
    
    'TEXT_SHOWLATEST_HEADLINE' => 'Füge an die Stelle, an der du die "Latest News" ausgeben lassen willst folgenden Code ein. Die Umgebenden DIV-Box kannst du u. U. weglassen.',
    'TEXT_RSSFEED'        => 'Um den RSS-Feed zu verwenden, füge einfach folgenden Link-Code in deine Seite ein.',
    
    'TEXT_SHOWTITLE_DELIMITER'     => 'Text, welcher als Trennzeichen zum restlichen Title-Tag dienen soll',
    'TEXT_SHOWTITLE_HEADLINE'     => 'Füge in der Datei, welche das &lt;title&gt;-Tag deiner Seite enthält, folgenden Code zwischen &lt;title&gt; und &lt;/title&gt; ein. '.
                                               'Dies kann deine index.php, header.php, o. ä. sein.',
    
    'NOTIFICATION_PHPMODE' => 'Verwendung per PHP include',
    'NOTIFICATION_IFRAMEMODE' => 'Verwendung per iFrame',
];
