S3backup
========

Script to send files to AmazonS3

## Usage

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
