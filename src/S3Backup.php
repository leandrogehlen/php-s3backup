<?php

namespace S3Backup;

use Aws\S3\S3Client;

class S3Backup
{
    private $_client;

    public function __construct($key, $secret, $region)
    {
        $this->_client = S3Client::factory(array(
            'key' => $key,
            'secret' => $secret,
        ));

        $this->_client->setRegion($region);
    }

    public function clear($bucket, $dir, $days)
    {
        $params = array('Bucket' => $bucket);
        if ($dir) {
            $params["Prefix"] = $dir;
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

    public function send($bucket, $dir, $file)
    {
        $filename = basename($file);

        return $this->_client->putObject(array(
            'Bucket' => $bucket,
            'Key' => $dir . '/' . $filename,
            'SourceFile' => $file
        ));
        //echo $result['ObjectURL'] . "\n";
    }

} 