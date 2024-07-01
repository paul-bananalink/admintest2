<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ValidationExtendServiceProvider::class,
    Mews\Captcha\CaptchaServiceProvider::class,
    UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
];
