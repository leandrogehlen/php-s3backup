#!/usr/bin/php

<?php

error_reporting(-1);

require  __DIR__.'/vendor/autoload.php';

use Aws\S3\Exception\S3Exception;
use S3Backup\S3Backup;

$params = getopt(null, array(
    "bucket:",
    "file:",
    "clear:",
    "folder:"
));

$folder = isset($params['folder']) ? $params['folder'] : null;
$config = include __DIR__ . '/config.php';
$backup = new S3Backup($config);

if (isset($params['clear'], $params['bucket'])){
    $backup->clear($params['bucket'], $folder, $params['clear']);
}
else if(isset($params['file'], $params['bucket'])){
    try {
        $backup->send($params['bucket'], $folder, $params['file']);
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
}
else {
    print("--bucket= --file=\tSend file to bucket\n");
    print("--clear=\t\t\tRemove all files to bucket with last modified\n");
}
