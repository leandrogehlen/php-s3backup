#!/usr/bin/php

<?php

error_reporting(-1);

require './vendor/autoload.php';

use Aws\Common\Enum\Region;
use S3Backup\S3Backup;
use Aws\S3\Exception\S3Exception;


define('AWS_KEY', 'place access key here');
define('AWS_SECRET_KEY', 'place secret key here');

$params = getopt(null, array(
    "bucket:",
    "file:",
    "clear:",
    "dir:"
));

$backup = new S3Backup(
    AWS_KEY,
    AWS_SECRET_KEY,
    Region::VIRGINIA
);

if (isset($params['clear']) && isset($params['bucket'])){
    $backup->clear($params['bucket'], $params['dir'], $params['clear']);
}
else if(isset($params['file']) && isset($params['bucket'])){
    try {
        $result = $backup->send($params['bucket'], $params['dir'], $params['file']);
        echo $result['ObjectURL'];
    } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
    }
}
else {
    print("--bucket= --file=\tSend file to bucket\n");
    print("--clear=\t\t\tRemove all files to bucket with last modified\n");
}