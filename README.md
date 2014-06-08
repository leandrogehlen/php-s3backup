S3backup
========

Script to send files to AmazonS3

## Usage

Send file

```
php backup.php --region="us-east-1" --bucket="my_bucket" --folder="backup_folder" --file="/path/to/file"
```

Clear files

```
php backup.php --region="us-east-1" --clear=5 --bucket="my_bucket" --folder="backup_folder"
```

## Parameters

`--bucket`: Bucket name

`--folder`: Folder contained in bucket 

`--clear`: Number of days that the files will be maintained

`--region`: Region code (see: http://docs.aws.amazon.com/AWSEC2/latest/UserGuide/using-regions-availability-zones.html)
