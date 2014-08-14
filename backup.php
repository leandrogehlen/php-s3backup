#!/usr/bin/php

<?php

error_reporting(-1);

require  __DIR__.'/vendor/autoload.php';

use Aws\S3\Exception\S3Exception;
use S3Backup\S3Backup;

define('AWS_KEY', 'place access key here');
define('AWS_SECRET_KEY', 'place secret key here');

$params = getopt(null, array(
    "bucket:",
    "file:",
    "clear:",
    "folder:",
    "region:"
));

$backup = new S3Backup(
    AWS_KEY,
    AWS_SECRET_KEY,
    $params['region']
);

if (isset($params['clear']) && isset($params['bucket'])){
    $backup->clear($params['bucket'], $params['folder'], $params['clear']);
}
else if(isset($params['file']) && isset($params['bucket'])){
    try {
        $result = $backup->send($params['bucket'], $params['folder'], $params['file']);
        echo $result['ObjectURL'];
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
}
else {
    print("--bucket= --file=\tSend file to bucket\n");
    print("--clear=\t\t\tRemove all files to bucket with last modified\n");
}
