<?php

return [
    'maxSize' => '2M',
    'allowedTypes' => [
        'image/jpeg',
        'image/png'
    ],
    'maxResolution' => '800x600',
    'dirPath' => dirname(__DIR__, 2) . '/public/uploads'
];
