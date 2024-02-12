#!/usr/bin/php
<?php

if (PHP_SAPI != "cli") {
    exit('CLI only!');
}

if (!isset($argv)) {
    $argv = [];
}


$path = $argv[1] ?? '';
$pkg_build  = rtrim($argv[2] ?? '', '/');
$dest = $argv[3] ?? '';

if (!$path) {
    exit('Missing path as first parameter'.PHP_EOL.PHP_EOL);
}

$path = realpath($path);
if (!trim($path)) {
    exit('Path '.$path.' does not exists'.PHP_EOL.PHP_EOL);
}

$path .= '/*/module.yml';

$ymlFiles = glob($path);
if (!is_array($ymlFiles) || !count($ymlFiles)) {
    exit('No "module.yml" files found for '.$path.PHP_EOL.PHP_EOL);
}

require_once 'Spyc.php';

$path = __DIR__.'/modules.db';
if (!file_exists($path) || !is_readable($path)) {
    exit('Sqlite db file not available or readable!'.PHP_EOL.PHP_EOL);
}

$releases = [];

foreach ($ymlFiles as $key => $value) {
    
    $obj = Spyc::YAMLLoad($value);
    
    $releases[ $obj['key'] ] = prepareData($obj);
    
}

$yamlPath = __DIR__.'/release'.($dest ?? '').'.yml';
if ( !file_put_contents( $yamlPath,  '## FanPress CM module package source data' . PHP_EOL . Spyc::YAMLDump($releases) ) ) {
    exit('Failed to create '.$yamlPath.'!'.PHP_EOL.PHP_EOL);
}

function prepareData($obj) {
    
    global $pkg_build;

    printf(">> Module %s > %s - %s \n\n", $obj['name'], $obj['key'], $obj['version']);

    $mkey = str_replace('/', '_', $obj['key']);

    $pkgUrl = "https://updates.nobody-knows.org/fanpress/modules/packages/v5/{$mkey}_version{$obj['version']}.zip";
    
    list($vendor, $key) = explode('/', $obj['key']);
   
    exec(sprintf("%s/fanpress4_pkg -m %s %s %s \n\n", $pkg_build, $vendor, $key, $obj['version']), $cliout);
    
    $hash = preg_replace('/(\ {4}hash:\ )/i', '', array_slice($cliout, -4, 1)[0])  ;
    $signature = preg_replace('/(\ {4}signature:\ )/i', '', array_slice($cliout, -3, 1)[0])  ;

    return [
        'packageUrl' => $pkgUrl,
        'signature' => $signature,
        'hash' => $hash,
        'author' => $obj['author'],
        'name' => $obj['name'],
        'description' => $obj['description'],
        'link' => $obj['link'],
        'version' => $obj['version'],
        'requirements' => [
            'system' => $obj['requirements']['system'],
            'php' => $obj['requirements']['php']
        ]
    ];

}
