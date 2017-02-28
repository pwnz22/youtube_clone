<?php

return [
    'buckets' => [
        'videos' => 'https://s3-us-west-2.amazonaws.com/videoss.youtubeclone.com',
        'images' => 'https://s3.ap-northeast-2.amazonaws.com/images.youtubeclone.com'
    ],
    'localBuckets' => [
        'videos' => storage_path() . '/uploads'
    ]
];