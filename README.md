S3backup
========

Script to send files to AmazonS3

> It is necessary install php cURL extension

> If you use linux distribution based on debian then: `sudo apt-get install php5-curl`


## Usage

It's necessary to create configuration file, into base directory, named `config.php`.
Example:

```php

<?php

return [
    'key' => 'place the access key here',
    'secret' => 'place the secret key here',
    'region' => 'place the region'
];

```

Send file

```
php backup.php --bucket="my_bucket" --folder="backup_folder" --file="/path/to/file"
```

Clear files

```
php backup.php --clear=5 --bucket="my_bucket" --folder="backup_folder"
```

## Parameters

`--bucket`: Bucket name

`--folder`: Folder contained in bucket 

`--clear`: Number of days that the files will be maintained
