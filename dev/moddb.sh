#!/usr/bin/php
<?php

if (PHP_SAPI != "cli") {
    exit('CLI only!');
}

if (!isset($argv)) {
    $argv = [];
}

require_once 'Spyc.php';

$path = __DIR__.'/modules.db';
if (!file_exists($path) || !is_readable($path)) {
    exit('Sqlite db file not available or readable!'.PHP_EOL.PHP_EOL);
}

$db = new SQLite3($path);

$query = 'SELECT * FROM modules WHERE active = 1 AND modkey NOT NULL';
$params = [];

$hasSystem = array_search('--system', $argv);
if ($hasSystem !== false) {

    $params['ver'] = $argv[$hasSystem+1] ?? false;
    if ($params['ver']) {
        $query .= ' AND req_system >= :ver';
    }

}

$query .= ' ORDER BY modkey ASC';

$statement = $db->prepare($query);
if (isset($params['ver']) && $params['ver']) {
    $statement->bindParam(':ver', $params['ver']);
}

print "Fetch $query".PHP_EOL.PHP_EOL;

$result = $statement->execute();
if (!$result->numColumns()) {
    exit('No module data available!'.PHP_EOL.PHP_EOL);
}

$releases = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {

    $releases[$row['modkey']] = [
        'packageUrl' => $row['packageUrl'],
        'signature' => $row['signature'],
        'hash' => $row['hash'],
        'author' => $row['author'],
        'name' => $row['name'],
        'description' => $row['description'],
        'link' => $row['link'],
        'version' => $row['version'],
        'requirements' => [
            'system' => $row['req_system'],
            'php' => $row['req_php']
        ]
    ];

}

$destPos = array_search('--dest', $argv);
if ($hasSystem !== false) {
    $dest = $argv[$destPos+1] ?? '';
}

$yamlPath = __DIR__.'/release'.($dest ?? '').'.yml';
if ( !file_put_contents($yamlPath, '## FanPress CM module package source data'.PHP_EOL.Spyc::YAMLDump($releases)) ) {
    exit('Failed to create '.$yamlPath.'!'.PHP_EOL.PHP_EOL);
}

file_put_contents(__DIR__.'/test.txt', var_export(spyc_load_file($yamlPath), true));
exit('Release file created within '.$yamlPath.'!'.PHP_EOL.PHP_EOL);

