<?php

namespace leandrogehlen;

use Aws\S3\S3Client;

/**
 * Encapsulates methods to send and clean files from Amazon S3 service
 * @author Leandro Gehlen <leandrogehlen@gmail.com>
 */
class S3Backup
{
    /** @var S3Client the Amazon S3 client instance */
    private $_client;

    /**
     * Creates Amazon S3 client instance
     * @param array|\Guzzle\Common\Collection $config Client configuration data
     */
    public function __construct($config)
    {
        $this->_client = S3Client::factory($config);
    }

    /**
     * Remove files from Amazon S3
     * @param string $bucket the bucket name
     * @param string $folder the folder localization
     * @param int $days number of days to keep files
     */
    public function clear($bucket, $folder, $days)
    {
        $params = array('Bucket' => $bucket);
        if ($folder) {
            $params["Prefix"] = $folder;
        }

        $base = strtotime(date("Y-m-d") . " -" . $days . " days");
        $objects = $this->_client->getIterator('ListObjects', $params);

        foreach ($objects as $obj) {
            $last = strtotime($obj['LastModified']);

            if (!$days || $last < $base) {
                $this->_client->deleteObject(array(
                    'Bucket' => $bucket,
                    'Key' => $obj['Key']
                ));
            }
        }
    }

    /**
     * Send files to Amazon S3
     * @param string $bucket the bucket name
     * @param string $folder the folder localization
     * @param string $file the local file path
     * @return \Guzzle\Service\Resource\Model
     */
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