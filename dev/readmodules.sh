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
$req_system = $argv[3] ?? '';

if (!$path) {
    exit('Missing path as first parameter'.PHP_EOL.PHP_EOL);
}

$path = realpath($path);
if (!trim($path)) {
    exit('Path '.$path.' does not exists'.PHP_EOL.PHP_EOL);
}

if (!trim($req_system)) {
    readline('No required system version was entered, you want to continue?');
}

$path .= '/*/module.yml';

$ymlFiles = glob($path);
if (!is_array($ymlFiles) || !count($ymlFiles)) {
    exit('No "module.yml" files found for '.$path.PHP_EOL.PHP_EOL);
}

require_once 'Spyc.php';
array_map('showMetaData', $ymlFiles);

function showMetaData(string $fileName) {
    
    global $req_system, $pkg_build;

    $obj = Spyc::YAMLLoad($fileName);
    
    print PHP_EOL . '>> Module '.strtoupper($obj['key']) . ' - ' . $obj['version'] .PHP_EOL;
    

    $mkey = str_replace('/', '_', $obj['key']);

    $pkgUrl = "https://updates.nobody-knows.org/fanpress/modules/packages/v5/{$mkey}_version{$obj['version']}.zip";
    
    list($vendor, $key) = explode('/', $obj['key']);
   
    exec(sprintf("%s/fanpress4_pkg -m %s %s %s \n\n", $pkg_build, $vendor, $key, $obj['version']), $cliout);
    
    $hash = preg_replace('/(\ {4}hash:\ )/i', '', array_slice($cliout, -4, 1)[0])  ;
    $signature = preg_replace('/(\ {4}signature:\ )/i', '', array_slice($cliout, -3, 1)[0])  ;
    
    $data = [
        'modkey' => $obj['key'],
        'version' => $obj['version'],
        'name' => $obj['name'],
        'author' => $obj['author'],
        'link' => $obj['link'],
        'description' => $obj['description'],
        'hash' => $hash,
        'signature' => $signature,
        'packageUrl' => $pkgUrl,
        'req_system' => $obj['requirements']['system'],
        'req_php' => $obj['requirements']['php'],
        'active' => 1,
    ];
    
    if (!trim($req_system)) {
        $req_system = $obj['requirements']['system'];
    }
    

    print PHP_EOL. "Insert statements:".PHP_EOL.PHP_EOL;
    printf("INSERT INTO modules (%s) VALUES (%s);", '`' . implode('`, `', array_keys($data)) . '`', "'" . implode("', '", array_values($data)  )  . "'" ).PHP_EOL;

    print PHP_EOL . PHP_EOL . "Update statement:".PHP_EOL.PHP_EOL;

    $modKey = $data['modkey'];
    unset($data['modkey']);
    
    foreach ($data as $key => $value) {
        printf("UPDATE modules SET `%s` = '%s' where `modkey` = '%s' AND (req_system = '%s' or req_system = '%s');\n", $key, $value, $modKey, $obj['requirements']['system'], $req_system);
    }
   
    print PHP_EOL.'= = = = ='.PHP_EOL;
}