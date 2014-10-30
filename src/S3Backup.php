<?php

namespace S3Backup;

use Aws\S3\S3Client;

class S3Backup
{
    private $_client;

    public function __construct($key, $secret)
    {
        $this->_client = S3Client::factory(array(
            'key' => $key,
            'secret' => $secret,
        ));
    }

    public function clear($bucket, $folder, $days)
    {
        $params = array('Bucket' => $bucket);
        if ($folder) {
            $params["Prefix"] = $folder;
        }

        $objects = $this->_client->getIterator('ListObjects', $params);

        foreach ($objects as $obj) {
            $last = strtotime($obj['LastModified']);
            $base = date("Y-m-d");
            $base = strtotime(date("Y-m-d", strtotime($base)) . "-" . $days . " day");

            if (!$days || $last < $base) {
                $this->_client->deleteObject(array(
                    'Bucket' => $bucket,
                    'Key' => $obj['Key']
                ));
            }
        }
    }

    public function send($bucket, $folder, $file)
    {
        $key = basename($file);
        if ($folder) {
            $key = $folder . '/' . $key;
        }

        return $this->_client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $file
        ));
    }

} 